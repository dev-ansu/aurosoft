<?php
namespace app\classes;

use app\contracts\SessionContract;

class Session implements SessionContract{

    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function __get($name)
    {
        return $_SESSION[$name] ?? null;
    }

    public static function get($name){
        return $_SESSION[$name] ?? null;
    }

    public function has($name){
        return isset($_SESSION[$name]);
    }

    public function unset($name){
        if($this->has($name)){
            unset($_SESSION[$name]);
        }
    }

    public static function remove(){
        session_destroy();
    }

}