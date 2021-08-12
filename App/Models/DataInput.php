<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use Core\Data;
use Exception;

class DataInput
{
    private $data;
    private $checked = [];

    public function __construct()
    {
        $this->data = Data::getInstance();
    }

    public function check()
    {
        ['board' => $board, 'piece-attacking' => $p_att_id, 'line-source' => $l_src, 'column-source' => $c_src, 'line-destiny' => $l_dst, 'column-destiny' => $c_dst] = $this->data->getData();

        $this->piece($p_att_id);
        $this->both($l_src, $c_src);
        $this->both($l_dst, $c_dst);

        if(count($this->checked) == 3 && $board->getPiece($l_src, $c_src, $p_att_id))
        {
            $p_att = $board->getPiece($l_src, $c_src, $p_att_id);
            $this->data->setValue('piece-attacking',$p_att);
        }
        else
        {
            throw new Exception('Dados recebidos inválidos');
        }
    }

    private function piece($p_att_id)
    {
        if(preg_match('/^[1-9]$|^[1-9][0-2]$/',$p_att_id))
        {
            $this->checked[] = true;
        }
    }

    private function both($l, $c)
    {
        if(preg_match('/^[1-8]$/', $l) && preg_match('/^[9][7-9]$|^[1][0][0-4]$/', $c))
        {
            $this->checked[] = true;
        }
    }

    public function playerChosen()
    {
        $player_chosen = $this->data->getValue('player-chosen');

        if(preg_match('/^[1-2]$/', $player_chosen))
        {
            return true;
        }
        else
        {
            throw new Exception('Dados recebidos inválidos');
        }
    }
}