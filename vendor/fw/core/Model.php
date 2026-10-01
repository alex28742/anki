<?php

namespace fw\core;

use RedBeanPHP\R;

class Model{
    public $db; // DB wrapper (RedBeanPHP facade)

    public function __construct(){
        $this->db = new DB();
    }
}
