<?php

namespace app\models;

use fw\core\Model;
use fw\libs\Helper;

class Dictionary extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTotalInfo(){
        return $dictionary = $this->db::findAll('dictionary');
    }

    // a fresh row for today's statistics
    public function newStaticDay():object{
        $stat = $this->db::dispense('statistics');
        $stat->lastactivedate = date('d-m-Y');
        $stat->lastactive = time();
        $stat->userid = Helper::getUserID();
        $stat->cardswell = 0;
        $stat->cardshard = 0;
        $stat->planperday = 20;
        $stat->addednewcard = 0;
        $stat->addedcloud = 0;
        $stat->addedwords = 0;
        return $stat;
    }

    // today's statistics row, or a new one if today hasn't started yet
    public function getStatItem():object{
        $stat = $this->db::findOne('statistics', 'WHERE `userid` = ? AND `lastactivedate` = ?', [Helper::getUserID(), date('d-m-Y')]);
        if($stat === NULL){
            $stat = $this->newStaticDay();
        }
        return $stat;
    }



    /**
     * @param $post
     * @return int
     * @throws \RedBeanPHP\RedException\SQL
     */
    public function addWord($post){
        $isset = $this->db::findOne('dictionary', "WHERE `word` = ? AND `userid` = ?", [$post["word"], Helper::getUserID()]);
        if($isset !== null){
            echo "Слово уже присутствует в словаре!";
        }else{
            $dictionary = $this->db::dispense('dictionary');
            $dictionary->word = strip_tags(trim($post['word']));
            $dictionary->pronounce = strip_tags(trim($post['pronounce']));
            $dictionary->meaning = strip_tags(trim($post['meaning']));
            $dictionary->definition = strip_tags(trim($post['definition']));
            $dictionary->userid = Helper::getUserID();
            $dictionary->tough_selection = 0;
            return $this->db::store($dictionary);
        }
        return 0;
    }

    /** Cards whose text contains a given word
     * @param string $word word to search for
     * @param string $field column to search in
     * @return array array of beans
     */
    public function findCardsByWord(string $word, string $field, $userid): array{
        // a few words need surrounding spaces to avoid matching inside unrelated words
        if($word == 'ever' || $word  == 'rest' || $word == 'bee' || $word == 'end'){
            return $this->db::find('cards', "$field LIKE ? AND `userid` = ?"  , ["% $word %", $userid]);
        }
        $res1 = $this->db::find('cards', "$field LIKE ? AND `userid` = ?"  , ["% $word%", $userid]);
        $res2 = $this->db::find('cards', "$field LIKE ? AND `userid` = ?"  , ["%$word %", $userid]);
        return $this->getUnique(array_merge($res1, $res2));
    }


    // the user's dictionary, with a count of how many cards contain each word
    public function getCountRes(): array{
        if(isset($_SESSION['user'])) $userid = $_SESSION['user']['id']; else $userid = false;
        $dictionary = $this->db::find('dictionary', 'WHERE `userid` = ? ORDER BY word ASC', [$userid]);
        $dictionary = $this->db::exportAll($dictionary);
       foreach($dictionary as $key => $item){
           $res = $this->findCardsByWord($item['word'], 'back', $userid);
           $res = $this->db::exportAll($res);
           $dictionary[$key]['count'] = count($res);
       }
       return $dictionary;
    }

    /** Cards matching a given word
     * @param array $words
     * @return array
     */
    public function getCardsByWord($word): array{
        if(isset($_SESSION['user'])) $userid = $_SESSION['user']['id']; else $userid = false;
        $res = [];
        // unlike Cards::getDictionaryExt(), this does not try word-ending
        // variations (s/ing/ed/...) - direct substring match only
        $res = $this->findCardsByWord($word, 'back', $userid);
        $res = $this->db::exportAll($res);
        return $this->getUnique($res);
    }

    /** Removes duplicates from an array, comparing by a given key
     * @param array $arr
     * @param string $id key to deduplicate on
     * @return array
     */
    public function getUnique(array $arr, string $id = 'id'): array
    {
        $res = [];
        $tmp = [];
        foreach ($arr as $item) {
            if (!in_array($item[$id], $tmp)) {
                $tmp[] = $item[$id];
                $res[] = $item;
            }
        }
        return $res;
    }
}
