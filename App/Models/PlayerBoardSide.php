<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class PlayerBoardSide
{
    private $data;

    public function __construct()
    {
        $this->data = Data::getInstance();
    }

    public function make()
    {
        $piece_chosen = $this->data->getValue('piece-chosen');

        if( $piece_chosen === 'color-white' )
        {
            $player_top_right = '2';
            $player_lower_right = '1';
        }
        if( $piece_chosen === 'color-black' )
        {
            $player_top_right = '1';
            $player_lower_right = '2';
        }

        $this->data->setValue('player-top-right',$player_top_right);
        $this->data->setValue('player-lower-right',$player_lower_right);
    }
}

