<?php

namespace app\controllers;
use app\models\Mistakes;
use fw\libs\Helper;

class MistakesController extends AppController
{
    public function __construct($route){
        parent::__construct($route);
        $this->model = new Mistakes();
        $this->layout = 'mistakes';
    }

    public function indexAction(){
        $this->setMeta('Мои ошибки', 'description');
        $mistakes = $this->getList();

        $this->setData(compact(['mistakes']));
    }

    public function getList():array{
        $userid = Helper::getUserID();
        return $this->model->db::find('mistakes', 'WHERE `userid` = ? ORDER BY `datecreate` DESC', [$userid]);
    }

    public function detailAction(){
        $mistake = null;
        if(!empty($_GET) && isset($_GET['id'])){
            $mistake = $this->model->db::load('mistakes', $_GET['id']);
        }
        // no id given, or no matching record - nothing to show
        if(!is_object($mistake) || !$mistake->id){
            Helper::redirect('/mistakes');
        }
        $this->setData(compact(['mistake']));
    }

    // fields a mistake record actually has (see views/mistakes/detail.php, index.php)
    private const ALLOWED_FIELDS = ['description', 'lesson', 'conclusion', 'helpful'];

    public function addAction(){
        $userid = Helper::getUserID();
        if($this->isAjax() && !empty($_POST)){
            $mistake = $this->model->db::dispense('mistakes');
            foreach(self::ALLOWED_FIELDS as $key){
                if(isset($_POST[$key]))
                    $mistake->$key = Helper::clearData($_POST[$key]);
            }
            $mistake->userid = $userid;
            $mistake->datecreate = time();
            $res = $this->model->db::store($mistake);
            echo $res;
        }

        $this->layout = false;
    }

}