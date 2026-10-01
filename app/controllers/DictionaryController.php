<?php

namespace app\controllers;
use app\models\Dictionary;

class DictionaryController extends AppController
{
    public function __construct($route)
    {
        parent::__construct($route);
        $this->layout = 'anki';
        $this->model = new Dictionary();
    }

    public function indexAction(){
        $totalInfo = $this->model->getTotalInfo();


        $this->setData(compact('totalInfo'));
    }

    public function addAction(){
        if($this->isAjax()){
            $post = $_POST;
            $res = $this->model->addWord($post);
            if($res){ // update today's stats
                $stat = $this->model->getStatItem();
                $stat->addedwords += 1;
                $this->model->db::store($stat);
            }
        }
        $this->layout = false;
    }

    // checks whether a word is already in the dictionary before adding it
    public function checkAction(){
        if($this->isAjax()){
            if(isset($_SESSION['user'])) $userid = $_SESSION['user']['id']; else $userid = false;
            $isset = $this->model->db::find('dictionary', "`word` = ? AND `userid` = ? LIMIT 1", [$_POST['data'],
                $userid]);
            if ($isset) {
                echo "<div class='alert alert-danger'>Слово уже в словаре</div>";
            }
        }

        $this->layout = false;
    }

    // the full dictionary list
    public function listAction(){

        $list = $this->model->getCountRes();
        $this->setData(compact('list'));
    }

    // removes a dictionary word
    public function deleteAction(){
        if($this->isAjax() && !empty($_POST['id'])){
            $word = $this->model->db::load('dictionary', $_POST['id']);
            $this->model->db::trash($word);
            echo 'Удалено!';
        }
        $this->layout = false;
        exit;
    }

    // cards referencing a given word
    public function bywordAction(){
        if($this->isAjax() && !empty($_POST)){
            $word = $_POST['word'];
            $cards = $this->model->getCardsByWord($word);
            $this->loadView('byword', compact(['cards','word']));
        }

        $this->view = false; // вид уже выведен через loadView(), повторный рендер не нужен
        $this->layout = false;
    }

    // edits a dictionary word
    public function editAction(){
        if($this->isAjax() && !empty($_POST)){
            $item = $this->model->db::load('dictionary', $_POST['id']);
            // fields from the edit_word modal (see views/layouts/include/modals.php)
            $item->word = strip_tags(trim($_POST['word']));
            $item->pronounce = strip_tags(trim($_POST['pronounce']));
            $item->meaning = strip_tags(trim($_POST['meaning']));
            $item->definition = strip_tags(trim($_POST['definition']));
            if(!$this->model->db::store($item))
                echo "Ошибка обновления";

        }
        $this->layout = false;
        exit;
    }
}