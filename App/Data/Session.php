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