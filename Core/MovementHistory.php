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

    public function setValues($turn, Piece $p_att, $l_src, $c_src, $l_dst, $c_dst, $p_captured = null)
    {
        $this->movement_history[$turn] = [
            'piece-attacking' => $p_att,
            'line-source' => $l_src,
            'column-source' => $c_src,
            'line-destiny' => $l_dst,
            'column-destiny' => $c_dst,
            'pieces-captured' => $p_captured
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