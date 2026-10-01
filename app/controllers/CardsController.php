<?php

namespace app\controllers;

use app\models\Cards;
use fw\libs\Helper;

class CardsController extends AppController
{

    private $panel = []; // data shown in the side panel (shared across actions)
    public $user;
    public function __construct($route){
        parent::__construct($route);
        $this->layout = 'anki';
        $this->model = new Cards();
        $this->panelInfo(); // base data for the panel
        $this->studyInit(); // check the date, reset daily counters
        if(isset($_SESSION['user']))
            $this->user = $_SESSION['user'];
        else $this->user = false;
    }

    // runs at the start of a study session: resets some per-day DB state
    public function studyInit(){
        if(isset($_SESSION['user'])) $userid = $_SESSION['user']['id']; else $userid = false;
        $settings = $this->model->db::findOne('settings', "WHERE `userid` = ?", [$userid]);
    }


    public function indexAction(){
        $this->includePanel();
    }

    public function doublesAction(){
        $doubles = $this->model->findDoubles();
        $this->setData(compact(['doubles']));
    }

    // includes the shared panel data
    public function includePanel(){
        $panel = $this->panel;
        $settings = $this->model->db::findOne('settings', 'WHERE `userid` = ?', [Helper::getUserID()]);
        $progress = $this->proScale();
        $this->setData(compact('panel', 'settings', 'progress'));
    }

    public function panelInfo(){
        $settings = $this->model->db::findOne('settings', 'WHERE `userid` = ?', [Helper::getUserID()]);

        $this->panel['total_cards'] = \R::count('cards', 'WHERE `userid` = ?',[Helper::getUserID()]);
        $this->panel['cloud_items'] = \R::count('cloud', 'WHERE `userid` = ?',[Helper::getUserID()]);
        $this->panel['dictionary_items'] = \R::count('dictionary', 'WHERE `userid` = ?',[Helper::getUserID()]);

        $this->panel['decks'] = \R::count('decks');
        $this->panel['user'] = Helper::getUserID();
        $statistics = $this->model->db::find('statistics', 'WHERE `userid` = ? ORDER BY `lastactive` DESC LIMIT 1' ,
            [Helper::getUserID()]);
        $this->panel['statistics'] = $this->model->db::exportAll($statistics);
        // look for duplicate cards
        $res = $this->model->findDoubles();
        if ($res) $this->panel['doubles_cards'] = $res;

        // how many cards are due for study today
        $this->panel['cards_to_study'] = $this->model->cardsToStudy();

    }

    // sends a card back into the waiting list (from /cards/view)
    public function repeatAction(){
        if($this->isAjax() && !empty($_POST)){
            $id = $_POST['id'];
            $card = $this->model->db::load('cards', $id);
            $card->waitinglist = time();
            echo $this->model->db::store($card);
        }
        $this->layout = false;
    }

    // grammar rules the user wants to remember
    public function rulesAction(){
        $articles = $this->model->db::findAll('rules');
        $this->setData(compact(['articles']));
    }

    // adding a new card
    public function addAction(){
        $this->includePanel();
        if($this->isAjax()){
            $card = $this->model->db::dispense('cards');
            // fields from the add-card form (see views/cards/add.php)
            $card->front = strip_tags(trim($_POST['front']));
            $card->back = strip_tags(trim($_POST['back']));
            $card->queue = strip_tags(trim($_POST['queue']));
            $card->nextshow = time(); // next scheduled review time
            $card->totalrepeat = 0; // total number of repetitions
            $card->countdayrepeat = 0; // repetitions today (reset daily)
            $card->datecreate = date('d-m-Y'); // creation date (never changed afterwards)
            $card->lastdayrepeat = date('d-m-Y'); // date of the last repetition
            $card->userid = Helper::getUserID();
            $res = $this->model->db::store($card);
            if($res){ // update today's stats
                $stat = $this->model->getStatItem();
                $stat->addednewcard += 1;
                $this->model->db::store($stat);
            }

            // card was added from the cloud - remove it from there once saved
            if(isset($_SESSION['cloud_id']) && $res){
                $id = $_SESSION['cloud_id'];
                $cloud = $this->model->db::load('cloud', $id);
                $this->model->db::trash($cloud);
                unset($_SESSION['cloud_id']);
            }
            $this->layout = false;
        }
    }

    // all cards for the current user
    public function viewAction(){
        $cards = $this->model->db::find('cards', 'WHERE `userid` = ? ORDER BY `nextshow` ASC', [Helper::getUserID()]);
        $settings = $this->model->db::findOne('settings', 'WHERE `userid` = ?', [Helper::getUserID()]);
        $this->setData(compact(['cards', 'settings']));
    }

    public function delAction(){
        if($this->isAjax() && $_POST['del']){
            $id = $_POST['del'];
            $card = $this->model->db::load('cards', $id);
            if(is_object($card)){
                $this->model->db::trash($card);
            }
        }
        $this->layout = false;
        exit;
    }

    // the study screen (renders views/cards/list.php)
    public function listAction(){
       Helper::noCache();
        $card = $this->model->getNext(); // either the next card, or false
        // first repetition today for this card - reset the daily counter
        if(is_object($card) && $card->lastdayrepeat != date('d-m-Y')){
            $card->countdayrepeat = 0;
            $this->model->db::store($card);
        }

        // dictionary words found on this card, across all users' dictionaries
        if($card === false) $card['back'] = "";
        $dictionary = $this->model->getDictionaryExt($card['back'], true);

        // ... and in the current user's own dictionary
        $own_dictionary = $this->model->getDictionaryExt($card['back'], false);

        $settings = $this->model->db::findOne('settings', 'WHERE `userid` = ?', [Helper::getUserID()]);
        $this->setData(compact(['card','dictionary', 'own_dictionary', 'settings']));
    }

    // pulls the next card off the study queue (ajax)
    public function getAction(){
        if($this->isAjax()){
            Helper::noCache();
            $this->model->shift($_POST); // reschedule the card that was just answered

            $card = $this->model->getNext();
            if($card === false){
                $clouds = \R::count('cloud');
                // this used to embed a PHP tag directly inside the die() string -
                // a tag inside a string literal is never executed, just printed as
                // literal text, so the "add from cloud" link always showed up even
                // when the cloud was empty
                $cloudLink = $clouds ? "<a href='/cards/cloudList'>Добавить из облака</a>" : "";
                die("<br><div class='alert alert-success'>На сегодня все! $cloudLink</div>");
            }
            $card->waitinglist = null;
            $this->model->db::store($card);

            // dictionary words found on this card, across all users' dictionaries
            $dictionary = $this->model->getDictionaryExt($card['back'], true);

            // ... and in the current user's own dictionary
            $own_dictionary = $this->model->getDictionaryExt($card['back'], false);

            // first repetition today - bump the date and reset the daily counter
            if($card->lastdayrepeat != date('d-m-Y')){
                $card->lastdayrepeat = date('d-m-Y');
                $card->countdayrepeat = 0;
                $this->model->db::store($card);
            }

            if(isset($_SESSION['user'])) $userid = $_SESSION['user']['id']; else $userid = false;
            $settings = $this->model->db::findOne('settings', 'WHERE `userid` = ?', [$userid]);
            $this->loadView('get', compact(['card','dictionary', 'own_dictionary', 'settings']));

        }
        $this->view = false; // already rendered via loadView() above, skip the automatic re-render
        $this->layout = false;
    }

    // cards whose text contains a given word
    public function bywordAction(){
        if($this->isAjax() && !empty($_POST)){
            $words = $_POST;
            $cards = $this->model->getCardsByWord($words);
            $this->loadView('byword', compact(['cards','words']));
        }

        $this->view = false;
        $this->layout = false;
    }

    // cloud phrases that contain a given word
    public function bywordincloudAction(){
        if($this->isAjax() && !empty($_POST)){
            $words = $_POST;
            $items = $this->model->getItemsCloudByWord($words);
            $this->loadView('itemclouds', compact(['items', 'words']));
        }
        $this->view = false;
        $this->layout = false;
    }


    // inline edit of a card
    public function editAction(){
        $this->includePanel();
        if($this->isAjax() && $_POST['id']){
            $id = $_POST['id'];
            $card = $this->model->db::load('cards', $id);
            $card->front = strip_tags(trim($_POST['top']));
            $card->back = strip_tags(trim($_POST['back']));
            $this->model->db::store($card);
        }
        $this->layout = false;
        exit;
    }

    // saves a phrase to the cloud (a scratch area for text to turn into cards later)
    public function cloudAction(){
        $this->includePanel();
        if($this->isAjax()){
            $val = $this->model->clearData($_POST['cloud']);
            $cloud = $this->model->db::dispense('cloud');
            $cloud->text = $val;
            $cloud->userid = $_SESSION['user']['id'];
            $res = $this->model->db::store($cloud);
            if($res){ // update today's stats
                $stat = $this->model->getStatItem();
                $stat->addedcloud += 1;
                $this->model->db::store($stat);
            }
            exit;
        }
        $this->layout = false;
    }

    // the cloud list page
    public function cloudListAction(){
        if(!$this->isAjax()){
            $clouds = $this->model->db::find('cloud','WHERE `userid` = ? ORDER BY `id` DESC', [Helper::getUserID()]);
            if(isset($_GET['word'])){
                $word = Helper::clearData($_GET['word']);
            }else{
                $word = "";
            }

            $panel = $this->panel;
            $settings = $this->model->db::findOne('settings', 'WHERE `userid` = ?', [Helper::getUserID()]);
            $this->setData(compact('clouds', 'panel', 'word', 'settings'));
        }
        if($this->isAjax() && !empty($_POST)){
            // delete a cloud entry
            if(isset($_POST['delete'])){
                $id = $_POST['delete'];
                $item = $this->model->db::load('cloud', $id);
                $this->model->db::trash($item);
                exit;
            }
            // turn a cloud entry into a card
            if(isset($_POST['add'])){
                $id = $_POST['add'];
                $item = $this->model->db::load('cloud', $id);
                // hand the text off to the add-card screen via the session
                $_SESSION["cloud"] = $item['text'];
                $_SESSION["cloud_id"] = $id;
                // only remove it from the cloud once the card is actually saved
                // (deletion happens in addAction(), not here)
                //$this->model->db::trash($item);

                exit;
            }
            $this->layout = false;
        }
    }

    public function deleteAction(){
        if($this->isAjax() && !empty($_POST['id'])){
            $card = $this->model->db::load('cards', $_POST['id']);
            $this->model->db::trash($card);
            echo 'Удалено!';
        }
        $this->layout = false;
        exit;
    }

    public function searchAction(){
        $settings = $this->model->db::findOne('settings', 'WHERE `userid` = ?', [Helper::getUserID()]);
        $this->setData(compact('settings'));
    }


    // global search (/cards/search)
    public function requestAction(){
        if($this->isAjax() && !empty($_POST['word'])){

           $words = $_POST;
           // minimum query length
           if(iconv_strlen($words['word']) < 3){
               exit;
           }
           $settings = $this->model->db::findOne('settings', 'WHERE `userid` = ?', [Helper::getUserID()]);
           $settings = $this->model->db::exportAll($settings);

           // search the dictionary
            if($settings[0]['fdic'])
                $dictionary  = $this->model->getDictionaryExt($words['word'], false);
            else $dictionary = [];

            // search cards
            if($settings[0]['fcards'])
                $cards = $this->model->getCardsByWord($words);
            else $cards = [];

            // search cloud phrases
            if($settings[0]['fcloud'])
                $clouds = $this->model->getItemsCloudByWord($words);
            else $clouds = [];

            if(isset($_POST['template']) && $_POST['template'] == "simple")
                $this->loadView('request-simple', compact(['dictionary', 'cards', 'clouds', 'settings', 'words']));
            else
                $this->loadView('request', compact(['dictionary', 'cards', 'clouds', 'settings', 'words']));
        }

        $this->view = false;
        $this->layout = false;
    }



    public function settingsAction(){
        if($this->isAjax()){

            $settings = $this->model->db::findOne('settings', 'WHERE `userid` = ?', [Helper::getUserID()]);
            $settings->showpanel = isset($_POST["showpanel"]) ?: false;

            $this->model->db::store($settings);
            exit();
        }
        $settings = $this->model->db::findOne('settings', 'WHERE `userid` = ?', [Helper::getUserID()]);
        $this->setData(compact('settings'));
    }

    /** When adding a card, check which of its words already exist in the dictionary
     * @return void
     */
    public function checkAction(){
        if(!empty($_POST)){
            $array_data = $this->model->splitSentence($_POST['data']);
            $sentence = '';
            if($array_data[0] != ''){
                foreach ($array_data as $item) {
                    $beans = $this->model->getDictionaryExt($item);
                        foreach ($beans as $bean){
                            $sentence .= ' ' . $bean['word'];
                        }
                }
                echo $sentence; // words found in the dictionary, for display
            }
        }
        $this->layout = false;
    }

    // study activity over the last few days
    public function proScale($limit = 5):array{
        $maxWell = $this->model->db::findOne('statistics', 'WHERE `userid` = ? ORDER BY `cardswell` DESC',
            [Helper::getUserID()]);
        $maxHard = $this->model->db::findOne('statistics', 'WHERE `userid` = ? ORDER BY `cardshard` DESC',
            [Helper::getUserID()]);

        $progress = $this->model->db::find('statistics', "WHERE `userid` = ? ORDER BY `lastactive` DESC LIMIT $limit",
            [Helper::getUserID
        ()]);

        if($maxWell === null || $maxHard === null || !count($progress))
            return [];

        $res['cardswell'] = $maxWell['cardswell'];
        $res['cardshard'] = $maxWell['cardshard'];
        $res['history'] = $this->model->db::exportAll($progress);

        return $res;
    }

    // changelog page ("What's done")
    public function reportAction(){

    }

}
