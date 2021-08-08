<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace Core;

use Core\Session;
use Core\Post;

class Data
{
    private static $instance;
    private $data = [];

    private function __construct()
    {
        $this->data['board'] = Session::getValue('board');
        $this->data['color-chosen'] = Session::getValue('color-chosen');
        $this->data['turn'] = Session::getValue('turn');
        $this->data['movement-history'] = Session::getValue('movement-history');
        $this->data['cemetery'] = Session::getValue('cemetery');
        $this->data['player-current-left'] = Session::getValue('player-current-left');
        $this->data['player-top-right'] = Session::getValue('player-top-right');
        $this->data['player-lower-right'] = Session::getValue('player-lower-right');
        $this->data['player-current-top-right'] = Session::getValue('player-current-top-right');
        $this->data['player-current-lower-right'] = Session::getValue('player-current-lower-right');
        $this->data['piece'] = Post::getValue('piece');
        $this->data['line-source'] =  Post::getValue('line-source');
        $this->data['column-source'] = Post::getValue('column-source');
        $this->data['line-target'] = Post::getValue('line-target');
        $this->data['column-target'] = Post::getValue('column-target');
        $this->data['move-type'] = null;
        $this->data['pieces-targets'] = null;
        $this->data['message-error'] = null;
    }

    public static function getInstance()
    {
        if(empty(self::$instance))
        {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function setValue($param, $value)
    {
        if( array_key_exists($param, $this->data))
        {
            $this->data[$param] = $value;
        }
    }

    public function getValue($param)
    {
        if(array_key_exists($param, $this->data))
        {
            return $this->data[$param];
        }
    }

    public function getData()
    {
        return $this->data;
    }
}