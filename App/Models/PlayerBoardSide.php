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
        $data = $this->data;

        $piece_chosen = $data->getValue('piece-chosen');

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

        $data->setValue('player-top-right',$player_top_right);
        $data->setValue('player-lower-right',$player_lower_right);
        Session::setValue('player-top-right',$player_top_right);
        Session::setValue('player-lower-right',$player_lower_right);
    }
}

