<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class Mountboard
{
    private $data;

    public function __construct()
    {
        $this->data = Data::getInstance();
    }

    public function make()
    {
        $piece_chosen = $this->data->getValue('piece-chosen');
        $pieces_white = $this->data->getValue('pieces-white');
        $pieces_black = $this->data->getValue('pieces-black');

        if( $piece_chosen === 'color-black' )
        {
            $this->mount( $pieces_white, $pieces_black );
        }
        if( $piece_chosen === 'color-white' )
        {
            $this->mount( $pieces_black, $pieces_white );
        }
    }

    private function mount( $piece_one, $piece_two )
    {
        $board = $this->data->getValue('board');

        $n8 = 4;  //4-3-2-1
        $n7 = 8;  //8-7-6-5
        $n6 = 12; //12-11-10-9

        $n3 = 9;  //9-10-11-12
        $n2 = 5;  //5-6-7-8
        $n1 = 1;  //1-2-3-4

        foreach( $board as $key_line => $value_line )
        {
            foreach( $value_line as $key_column => $value_column )
            {
                $line_explode = explode('-',$key_line);
                $column_explode = explode('-',$key_column);

                settype($line_explode[1],'integer');

                //organiza as peça do lado de cima do tabuleiro
                if( $line_explode[1] <= 8 && $line_explode[1] >= 6 && $column_explode[2] === 'black' )
                {
                    if( $line_explode[1] === 8 && $n8 <= 4 && $n8 >= 1 )
                    {
                        $board[$key_line][$key_column] = $piece_one[$n8];
                        $n8--;
                    }
                    if( $line_explode[1] === 7 && $n7 <= 8 && $n7 >= 5 )
                    {
                        $board[$key_line][$key_column] = $piece_one[$n7];
                        $n7--;
                    }
                    if( $line_explode[1] === 6 && $n6 <= 12 && $n6 >= 9 )
                    {
                        $board[$key_line][$key_column] = $piece_one[$n6];
                        $n6--;
                    }
                }

                //organiza as peças do lado de baixo do tabuleiro
                if( $line_explode[1] <= 3 && $line_explode[1] >= 1 && $column_explode[2] === 'black' )
                {
                    if( $line_explode[1] === 3 && $n3 >= 9 && $n3 <= 12 )
                    {
                        $board[$key_line][$key_column] = $piece_two[$n3];
                        $n3++;
                    }
                    if( $line_explode[1] === 2 && $n2 >= 5 && $n2 <= 8 )
                    {
                        $board[$key_line][$key_column] = $piece_two[$n2];
                        $n2++;
                    }
                    if( $line_explode[1] === 1 && $n1 >= 1 && $n1 <= 4 )
                    {
                        $board[$key_line][$key_column] = $piece_two[$n1];
                        $n1++;
                    }
                }
            }
        }

        $this->data->setValue('board',$board);
    }
}