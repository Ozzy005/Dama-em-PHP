<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class Move
{
    private $data;

    public function __construct()
    {
        $this->data = Data::getInstance();
    }

    public function make()
    {
        $move_type = $this->data->getValue('move-type');

        $this->$move_type();
    }

    private function movePiece()
    {
        $data = $this->data;
        $turn = $data->getValue('turn');
        $pieca_color = $data->getValue('piece')['color'];
        $board = $data->getValue('board');
        $piece = $data->getValue('piece')['name'];
        $line_source = $data->getValue('line-source')['name'];
        $line_target = $data->getValue('line-target')['name'];
        $column_source = $data->getValue('column-source')['name'];
        $column_target = $data->getValue('column-target')['name'];

        $board[$line_target][$column_target] = $piece;
        $board[$line_source][$column_source] = null;

        $data->setValue('board',$board);
        $data->setValue('turn',++$turn);
        $data->setValue('last-move',$pieca_color);
    }

    private function capturePiece()
    {
        $data = $this->data;
        $turn = $data->getValue('turn');
        $pieca_color = $data->getValue('piece')['color'];
        $cemetery = $data->getValue('cemetery');
        $board = $data->getValue('board');
        $piece = $data->getValue('piece')['name'];
        $piece_target = $data->getValue('piece-target');
        $line_source = $data->getValue('line-source')['name'];
        $line_target = $data->getValue('line-target')['name'];
        $column_source = $data->getValue('column-source')['name'];
        $column_target = $data->getValue('column-target')['name'];
        $line_middle = $data->getValue('line-middle');
        $column_middle = $data->getValue('column-middle');

        $board[$line_target][$column_target] = $piece;
        $board[$line_source][$column_source] = null;
        $board[$line_middle][$column_middle] = null;
        $cemetery[] = $piece_target;

        $data->setValue('board',$board);
        $data->setValue('turn',++$turn);
        $data->setValue('last-move',$pieca_color);
        $data->setValue('cemetery',$cemetery);
    }
}