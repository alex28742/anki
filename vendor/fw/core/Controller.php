<?php

namespace fw\core;

use fw\libs\Helper;

abstract class Controller
{
    public $route = [];
    public $view; // view name
    public $model; // model
    public $layout; // layout name
    public $vars = [];// data passed to the view
    public static $meta = []; // title/description meta tags
    public function __construct(array $route){
        $this->route = $route;
        $this->view = $route['action'];
    }
    // creates the View and renders it (called from Router::dispatch)
    public function getView(){
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render($this->vars, self::$meta);
    }

    // data passed from an action to its view
    public function setData($vars){
        $this->vars = $vars;
    }

    public function setMeta($title, $description){
        self::$meta = ['title' => $title, 'description' => $description];
    }

    /** Renders an arbitrary view file
     * @param string $view view name
     * @param array $vars variables to pass to the view
     * @return void
     */
    public function loadView($view, $vars = []){
        extract($vars);
        require_once APP ."/views/{$this->route['controller']}/{$view}.php";
    }

}
