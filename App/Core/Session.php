<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Core;

class Session{
    
    public function __construct(){
        if(session_status() != 2){
            session_start();
        }
            
        if(isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)){
            session_unset();
            session_destroy();
        }

        $_SESSION['LAST_ACTIVITY'] = time();

        if(!isset($_SESSION['ID_REGENERATION_TIME'])){
            $_SESSION['ID_REGENERATION_TIME'] = time();
        }
        elseif(time() - $_SESSION['ID_REGENERATION_TIME'] > 60){
            session_regenerate_id(true);
            $_SESSION['ID_REGENERATION_TIME'] = time();
        }
    }

    public static function empty($param = null){
        if($param){
            return empty($_SESSION[$param]);
        }
        else{
            return empty($_SESSION);
        }
    }

    public static function setValue($param, $value){
        $_SESSION[$param] = $value;
    }

    public static function getValue($param){
        if(array_key_exists($param, $_SESSION)){
            return $_SESSION[$param];
        }
    }

    public static function destroy(){
        session_unset();
        session_destroy();
    }
}