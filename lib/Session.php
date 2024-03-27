<?php 

class Session{
     
    //session initialization
    public static function init(){
        if(version_compare(phpversion(), "5.4.0", "<")){
            if(session_id() == ""){
                session_start();
            }
        }else{
            if(session_status() == PHP_SESSION_NONE){
                session_start();
            }
        }
    }

    //set new session variable
    public static function set($key, $value){
        $_SESSION[$key] = $value;
    }

    //get session variable
    public static function get($key){
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }else{
            return false;
        }
    }

    //check session method
    public static function check_session(){
        if(self::get("Login") == false){
            self::destroy();
            header("Location: login.php");
        }
    }

     //check login method
     public static function check_login(){
        if(self::get("Login") == true){
            header("Location: index.php");
        }
    }


    //Session destroy method
    public static function destroy(){
        session_destroy();
        session_unset();

        //redirect to the home page after successfully logged out
        header("Location: login.php");
    }

}

?>