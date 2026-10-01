<?php

namespace app\models;

use fw\core\Model;
use fw\libs\Helper;

class Cards extends Model
{
    public $well = ''; // formatted delay for the "well" button, e.g. "< 2 days", "< 1.5 months"
    public $hard = '';
    public $repeat = '';
    public $easy = '';
    public $queue = 0; // computed pending interval
    public $exceptions = []; // words that must be matched with surrounding spaces only

    public function __construct(){
        parent::__construct();
        $this->setExceptions();
    }

    /** Flags words that must only match with spaces on both sides in LIKE queries
     * (short/common words would otherwise match as substrings of unrelated words)
     * @return void
     */
    public function setExceptions(): void{
        // user's own words marked for strict matching
        $words = $this->db::find('dictionary', 'WHERE `userid` = ? AND `tough_selection` = ?',
            [Helper::getUserID(), 1]);
        $words = $this->db::exportAll($words);
        $words = Helper::sepatateArrayByKey($words, 'word');
        // built-in defaults
        $prior = ['ever', 'rest', 'bee', 'end', 'rely', 'just', 'under', 'low', 'ought', 'favor', 'part', 'either', 'act', 'allow', 'pic', 'being', 'prior', 'seek', 'consider'];
        $joined = array_merge($words, $prior);
        $this->exceptions = array_unique($joined);
    }

    /** Picks the next card to study
     * @return false|mixed|null
     */
    public function getNext(){

        // first check the waiting list (cards that were deferred to a specific time)
        $card = $this->db::findOne('cards', 'WHERE `waitinglist` <= ? AND `userid` = ?', [time(), Helper::getUserID()]);

        if(!is_object($card)){ // nothing due in the waiting list - pull from the main queue
            $card = $this->db::findOne('cards', 'WHERE `userid` = ? AND `nextshow` <= ? ORDER BY `nextshow` ASC',
                [Helper::getUserID(), time()]);
        }
        if(!$card){
            // double-check whether the waiting list has anything at all
            $check = $this->db::exec('SELECT * FROM `cards` WHERE `waitinglist` IS NOT NULL AND `userid` = ?', [Helper::getUserID()]);

            if ($check) { // waiting-list cards exist, just none due yet
                $cards = $this->db::find('cards', 'WHERE `waitinglist` > ? AND `userid` = ?', [1, Helper::getUserID()]);
                if(!count($cards)) return false;
                $card = array_shift($cards);
                if(!is_object($card)) die("card is not object");
                if(!$card) return false;
            }else{ // nothing due and the waiting list is empty
                return false;
            }
        }
        return $card;
    }

    /** Dictionary entries referenced by a card
     * @param $data
     * @return array array of dictionary beans
     */
    public function getDictionary($data): array{
        $arr_words = $this->splitSentence($data);
        $dictionary = $this->db::findLike('dictionary', ['word' => $arr_words]);
        return $dictionary;
    }


    /** Cards whose text contains a given word
     * @param string $word word to search for
     * @param string $field column to search in
     * @return array array of beans
     */
    public function findCardsByWord(string $word, string $field): array{
        if(in_array($word, $this->exceptions)){
            return $this->db::find('cards', "$field LIKE ? AND `userid` = ?"  , ["% $word %", Helper::getUserID()]);
        }
        $res1 = $this->db::find('cards', "$field LIKE ? AND `userid` = ?"  , ["% $word%", Helper::getUserID()]);
        $res2 = $this->db::find('cards', "$field LIKE ? AND `userid` = ?"  , ["%$word %", Helper::getUserID()]);

        return array_merge($res1, $res2);

    }

    // same as findCardsByWord(), but searches cloud entries instead of cards
    public function findCloudCardsByWord($word, $field):array{
        if(in_array($word, $this->exceptions)){
            return $this->db::find('cloud', "$field LIKE ? AND `userid` = ?"  , ["% $word %", Helper::getUserID()]);
        }
        $res1 = $this->db::find('cloud', "$field LIKE ? AND `userid` = ?"  , ["% $word%", Helper::getUserID()]);
        $res2 = $this->db::find('cloud', "$field LIKE ? AND `userid` = ?"  , ["%$word %", Helper::getUserID()]);

        return array_merge($res1, $res2);

    }


    /** Removes duplicates from an array, comparing by a given key
     * @param array $arr
     * @param string $id key to deduplicate on
     * @return array
     */
    public function getUnique(array $arr, string $id = "id"):array{
        $res = []; $tmp = [];
        foreach ($arr as $item){
            if(!in_array($item[$id], $tmp)){
                $tmp[] = $item[$id];
                $res[] = $item;
            }
        }
        return $res;
    }

    /** Cards matching any of the given words
     * @param array $words
     * @return array
     */
    public function getCardsByWord(array $words): array{
        $res = [];
        foreach ($words as $word){
            $res = array_merge($res, $this->findCardsByWord($word, 'back'));
        }
        $res = $this->db::exportAll($res);
        // a card can match more than one word - drop duplicates
        return $this->getUnique($res);
    }

    // cloud phrases containing any of the given words
    public function getItemsCloudByWord(array $words):array{
        $res = [];
        foreach ($words as $word){
            $res = array_merge($res, $this->findCloudCardsByWord($word, 'text'));
        }
        $res = $this->db::exportAll($res);
        return $this->getUnique($res);
    }

    /** Words passed in as GET parameters
     * @return array
     */
    public function getListWordsFromGet(): array{
        $tmp = [];
        foreach ($_GET as $word){
            if($word === "") continue;
            $tmp[] = $word;
        }
        return $tmp;
    }

    /** Extended dictionary lookup that also tries common word-ending variations (s, ing, ...)
     * @param string $data card text to split into words and look up
     * @param bool $flag false = only the current user's dictionary, true = every user's
     * @return array
     */
    public function getDictionaryExt(string $data, bool $flag = false): array{
        if($data == '') return [];
        $userid = Helper::getUserID();
        $arr_words = $this->splitSentence($data);
        if($flag) { // every dictionary except the current user's own
            $dictionary = $this->db::findLike('dictionary', ['word' => $arr_words]);
            $tmp_dic = $this->db::exportAll($dictionary);
            $dictionary = [];
            foreach ($tmp_dic as $item){
                if($item['userid'] !== $userid)
                    $dictionary[] = $item;
            }
        }
        else {// current user's dictionary only
            $dictionary = $this->db::findLike('dictionary', ['word' => $arr_words, 'userid' => [$userid]], 'ORDER BY word ASC');
            $dictionary = $this->db::exportAll($dictionary);
        }
        $ends = ['s', 'ing', 'ed', 'ly', 'd', 'iful', 'lessly', 'ied', 'ped', 'ant', 'ted', 'e'];
        $tmp = []; // extra matches found by stripping word endings
        foreach ($ends as $end){
            foreach ($arr_words as $key => $word){
                if(strripos($word, $end))
                    $tmp[] = rtrim($word, $end);
                // handles endings where "ing" is dropped but a trailing "e" is added back (e.g. "making" -> "make")
                if($end == "ing" && strripos($word."e", $end)){
                    $tm = rtrim($word, $end);
                    $tmp[] = $tm."e";
                }

                // handles "dutiful" -> "duty"
                if ($end == 'iful' && strripos($word . 'y', $end)) {
                    $tm = rtrim($word, $end);
                    $tmp[] = $tm . 'y';
                }
                // handles "relied" -> "rely"
                if ($end == 'ied' && strripos($word . 'y', $end)) {
                    $tm = rtrim($word, $end);
                    $tmp[] = $tm . 'y';
                }
            }
        }
        if(!empty($tmp)){
            if($flag){
                $dictionary_ext = $this->db::findLike('dictionary', ['word' => $tmp]);

                $tmp_dic = $this->db::exportAll($dictionary_ext);
                $dictionary_ext = [];
                foreach ($tmp_dic as $item){
                    if($item['userid'] !== $userid)
                        $dictionary_ext[] = $item;
                }
            }
            else{
                $dictionary_ext = $this->db::findLike('dictionary', ['word' => $tmp, 'userid' => [$userid]], 'ORDER BY word ASC');
                $dictionary_ext = $this->db::exportAll($dictionary_ext);
            }

            if(!empty($dictionary_ext)){
                foreach($dictionary_ext as $item){
                    // skip anything already in $dictionary
                    if(!in_array($item, $dictionary))
                        $dictionary[] = $item;
                }

            }
        }

        // for each dictionary word, count how many cards contain it
        $cnt = 0;
        foreach ($dictionary as $item){
            $res = $this->findCardsByWord($item['word'], 'back');
            $res = $this->getUnique($this->db::exportAll($res));
            $dictionary[$cnt++]["count"] = count($res);
        }
        // ... and how many cloud phrases contain it
        $cnt = 0;
        foreach ($dictionary as $item){
            $res = $this->findCloudCardsByWord($item['word'], 'text');
            $res = $this->getUnique($this->db::exportAll($res));
            $dictionary[$cnt++]['cloud'] = count($res);
        }

        return $dictionary;
    }


    /** Splits text into an array of normalized words
     * @param string $data
     * @return array
     */
    public function splitSentence(string $data):array{
        // split on whitespace/commas and drop trailing punctuation
        $arr_words = preg_split('/[\s,]+/', rtrim($data, ',.!?'));
        foreach ($arr_words as $key => $word) {
            $arr_words[$key] = strtolower(trim($word, ',.!?'));
        }
        return $arr_words;
    }

    // how many cards are currently due for study
    public function cardsToStudy(): int{
        // cards due via nextshow
        $count = \R::count('cards', 'WHERE `nextshow` < ? AND `userid` = ? ', [time(), Helper::getUserID()]);
        // cards due via the waiting list
        $count_wl = \R::count('cards', 'WHERE `waitinglist` < ? AND `userid` = ? ', [time(), Helper::getUserID()]);
        return $count + $count_wl;
    }


    /** Formats the delay text shown on an answer button
     * @param $pending
     * @param $answer
     * @return void
     */
    public function setPengingBtn($pending, $answer){
        $time = $pending - time();
        $bnt_txt = "";
        if($time < TIME['hour']){ $bnt_txt = date('m') . ' мин'; }
       elseif ($time < TIME['day']){   $bnt_txt = date('H') . ' час'; }
       elseif($time < TIME['week']){  $bnt_txt = date('d') . ' дн'; }
       else{  $bnt_txt = date('m') . ' мес'; }

       if($answer == "well"){ $_SESSION['well'] = $bnt_txt; }
       elseif($answer == "hard"){ $_SESSION['hard'] = $bnt_txt; }
       else{  $_SESSION['repeat'] = $bnt_txt; }
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

    // records today's well/hard tally for a given answer
    public function setStatRepeat($answer){
        $stat = $this->getStatItem();
        $stat->lastactivedate = date('d-m-Y');
        $stat->lastactive = time();
        if($answer == "well" || $answer == "easy"){
            $stat->cardswell += 1;
        }else{ // hard or repeat
            $stat->cardshard += 1;
        }
        $this->db::store($stat);
    }


    /** Computes how long a card is deferred for, for each possible answer
     * Sets $this->well, $this->hard, $this->repeat, $this->easy
     * @param $card
     * @return void
     */
    public function preShift($card){
        if($card->queue == 0) $well = 1; else $well = $card->queue;
        $this->well = time() + (TIME['day'] * $well); // N days out
        $this->hard = time() + (TIME['min'] * 5); // 5 minutes
        $this->repeat = time() + (TIME['min'] * 1); // 1 minute
        $this->easy = time() + (TIME['month'] * 3) + (TIME['day'] * $well); // ~3 months out
    }

    /** The next queue value (interval multiplier) for a "well" answer
     * @param $card
     * @return int
     */
    public function getCardQueue($card):int{
        if($card->queue == 0) $well = 1; else $well = $card->queue;
        return round($well * 1.8);
    }

    /** Reschedules a card based on the user's answer */
    public function shift($post){
        $id = $post['id'];
        $answer = $post['answer'];
        $this->setStatRepeat($answer);
        $card = $this->db::load('cards', $id);
        $this->preShift($card); // compute well/hard/repeat/easy delays for this card

        // GREEN (WELL)
        if($answer == "well"){
            $card->queue = $this->getCardQueue($card);
            $this->preShift($card);
            $pending = $this->well;
            $card->nextshow = $pending; // deferred by several days or more
            $card->waitinglist = null;
        }

        if($answer == "easy"){
            $card->queue = $this->getCardQueue($card);
            $this->preShift($card);
            $pending = $this->easy;
            $card->nextshow = $pending;
            $card->waitinglist = null;
        }


        // YELLOW (HARD)
        if($answer == "hard"){
            // push it a week out so it doesn't get picked from the main queue today
            $card->nextshow = time() + (TIME["day"] * 7);
            $pending = $this->hard;
            $card->waitinglist = $pending; // but bring it back via the waiting list in a few minutes
            // lower its queue/interval
            if($card->queue > 2){
                $coefficient = 1.2;
                $card->queue = round($card->queue / $coefficient);
            }
        }

        // RED (REPEAT)
        if($answer == "repeat"){
            if($card->queue > 2){
                $coefficient = 1.8;
                $card->queue = round($card->queue / $coefficient);
            }
            $card->nextshow = time() + (TIME['day'] * 7);
            $panding = $this->repeat;
            $this->setPengingBtn($panding, $answer);
            $card->waitinglist = $panding; // back via the waiting list in ~1 minute
        }

        $card->totalrepeat += 1;
        $card->countdayrepeat += 1;

        $this->db::store($card);
    }

    // strips tags/whitespace before writing user input to the DB
    public function clearData($data):string{
        $data = strip_tags(trim($data));
        return str_replace("+", "", $data);
    }

    // finds cards with duplicate front/back text
    public function findDoubles(): array{
        $res = [];
        $count = 0;
        $ids = []; // ids already paired up, to avoid re-pairing them
        $cards = $this->db::find('cards', 'WHERE `userid` = ?', [Helper::getUserID()]);
        foreach ($cards as $left){
            foreach($cards as $right){
                if($left->id == $right->id) continue;
                if($left->front == $right->front || $left->back == $right->back){
                    if(!in_array($left->id, $ids))
                        $res[$count][0] = $left;
                    if(!in_array($right->id, $ids))
                        $res[$count][1] = $right;
                    $ids[] = $left->id;
                    $ids[] = $right->id;
                    $count++;
                }
            }
        }
        return $res;
    }


}
