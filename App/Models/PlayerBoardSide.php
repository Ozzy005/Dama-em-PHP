<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use  App\Core\Father;

class PlayerBoardSide extends Father{

    public function make(){
        if($this->data->playerChosen == 1){
            $this->data->playerTopRight = 2;
            $this->data->playerLowerRight = 1;
        }else{
            $this->data->playerTopRight = 1;
            $this->data->playerLowerRight = 2;
        }
    }
}

