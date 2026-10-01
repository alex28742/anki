<?php

namespace app\models;

use fw\core\Model;
use Valitron\Validator;

class User extends Model
{
    public $attributes = []; // fields expected from the registration form
    public $user_data = []; // data collected from the form
    public $rules = []; // validation rules (required, length, etc.) - vlucas/valitron
    public $errors = []; // registration/validation errors
    public function __construct(){
        parent::__construct();
        $this->attributes = ["login" => "", "passwd" => "", "email" => "", "name" => "", "role" => "user"];
        $this->rules = [
            'required' => [
                ['login'],
                ['passwd'],
                ['email'],
            ],
            'email' => [
                ['email'],
            ],
            'lengthMin' => [
                ['passwd', 6]
            ]
        ];
    }

    /** Logs the current request's user in: validates the form, looks the user up, checks the password
     * @return bool
     */
    public function auth():bool{
       $login = !empty(trim($_POST['login'])) ? trim($_POST['login']) : null;
       $passwd = !empty(trim($_POST['passwd'])) ? trim($_POST['passwd']) : null;
       if($login && $passwd){
           $user = $this->db::findOne('user', 'login = ? LIMIT 1', [$login]);
           if($user){
               if(password_verify($passwd, $user->passwd)){
                   // store the user's data in the session (everything except the password)
                   foreach ($user as $k => $v){
                       if($k != "passwd") $_SESSION['user'][$k] = $v;
                   }
                   return true;
               }
           }
       }
       return false;
    }

    // picks the expected fields out of the registration POST into user_data[]
    public function load($post){
        foreach ($this->attributes as $name => $value) {
            if(isset($post[$name])){
                $this->user_data[$name] = $post[$name];
            }
        }
    }

    // validates the submitted registration fields
    public function validate(): bool{
        $v = new Validator($this->user_data);
        $v->rules($this->rules);
        if($v->validate()){
            return true;
        }
        $this->errors = $v->errors();
        return false;
    }

    // renders validation errors as an HTML list
    public function getErrors():string{
        $errors = "<ul class='alert alert-danger'>";
        // $this->errors is an array of arrays - a field can fail more than one rule
        foreach($this->errors as $error){
            foreach($error as $item){
                $errors .= "<li>$item</li>";
            }
        }
        $errors .= "</ul>";
        return $errors;
    }

    // creates a new user
    public function addUser():int{
        $user = $this->db::dispense('user');
        if(!empty($this->user_data)){
            foreach($this->attributes as $name => $value){
                if(isset($this->user_data[$name]))
                    $user->$name = $this->user_data[$name];
            }
        } else die('Невозможно добавить пользователя, т.к. не получены данные');
        $this->db::store($user);
        return $user->id;
    }

    // checks that the login/email aren't already taken
    public function checkUnique(): bool{
        $user = $this->db::findOne('user', 'login = ? OR email = ? LIMIT 1', [$this->user_data['login'],
            $this->user_data['email']]);
        if($user){
            if($user->login == $this->user_data['login']){
                $this->errors['unique'][] = 'Этот логин уже используется';
            }
            if($user->email == $this->user_data['email']){
                $this->errors['unique'][] = 'Этот email уже используется';
            }
            return false;
        }
        return true;
    }

    // default settings row created for a new user
    public function set_default_settings($userid):int{
        $settings = $this->db::dispense('settings');
        $settings->userid = $userid;
        $settings->showmydic = 0;
        $settings->showpanel = 0;
        $settings->well = 2;
        $settings->hard = 0;
        $settings->repeat = -5;
        $settings->speaker = 0;
        return $this->db::store($settings);
    }

}
