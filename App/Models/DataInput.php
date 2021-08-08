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
        [
            'board' => $b,
            'piece' => $p_id,
            'line-source' => $l_src,
            'column-source' => $c_src,
            'line-target' => $l_trt,
            'column-target' => $c_trt
        ] = $this->data->getData();

        $this->piece($p_id);
        $this->both($l_src, $c_src);
        $this->both($l_trt, $c_trt);

        if(count($this->checked) == 3 && $b->getPiece($l_src, $c_src, $p_id))
        {
            $p = $b->getPiece($l_src, $c_src, $p_id);
            $this->data->setValue('piece',$p);
        }
        else
        {
            throw new Exception('Dados recebidos inválidos');
        }
    }

    private function piece($p_id)
    {
        if(preg_match('/^[1-9]$|^[1-9][0-2]$/',$p_id))
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

    public function colorChosen()
    {
        $cc = $this->data->getValue('color-chosen');

        if(preg_match('/^[1-2]$/', $cc))
        {
            return true;
        }
        else
        {
            throw new Exception('Dados recebidos inválidos');
        }
    }
}