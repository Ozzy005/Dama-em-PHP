<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use Core\{Data, Piece, Board as BoardCore};

class Board
{
    private $data;

    public function __construct()
    {
        $this->data = Data::getInstance();
    }

    public function make()
    {
        $player_chosen = $this->data->getValue('player-chosen');

        if($player_chosen  == 1)
        {
            $this->mount(1, 2);
        }
        if($player_chosen  == 2)
        {
            $this->mount(2, 1);
        }
    }

    private function mount($pc1, $pc2 )
    {
        $board = new BoardCore;
        $pc1_id = 1;
        $pc2_id = 12;

        for($l = 1 ; $l <= 8 ; $l++)
        {
            for($c = 97 ; $c <= 104 ; $c++)
            {
                if($board->isBlack($l, $c))
                {
                    if($l >= 1 && $l <= 3)
                    {
                        $board->setPiece($l, $c, new Piece($pc1_id, 3, $pc1));
                        $pc1_id++;
                    }
                    if($l >= 6 && $l <= 8)
                    {
                        $board->setPiece($l, $c, new Piece($pc2_id, 3, $pc2));
                        $pc2_id--;
                    }
                }
            }
        }

        $this->data->setValue('board', $board);
    }
}