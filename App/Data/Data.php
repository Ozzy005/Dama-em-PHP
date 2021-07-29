<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class Data
{
    private static $instance;
    private $data = [];

    private function __construct()
    {
        $this->data['markings-html'] = MarkingsHtml::getValue();
        $this->data['pieces-white'] = PiecesWhite::getValue();
        $this->data['pieces-black'] = PiecesBlack::getValue();
        $this->data['board'] = Session::getValue('board') ?? Board::getValue();
        $this->data['turn'] = Session::getValue('turn') ?? 1;
        $this->data['cemetery'] = Session::getValue('cemetery') ?? [];
        $this->data['last-move'] = Session::getValue('last-move') ?? null;
        $this->data['movement-history'] = Session::getValue('movement-history') ?? [];
        $this->data['piece-chosen'] = $_POST['piece-chosen'] ?? Session::getValue('piece-chosen');
        $this->data['player-current-left'] = Session::getValue('player-current-left') ?? null;
        $this->data['player-top-right'] = Session::getValue('player-top-right') ?? null;
        $this->data['player-lower-right'] = Session::getValue('player-lower-right') ?? null;
        $this->data['player-current-top-right'] = Session::getValue('player-current-top-right') ?? null;
        $this->data['player-current-lower-right'] = Session::getValue('player-current-lower-right') ?? null;
        $this->data['piece'] = $_POST['piece'] ?? null;
        $this->data['line-source'] =  $_POST['line-source'] ?? null;
        $this->data['column-source'] = $_POST['column-source'] ?? null;
        $this->data['line-target'] = $_POST['line-target'] ?? null;
        $this->data['column-target'] = $_POST['column-target'] ?? null;
        $this->data['piece-target'] = null;
        $this->data['line-middle'] = null;
        $this->data['column-middle'] = null;
        $this->data['move-type'] = null;
        $this->data['message-error'] = null;
        $this->data['pieces'] = null;
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
        if(array_key_exists($param,$this->data))
        {
            $this->data[$param] = $value;
        }
    }

    public function getValue($param)
    {
        return $this->data[$param];
    }
}