<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use Core\Data;

class Move
{
    public function make()
    {
        $data = Data::getInstance();
        [
            'board' => $board,
            'turn' => $turn,
            'movement-history' => $mh,
            'cemetery' => $cemetery,
            'piece-attacking' => $p_att,
            'line-source' => $l_src,
            'column-source' => $c_src,
            'line-destiny' => $l_dst,
            'column-destiny' => $c_dst,
            'pieces-captured' => $pieces_captured,
            'move-type' => $mt
        ] = $data->getData();

        if($mt == 'movePiece')
        {
            $this->movePiece($data, $board, $turn, $mh, $p_att, $l_src, $c_src, $l_dst, $c_dst);
        }
        elseif($mt == 'capturePiece')
        {
            $this->capturePiece($data, $board, $turn, $mh, $cemetery, $p_att, $l_src, $c_src, $l_dst, $c_dst, $pieces_captured);
        }
    }

    private function movePiece($data, $board, $turn, $mh, $p_att, $l_src, $c_src, $l_dst, $c_dst)
    {
        $board->unsetPiece($l_src, $c_src);
        $board->setPiece($l_dst, $c_dst, $p_att);
        $mh->setValues($turn ,$p_att, $l_src, $c_src, $l_dst, $c_dst);
        $data->setValue('board', $board);
        $data->setValue('turn', ++$turn);
        $data->setValue('movement-history', $mh);
    }

    private function capturePiece($data, $board, $turn, $mh, $cemetery, $p_att, $l_src, $c_src, $l_dst, $c_dst, $pieces_captured)
    {
        $board->unsetPiece($l_src, $c_src);
        $board->setPiece($l_dst, $c_dst, $p_att);
        $cemetery[$turn] = [];

        for($n = 0 ; $n < count($pieces_captured) ; $n++)
        {
            $piece_captured = $pieces_captured[$n]['piece-captured'];
            $l_midway = $pieces_captured[$n]['line-midway'];
            $c_midway = $pieces_captured[$n]['column-midway'];

            $board->unsetPiece($l_midway, $c_midway);
            $cemetery[$turn][$n] = $pieces_captured;
        }

        $mh->setValues($turn, $p_att, $l_src, $c_src, $l_dst, $c_dst, $pieces_captured);
        $data->setValue('board', $board);
        $data->setValue('turn', ++$turn);
        $data->setValue('movement-history', $mh);
    }
}