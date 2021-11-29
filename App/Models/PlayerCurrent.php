<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use  App\Core\Father;

class PlayerCurrent extends Father{

    public function make(){
        $lastMove = $this->data->movementHistory->getLastMove();

        if(!empty($lastMove)){
            $playerCurrentLeft = $lastMove['piece-attacking']->isBlack() ? 1 : 2;

            if($this->data->playerTopRight == 2 && $lastMove['piece-attacking']->isBlack()){
                $playerCurrentTopRight = '';
                $playerCurrentLowerRight = 'player-current';
            }
            else{
                $playerCurrentTopRight = 'player-current';
                $playerCurrentLowerRight = '';
            }
        }
        else{
            $playerCurrentLeft = 1;

            if($this->data->playerTopRight == 2){
                $playerCurrentTopRight = '';
                $playerCurrentLowerRight = 'player-current';
            }
            else{
                $playerCurrentTopRight = 'player-current';
                $playerCurrentLowerRight = '';
            }
        }

        $this->data->playerCurrentLeft = $playerCurrentLeft;
        $this->data->playerCurrentTopRight = $playerCurrentTopRight;
        $this->data->playerCurrentLowerRight = $playerCurrentLowerRight;
    }
}
