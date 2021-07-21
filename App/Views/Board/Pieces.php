<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class Pieces
{
    private Data $data;

    public function __construct()
    {
        $this->data = Data::getInstance();
    }

    public function make()
    {
        $board = $this->data->getValue('board');
        $pieces = [];
        $tag = '';

        foreach($board as $key_line => $value_line)
        {
            foreach($value_line as $key_column => $piece)
            {
                /*
                * exemplo
                * [0] => stone
                * [1] => white
                * [2] => 1
                */

                $piece_explode = explode('-', $piece);

                if($piece)
                {
                    $tag = "<div id='{$piece}' class='piece {$piece_explode[0]}-{$piece_explode[1]}'></div>";
                    $pieces[] = $tag;
                }
                else
                {
                    $pieces[] = '';
                }
            }
        }
        $this->data->setValue('pieces',$pieces);
    }
}