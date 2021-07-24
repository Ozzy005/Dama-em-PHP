<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class Session
{
    public function __construct()
    {
        if(session_status() !== 2)
        {
            session_start();
        }
    }

    public static function save()
    {
        $data = Data::getInstance();

        self::setValue('board',$data->getValue('board'));
        self::setValue('turn',$data->getValue('turn'));
        self::setValue('last-move',$data->getValue('last-move'));
        self::setValue('cemetery',$data->getValue('cemetery'));
        self::setValue('piece-chosen',$data->getValue('piece-chosen'));
        self::setValue('player-current-left',$data->getValue('player-current-left'));
        self::setValue('player-top-right',$data->getValue('player-top-right'));
        self::setValue('player-lower-right',$data->getValue('player-lower-right'));
        self::setValue('player-current-top-right',$data->getValue('player-current-top-right'));
        self::setValue('player-current-lower-right',$data->getValue('player-current-lower-right'));
    }

    public static function setVars()
    {
        if(self::empty())
        {
            $_SESSION['board'] = null;
            $_SESSION['turn'] = null;
            $_SESSION['last-move'] = null;
            $_SESSION['cemetery'] = null;
            $_SESSION['piece-chosen'] = null;
            $_SESSION['player-current-left'] = null;
            $_SESSION['player-top-right'] = null;
            $_SESSION['player-lower-right'] = null;
            $_SESSION['player-current-top-right'] = null;
            $_SESSION['player-current-lower-right'] = null;
        }
    }

    public static function empty()
    {
        return empty($_SESSION);
    }

    public static function setValue($param, $value)
    {
        if(array_key_exists($param,$_SESSION))
        {
            $_SESSION[$param] = $value;
        }
    }

    public static function getValue($param)
    {
        return $_SESSION[$param];
    }

    public static function destroy()
    {
        $_SESSION = [];
        session_destroy();
    }
}