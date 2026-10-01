<?php

namespace app\controllers;

use fw\core\Controller;

class AppController extends Controller
{
    public function __construct($route){
        parent::__construct($route);
    }

    /** Whether the current request is an AJAX request
     * @return bool
     */
    public function isAjax():bool{
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower
            ($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            return true;
        }
        return false;
    }

    /** Strips tags and surrounding whitespace
     * @param $data
     * @return string
     */
    public static function getClean($data):string{
        return strip_tags(trim($data));
    }

}