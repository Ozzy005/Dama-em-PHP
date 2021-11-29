<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Core;

class MovementHistory{

    private $movementHistory = [];

    public function save($turn, Piece $pAtt, $lSrc, $cSrc, $lDst, $cDst, $pCaptured = 0){
        $this->movementHistory[$turn] = [
            'piece-attacking' => $pAtt,
            'line-source' => $lSrc,
            'column-source' => $cSrc,
            'line-destiny' => $lDst,
            'column-destiny' => $cDst,
            'pieces-captured' => $pCaptured
        ];
    }

    public function getLastMove(){
        if(count($this->movementHistory) > 0){
            return end($this->movementHistory);
        }
    }
}