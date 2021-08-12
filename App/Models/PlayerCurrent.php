<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use Core\Data;

class PlayerCurrent
{
    private $data;

    public function __construct()
    {
        $this->data = Data::getInstance();
    }

    public function make()
    {
        $mh = $this->data->getValue('movement-history');
        $last_move = $mh->getLastMove();
        $player_top_right = $this->data->getValue('player-top-right');

        if(is_array($last_move))
        {
            $player_current_left = $last_move['piece-attacking']->isBlack() ? '1' : '2';

            if($player_top_right == 2 && $last_move['piece-attacking']->isBlack())
            {
                $player_current_top_right = '';
                $player_current_lower_right = 'player-current';
            }
            else
            {
                $player_current_top_right = 'player-current';
                $player_current_lower_right = '';
            }
        }
        elseif(is_null($last_move))
        {
            $player_current_left = 1;

            if($player_top_right == 2)
            {
                $player_current_top_right = '';
                $player_current_lower_right = 'player-current';
            }
            else
            {
                $player_current_top_right = 'player-current';
                $player_current_lower_right = '';
            }
        }

        $this->data->setValue('player-current-left',$player_current_left);
        $this->data->setValue('player-current-top-right',$player_current_top_right);
        $this->data->setValue('player-current-lower-right',$player_current_lower_right);
    }
}
