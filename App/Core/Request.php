<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Core;

class Request{

    public static function post($param){
        if(array_key_exists($param, $_POST)){
            return $_POST[$param];
        }
    }

    public static function get($param){
        if(array_key_exists($param, $_GET)){
            return $_GET[$param];
        }
    }
}