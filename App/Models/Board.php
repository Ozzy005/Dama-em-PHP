<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use Core\Data;
use Core\Board as BoardCore;
use Core\Piece;

class Board
{
    private $data;

    public function __construct()
    {
        $this->data = Data::getInstance();
    }

    public function make()
    {
        $cc = $this->data->getValue('color-chosen');

        if($cc == 1)
        {
            $this->mount(1, 2);
        }
        if($cc == 2)
        {
            $this->mount(2, 1);
        }
    }

    private function mount($pc1, $pc2 )
    {
        $bc = new BoardCore;
        $pc1_id = 1;
        $pc2_id = 12;

        for($l = 1 ; $l <= 8 ; $l++)
        {
            for($c = 97 ; $c <= 104 ; $c++)
            {
                if($bc->isBlack($l, $c))
                {
                    if($l >= 1 && $l <= 3)
                    {
                        $bc->setPiece($l, $c, new Piece($pc1_id, 3, $pc1));
                        $pc1_id++;
                    }
                    if($l >= 6 && $l <= 8)
                    {
                        $bc->setPiece($l, $c, new Piece($pc2_id, 3, $pc2));
                        $pc2_id--;
                    }
                }
            }
        }

        $this->data->setValue('board', $bc);
    }
}