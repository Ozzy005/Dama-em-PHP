<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace Core;

use Core\Data;
use Core\Post;
use Core\MovementHistory;

class Session
{
    public function __construct()
    {
        if(session_status() != 2)
        {
            session_start();
        }
    }

    public static function save()
    {
        $data = Data::getInstance();

        self::setValue('board',$data->getValue('board'));
        self::setValue('player-chosen',$data->getValue('player-chosen'));
        self::setValue('turn',$data->getValue('turn'));
        self::setValue('movement-history',$data->getValue('movement-history'));
        self::setValue('cemetery',$data->getValue('cemetery'));
        self::setValue('player-current-left',$data->getValue('player-current-left'));
        self::setValue('player-top-right',$data->getValue('player-top-right'));
        self::setValue('player-lower-right',$data->getValue('player-lower-right'));
        self::setValue('player-current-top-right',$data->getValue('player-current-top-right'));
        self::setValue('player-current-lower-right',$data->getValue('player-current-lower-right'));
    }

    public static function empty()
    {
        return empty($_SESSION);
    }

    public static function setValue($param, $value)
    {
        $_SESSION[$param] = $value;
    }

    public static function getValue($param)
    {
        if(array_key_exists($param, $_SESSION))
        {
            return $_SESSION[$param];
        }
    }

    public static function destroy()
    {
        $_SESSION = [];
    }
}