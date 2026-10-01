<?php
namespace fw\core;

class Router
{
    public static $routes = [];
    public static $route = [];

    public static function add($pregx, $route = []){
        self::$routes[$pregx] = $route;
    }
    public static function getRoutes(){
        return self::$routes;
    }

    public static function getRoute(){
        return self::$route;
    }

    /** Matches a URL against the route table and resolves controller/action
     * @param $url
     * @return bool
     */
    public static function matchRoute($url){
        foreach (self::$routes as $pattern => $route) {
            if(preg_match("#$pattern#i", $url, $matches)){
                foreach($matches as $key => $val){
                    if(is_string($key))
                        self::$route[$key] = $val;
                }
                if(!isset(self::$route['controller']))
                    self::$route['controller'] = 'Main';
                if(!isset(self::$route['action']))
                    self::$route['action'] = 'index';
                return true;
            }
        }
        return false;
    }

    /** Entry point: instantiates the controller and runs the action
     * @param $url
     * @return void
     */
    public static function dispatch($url){
        if(self::matchRoute(self::removeQueryString($url))){
            // todo: an empty string doesn't resolve (should fall back to Main)
            $controller = "app\controllers\\".self::upperCamelCase(self::$route['controller']) . "Controller";
            if(class_exists($controller)){
                $cObj = new $controller(self::$route);
                $action = self::$route['action'] . "Action";
                if(method_exists($cObj, $action)){
                    $cObj->$action();
                    $cObj->getView();
                }else{
                    echo ("Метод <b>$action</b> не найден");
                }
            }else{
                echo ("Контроллер <b>$controller</b> не найден");
            }
        }else{
           http_response_code(404);
           if(file_exists('404.html'))
            include('404.html');
           else die('404 error');
        }
    }

    /** Converts a string to CamelCase (first letter capitalized)
     * @param string $name
     * @return string
     */
    public static function upperCamelCase(string $name){
        return ucwords(strtolower($name));
    }

    /** Strips the query string off a URL
     * @param $url
     * @return string
     */
    public static function removeQueryString($url){
        $string = explode("?", $url);
        return rtrim($string[0], "/");
    }

}
