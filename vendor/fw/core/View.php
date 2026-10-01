<?php

namespace fw\core;

use fw\libs\Helper;

class View{
    public $route = []; // current route
    public $view; // current view name
    public $layout; // current layout name
    public $scripts = []; // scripts pulled out of the view
    public static $meta = [];

    public function __construct($route, $layout, $view){
        $this->route = $route;
        if($layout === false)
            $this->layout = false; // layout explicitly disabled
        else
            $this->layout = $layout ?: LAYOUT;
        $this->view = $view;
    }


    /** Renders the view and wraps it in the layout
     * @param array $vars data passed from the action to the view
     * @return void
     */
    public function render($vars, $meta = []){
        if(empty($meta)) self::$meta = ['title' => '', 'description' => ''];
            else self::$meta = $meta;
        if(is_array($vars) && !empty($vars)) extract($vars);
        $content = "";
        if($this->view !== false){
            $contr_lower = strtolower($this->route['controller']);
            $file_view = APP . "/views/{$contr_lower}/{$this->view}.php";
            ob_start();
            if (is_file($file_view))
                require $file_view; else echo 'Не найден вид ' . $file_view;
            $content = ob_get_clean();
        }
        if($this->layout !== false){
            $file_layout = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($file_layout)){
                $content = $this->getScript($content);
                $scripts = [];
                if(!empty($this->scripts[0])){
                    $scripts = $this->scripts[0];
                }
                require $file_layout;
            }
            else echo 'Не найден шаблон ' . $file_layout;
        }
    }

    public static function getMeta(){
        echo '<title>' . self::$meta['title'] . '</title>
        <meta name="description" content="'.self::$meta['description'].'">';
    }

    /** Extracts <script> tags from rendered content so the layout can place them explicitly
     * @param $content
     * @return array|mixed|string|string[]|null
     */
    protected function getScript($content){
        $pattern = '#<script.*?>.*?</script>#si';
        preg_match_all($pattern, $content, $this->scripts);
        if(!empty($this->scripts)){
            $content = preg_replace($pattern, '', $content);
        }
        return $content;
    }

}
