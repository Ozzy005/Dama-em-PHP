<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace Core;

use Core\Data;

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

        $_SESSION['board'] = $data->getValue('board');
        $_SESSION['player-chosen'] = $data->getValue('player-chosen');
        $_SESSION['turn'] = $data->getValue('turn');
        $_SESSION['movement-history'] = $data->getValue('movement-history');
        $_SESSION['cemetery'] = $data->getValue('cemetery');
        $_SESSION['player-current-left'] = $data->getValue('player-current-left');
        $_SESSION['player-top-right'] = $data->getValue('player-top-right');
        $_SESSION['player-lower-right'] = $data->getValue('player-lower-right');
        $_SESSION['player-current-top-right'] = $data->getValue('player-current-top-right');
        $_SESSION['player-current-lower-right'] = $data->getValue('player-current-lower-right');
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