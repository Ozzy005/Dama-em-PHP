<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use App\Core\Father;

class Move extends Father{
    public function make(){
        $board = $this->data->board;
        $turn = $this->data->turn;
        $mh = $this->data->movementHistory;
        $cemetery = $this->data->cemetery;
        $pAtt = $this->data->pieceAttacking;
        $lSrc = $this->data->lineSource;
        $cSrc = $this->data->columnSource;
        $lDst = $this->data->lineDestiny;
        $cDst = $this->data->columnDestiny;
        $piecesCaptured = $this->data->piecesCaptured;
        $mt = $this->data->moveType;

        if($mt == 'movePiece'){
            $this->movePiece($board, $turn, $mh, $pAtt, $lSrc, $cSrc, $lDst, $cDst);
        }
        elseif($mt == 'capturePiece'){
            $this->capturePiece($board, $turn, $mh, $cemetery, $pAtt, $lSrc, $cSrc, $lDst, $cDst, $piecesCaptured);
        }
    }

    private function movePiece($board, $turn, $mh, $pAtt, $lSrc, $cSrc, $lDst, $cDst){
        $board->unsetPiece($lSrc, $cSrc);
        $board->setPiece($lDst, $cDst, $pAtt);
        $mh->save($turn ,$pAtt, $lSrc, $cSrc, $lDst, $cDst);
        $this->data->turn = ++$turn;
    }

    private function capturePiece($board, $turn, $mh, $cemetery, $pAtt, $lSrc, $cSrc, $lDst, $cDst, $piecesCaptured){
        $board->unsetPiece($lSrc, $cSrc);
        $board->setPiece($lDst, $cDst, $pAtt);
        $cemetery[$turn] = [];

        for($n = 0 ; $n < count($piecesCaptured) ; $n++){
            $pieceCaptured = $piecesCaptured[$n]['piece-captured'];
            $lMidway = $piecesCaptured[$n]['line-midway'];
            $cMidway = $piecesCaptured[$n]['column-midway'];

            $board->unsetPiece($lMidway, $cMidway);
            $cemetery[$turn][$n] = $pieceCaptured;
        }

        $mh->save($turn, $pAtt, $lSrc, $cSrc, $lDst, $cDst, $piecesCaptured);
        $this->data->turn =  ++$turn;
    }
}