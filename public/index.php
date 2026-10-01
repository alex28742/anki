<?php
session_start();
if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'admin')
    // E_DEPRECATED отдельно отключен: старая версия RedBeanPHP (dev-master)
    // массово шлет "Creation of dynamic property ... is deprecated" на PHP 8.1+ -
    // это шум из стороннего кода, а не из приложения, и не несет диагностической пользы
    error_reporting(E_ALL & ~E_DEPRECATED);
else error_reporting(0);

include($_SERVER['DOCUMENT_ROOT'] . "app/config/constants.php");
use fw\core\Router;

require_once __DIR__ ."/../vendor/autoload.php";
class_alias('\RedBeanPHP\R', '\R');

$query = trim($_SERVER['REQUEST_URI'], "/");



Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);


Router::dispatch($query);
