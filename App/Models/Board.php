<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use  App\Core\{Father, Piece, Board as BoardCore};

class Board extends Father{

    public function make(){
        if($this->data->playerChosen == 1){
            $this->mount(1, 2);
        }
        if($this->data->playerChosen == 2){
            $this->mount(2, 1);
        }
    }

    private function mount($pc1, $pc2){
        $board = new BoardCore;
        $pc1Id = 1;
        $pc2Id = 12;

        for($l = 1 ; $l <= 8 ; $l++){
            for($c = 97 ; $c <= 104 ; $c++){
                if($board->isBlack($l, $c)){
                    if($l >= 1 && $l <= 3){
                        $board->setPiece($l, $c, new Piece($pc1Id, 3, $pc1));
                        $pc1Id++;
                    }
                    if($l >= 6 && $l <= 8){
                        $board->setPiece($l, $c, new Piece($pc2Id, 3, $pc2));
                        $pc2Id--;
                    }
                }
            }
        }
        
        $this->data->board = $board;
    }
}