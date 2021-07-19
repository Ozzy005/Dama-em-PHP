<?php

/**
 *
 * @author Rafael Arend
 *
 **/

//  invenção minha, eu chamo ela de mini database de tempo de execução =D
//  o propósito dessa classe é reunir todos os dados utilizados em tempo de execução em um lugar só
//  o benefício dela é que deixa o controller mais organizado e legível
//  em vez de passar 5 a 10 valores via parâmetros, passa apenas o objeto Data
//  a classe que precisar de algum valor presente nesse objeto pega ele através de getValue

class Data
{
    private $data = [];

    public function __construct()
    {
        $this->data['markings-html'] = MarkingsHtml::getValue();
        $this->data['pieces-white'] = PiecesWhite::getValue();
        $this->data['pieces-black'] = PiecesBlack::getValue();
        $this->data['board'] = Session::getValue('board') ?? Board::getValue();
        $this->data['turn'] = Session::getValue('turn') ?? 1;
        $this->data['cemetery'] = Session::getValue('cemetery') ?? null;
        $this->data['last-move'] = Session::getValue('last-move') ?? null;
        $this->data['piece-chosen'] = Session::getValue('piece-chosen') ?? $_POST['piece-chosen'];
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
        $this->data['message-error'] = null;
        $this->data['pieces'] = null;
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
        if(array_key_exists($param,$this->data))
        {
            return $this->data[$param];
        }
    }
}