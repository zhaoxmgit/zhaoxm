<?php

/*$sess = new session();
echo $sess->sid();
$sess->set("name" , "JACK");
setcookie("name" , "TACK" ,  time()+60  , "/");*/

class _session{

    public function init(){
       return (new self);
    }

    public function __construct()
    {
        $this->expire();
        session_start();
    }

    public function expire($time = 24*3600){
        session_set_cookie_params($time); //默认为一天
    }

    public function set($key , $val){
         if (is_null($key) || is_null($val)) {
             return false;
         }
         $_SESSION[$key] = $val;
         return true;
    }

    public function get($key){
        return $_SESSION[$key];
    }

    public function del($key){
        unset($_SESSION[$key]);
        return true;
    }

    public function sid(){
        return session_id();
    }
}