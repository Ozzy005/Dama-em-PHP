<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use Core\Data;

class PlayerBoardSide
{
    private $data;

    public function __construct()
    {
        $this->data = Data::getInstance();
    }

    public function make()
    {
        $cc = $this->data->getValue('color-chosen');

        if( $cc == 1 )
        {
            $player_top_right = 2;
            $player_lower_right = 1;
        }
        if( $cc == 2 )
        {
            $player_top_right = 1;
            $player_lower_right = 2;
        }

        $this->data->setValue('player-top-right',$player_top_right);
        $this->data->setValue('player-lower-right',$player_lower_right);
    }
}

