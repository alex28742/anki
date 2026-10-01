<?php

namespace app\controllers;
use app\models\Diary;

class DiaryController extends AppController
{
    public function __construct($route){
        parent::__construct($route);
        $this->model = new Diary();
    }

    public function indexAction(){
        $this->setMeta('title', 'diary');

    }

}