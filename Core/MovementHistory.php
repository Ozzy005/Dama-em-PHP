<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace Core;

class MovementHistory
{
    private $movement_history = [];

    public function setValues($turn, Piece $p, $l_src, $c_src, $l_trt, $c_trt, $ps_trts = null)
    {
        $this->movement_history[$turn] = [
            'piece' => $p,
            'line-source' => $l_src,
            'column-source' => $c_src,
            'line-target' => $l_trt,
            'column-target' => $c_trt,
            'pieces-targets' => $ps_trts
        ];
    }

    public function getLastMove()
    {
        if(count($this->movement_history) > 0)
        {
            return end($this->movement_history);
        }
    }
}