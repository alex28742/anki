<?php

namespace app\controllers;

use app\models\User;
use fw\libs\Helper;

class UserController extends AppController
{
    public $user;
    public function __construct($route)
    {
        parent::__construct($route);
        $this->model = new User();
        $this->layout = "anki";
        if(isset($_SESSION['user']))
            $this->user = $_SESSION['user'];
        else $this->user = false;
    }

    // login
    public function authAction(){
        if(!empty($_POST)){
            $res = $this->model->auth();
            if ($res) echo 'Y';
            else echo 'N';
        }
        else echo "N";
        $this->layout = false;
    }

    // log out
    public function exitAction(){
        unset($_SESSION['user']);
        Helper::redirect();
    }

    // profile page
    public function profileAction(){
        $user = $this->user;
        $settings = $this->model->db::findOne('settings', 'WHERE `userid` = ?', [Helper::getUserID()]);
        $this->setData(compact(['user', 'settings']));
    }

    // registration
    public function registerAction(){
        if(!empty($_POST)){
            // pick out the expected fields (fills model->user_data)
            $this->model->load($_POST);
            // validate (required fields, length) and check login/email are not already taken
            if(!$this->model->validate() || !$this->model->checkUnique()){
                $errors = $this->model->getErrors(); // rendered as a ul>li error list
                echo $errors;
                exit();
            }else{
                $this->model->user_data['passwd'] = password_hash($this->model->user_data["passwd"], PASSWORD_DEFAULT);
                $userid = $this->model->addUser();
                if($userid){
                    if(!$this->model->set_default_settings($userid)){
                        die('oшибка при сохранении настроек пользователя');
                    }
                    // auto-login right after a successful registration
                    if(!empty($_POST)){
                        $res = $this->model->auth();
                        if (!$res) echo 'N';
                    }
                    echo "<div class='alert alert-success'>Вы успешно зарегистрированы!</div>";
                } else{
                    echo "<div class='alert alert-danger'>Ошибка регистрации! Попробуйте позже</div>";
                }
            }
        }
        $this->layout = false;
        die();
    }

    // login/registration landing page
    public function personalAction(){
        $this->layout = 'default';
    }

    // settings this endpoint is allowed to toggle
    // (matches the checkboxes in views/user/profile.php and views/cards/search.php)
    private const ALLOWED_SETTINGS = ['showpanel', 'speaker', 'searchline', 'fdic', 'fcards', 'fcloud', 'showmydic'];

    // saves a single personal setting (used by the profile/search toggle checkboxes)
    public function settingsAction(){
        if($this->isAjax() && !empty($_POST)){
            if(isset($_POST["param_value"]) && !empty($_POST["param_name"])){
                $param_name = $_POST['param_name'];
                if(in_array($param_name, self::ALLOWED_SETTINGS, true)){
                    $settings = $this->model->db::findOne('settings', 'WHERE `userid` = ?', [Helper::getUserID()]);
                    $param_value = $_POST['param_value'];
                    if($param_value){ $settings->$param_name = 0; } else $settings->$param_name = 1;
                    echo $this->model->db::store($settings);
                }
                exit;
            }
        }
        $this->layout = false;
    }
}