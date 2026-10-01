<?php

namespace app\controllers;
use app\models\Main;

class MainController extends AppController
{
    public function __construct($route){
        parent::__construct($route);
        $this->model = new Main();
    }

    public function indexAction(){
        $this->setMeta('Анки - изучай английский по карточкам', 'Продвинутые карточки для изучения английского языка');

    }

}