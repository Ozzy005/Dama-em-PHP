<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Core;

class Board{
    
    private $board = [
        8 => [97 => null, 98 => null, 99 => null, 100 => null, 101 => null, 102 => null, 103 => null, 104 => null],
        7 => [97 => null, 98 => null, 99 => null, 100 => null, 101 => null, 102 => null, 103 => null, 104 => null],
        6 => [97 => null, 98 => null, 99 => null, 100 => null, 101 => null, 102 => null, 103 => null, 104 => null],
        5 => [97 => null, 98 => null, 99 => null, 100 => null, 101 => null, 102 => null, 103 => null, 104 => null],
        4 => [97 => null, 98 => null, 99 => null, 100 => null, 101 => null, 102 => null, 103 => null, 104 => null],
        3 => [97 => null, 98 => null, 99 => null, 100 => null, 101 => null, 102 => null, 103 => null, 104 => null],
        2 => [97 => null, 98 => null, 99 => null, 100 => null, 101 => null, 102 => null, 103 => null, 104 => null],
        1 => [97 => null, 98 => null, 99 => null, 100 => null, 101 => null, 102 => null, 103 => null, 104 => null],
    ];

    public function isBlack($l, $c){
        if($l % 2 > 0 && $c % 2 > 0){
            return true;
        }
        if($l % 2 == 0 && $c % 2 == 0){
            return true;
        }
    }

    public function isWhite($l, $c){
        if($l % 2 > 0 && $c % 2 == 0){
            return true;
        }
        if($l % 2 == 0 && $c % 2 > 0){
            return true;
        }
    }

    public function isEmpty($l, $c){
        if(!$this->board[$l][$c]){
            return true;
        }
    }

    public function notEmpty($l, $c){
        if($this->board[$l][$c] instanceof Piece){
            return true;
        }
    }

    public function setPiece($l, $c, Piece $p){
        $this->board[$l][$c] = $p;
    }

    public function unsetPiece($l, $c){
        $this->board[$l][$c] = null;
    }

    public function getPiece($l, $c){
        return $this->board[$l][$c];
    }

    public function pieceExits($l, $c, $id){
        if($this->notEmpty($l, $c) && $this->board[$l][$c]->id == $id){
            return true;
        }
    }

    public function getBoard(){
        return $this->board;
    }
}

