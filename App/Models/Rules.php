<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class Rules
{
    private $data;

    public function __construct( $data )
    {
        $this->data = $data;
    }

    public function check()
    {
        try
        {
            $this->firstBid();
            $this->lastMove();
            $this->moveOneLineForward();
            $this->moveHouseNeighbor();
            $this->columnColor();
            $this->moveHouseOccupied();
        }
        catch( Exception $e )
        {
            throw new Exception( $e->getMessage() );
        }
    }

    private function firstBid()
    {
        $turn = $this->data->getValue('turn');
        $last_move = $this->data->getValue('last-move');
        $piece_color = $this->data->getValue('piece')['color'];

        if( $turn === 1 && $last_move === null )
        {
            if( $piece_color === 'black' )
            {
                throw new Exception( 'Lance inicial deve ser feito pela peça branca' );
            }
        }
    }

    private function lastMove()
    {
        $last_move = $this->data->getValue('last-move');
        $piece_color = $this->data->getValue('piece')['color'];

        if( $last_move === 'white' && $piece_color === 'white' )
        {
            throw new Exception( 'Agora é a vez da peça preta jogar' );
        }
        if( $last_move === 'black' && $piece_color === 'black' )
        {
            throw new Exception(' Agora é a vez da peça branca jogar' );
        }
    }

    private function moveOneLineForward()
    {
        $piece_color = $this->data->getValue('piece')['color'];
        $piece_chosen = $this->data->getValue('piece-chosen');
        $line_target_id = (integer)$this->data->getValue('line-target')['id'];
        $line_source_id = (integer)$this->data->getValue('line-source')['id'];

        if( $piece_color === 'black' )
        {
            if( $piece_chosen === 'color-black' )
            {
                $line_allowed = ++$line_source_id;
            }
            else
            {
                $line_allowed = --$line_source_id;
            }
        }
        else
        {
            if( $piece_chosen === 'color-white' )
            {
                $line_allowed = ++$line_source_id;
            }
            else
            {
                $line_allowed = --$line_source_id;
            }
        }

        if( $line_allowed !== $line_target_id )
        {
            throw new Exception( 'Permitido mover-se apenas uma linha para frente' );
        }
    }

    private function moveHouseNeighbor()
    {
        $board = $this->data->getValue('board');
        $line_target = $this->data->getValue('line-target')['name'];
        $column_target = $this->data->getValue('column-target')['name'];
        $line_source = $this->data->getValue('line-source')['name'];
        $column_source = $this->data->getValue('column-source')['name'];

        $keys_line_source = array_keys( $board[$line_source] );
        $keys_line_target = array_keys( $board[$line_target] );

        $key_source = array_search( $column_source, $keys_line_source );
        $key_target = array_search( $column_target, $keys_line_target );

        if( $key_target === ( $key_source - 1 ) xor $key_target === $key_source xor $key_target === ( $key_source + 1 ) )
        {
            return true;
        }
        else
        {
            throw new Exception( 'Permitido mover-se apenas para sua casa vizinha' );
        }
    }

    private function moveHouseOccupied()
    {
        $board = $this->data->getValue('board');
        $line_target = $this->data->getValue('line-target')['name'];
        $column_target = $this->data->getValue('column-target')['name'];

        if( $board[$line_target][$column_target] !== null )
        {
            throw new Exception( 'Proibido mover-se para uma casa ocupada' );
        }
    }



    private function columnColor()
    {
        $column_target_color = $this->data->getValue('column-target')['color'];

        if( $column_target_color === 'white' )
        {
            throw new Exception( 'Proibido mover-se para uma casa branca' );
        }
    }


}


?>