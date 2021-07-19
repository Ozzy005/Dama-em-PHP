<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class MovePiece
{
    private $data;


    public function __construct( $data )
    {
        $this->data = $data;
    }

    public function make()
    {
        $turn = $this->data->getValue('turn');
        $board = $this->data->getValue('board');
        $piece = $this->data->getValue('piece')['name'];
        $piece_color = $this->data->getValue('piece')['color'];
        $line_target = $this->data->getValue('line-target')['name'];
        $column_target = $this->data->getValue('column-target')['name'];
        $line_source = $this->data->getValue('line-source')['name'];
        $column_source = $this->data->getValue('column-source')['name'];


        if( $board[$line_source][$column_source] === $piece)
        {
            $board[$line_target][$column_target] = $piece;
            $board[$line_source][$column_source] = null;

            $this->data->setValue('board',$board);
            $this->data->setValue('turn',++$turn);
            $this->data->setValue('last-move',$piece_color);
        }
    }
}


?>