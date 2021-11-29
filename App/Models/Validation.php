<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use  App\Core\Father;
use Exception;

class Validation extends Father{

    private $checked = [];

    public function check(){
        $board = $this->data->board;
        $pAttId = $this->data->pieceAttackingId;
        $lSrc = $this->data->lineSource;
        $cSrc = $this->data->columnSource;
        $lDst = $this->data->lineDestiny;
        $cDst = $this->data->columnDestiny;

        $this->piece();
        $this->both($lSrc, $cSrc);
        $this->both($lDst, $cDst);

        if(count($this->checked) == 3 && $board->pieceExits($lSrc, $cSrc, $pAttId)){
            $this->data->pieceAttacking = $board->getPiece($lSrc, $cSrc);
        }
        else{
            throw new Exception('Dados recebidos inválidos');
        }
    }

    private function piece(){
        if(preg_match('/^[1-9]$|^[1-9][0-2]$/', $this->data->pieceAttackingId)){
            $this->checked[] = true;
        }
    }

    private function both($l, $c){
        if(preg_match('/^[1-8]$/', $l) && preg_match('/^[9][7-9]$|^[1][0][0-4]$/', $c)){
            $this->checked[] = true;
        }
    }

    public function playerChosen(){
        if(preg_match('/^[1-2]$/', $this->data->playerChosen)){
            return true;
        }
        
        throw new Exception('Dados recebidos inválidos');
    }
}