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
        $player_chosen = $this->data->getValue('player-chosen');

        if($player_chosen == 1)
        {
            $player_top_right = 2;
            $player_lower_right = 1;
        }
        else
        {
            $player_top_right = 1;
            $player_lower_right = 2;
        }

        $this->data->setValue('player-top-right',$player_top_right);
        $this->data->setValue('player-lower-right',$player_lower_right);
    }
}

