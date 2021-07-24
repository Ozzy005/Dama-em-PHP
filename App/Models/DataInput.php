<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class DataInput
{
    private $data;
    private $checked = [];

    public function __construct()
    {
        $this->data = Data::getInstance();
    }

    public function check()
    {
        $piece = $this->data->getValue('piece');
        $line_source = $this->data->getValue('line-source');
        $column_source = $this->data->getValue('column-source');
        $line_target = $this->data->getValue('line-target');
        $column_target = $this->data->getValue('column-target');

        $this->piece($piece, explode('-', $piece));
        $this->column($column_source, explode('-', $column_source), $line_source, 'column-source');
        $this->column($column_target, explode('-', $column_target), $line_target, 'column-target');
        $this->line($line_source, explode('-', $line_source), 'line-source');
        $this->line($line_target, explode('-', $line_target), 'line-target');

        if(count(array_filter($this->checked)) < 5)
        {
            throw new Exception( 'Dados recebidos inválidos' );
        }
    }

    private function piece($piece,$piece_explode)
    {
        if(count( $piece_explode ) === 3)
        {
            $piece_type = ($piece_explode[0] === 'stone' ) ? true : false;
            $piece_color = ($piece_explode[1] === 'white' || $piece_explode[1] === 'black' ) ? true : false;
            $id = preg_match('/^[1-9]$|^[1-9][0-9]$/',$piece_explode[2]);
            $piece_id = ($piece_explode[2] >= 1 && $piece_explode[2] <= 12 && $id ) ? true : false;

            $piece_checked = ( $piece_type && $piece_color && $piece_id ) ? true : false;

            if( $piece_checked )
            {
                $this->checked[] = $piece_checked;
                $piece_parts ['name'] = $piece;
                $piece_parts ['type'] = $piece_explode[0];
                $piece_parts ['color'] = $piece_explode[1];
                $piece_parts ['id'] = (int)$piece_explode[2];
                $this->data->setValue('piece', $piece_parts);
            }
        }
    }

    private function column($column, $column_explode, $line, $type)
    {
        $board = $this->data->getValue('board');

        if( count( $column_explode ) === 3 )
        {
            $column_type = ( $column_explode[0] === 'column' ) ? true : false;
            $column_id = preg_match( '/^[a-h]$/', $column_explode[1] );
            $column_exits = @key_exists($column,$board[$line]);
            $column_color = ( $column_explode[2] === 'white' || $column_explode[2] === 'black' ) ? true : false;

            $column_checked = ( $column_type && $column_id && $column_exits && $column_color ) ? true : false;

            if( $column_checked  )
            {
                $this->checked[] = $column_checked ;
                $column_parts['name'] = $column;
                $column_parts['type'] = $column_explode[0];
                $column_parts['id'] = $column_explode[1];
                $column_parts['color'] = $column_explode[2];
                $this->data->setValue($type,$column_parts);
            }
        }
    }

    private function line($line, $line_explode, $type)
    {
        if( count( $line_explode ) === 2 )
        {
            $line_type = ( $line_explode[0] === 'line' ) ? true : false;
            $id = preg_match('/^[1-8]$/',$line_explode[1]);
            $line_id = ( $line_explode[1] >= 1 && $line_explode[1] <= 8 && $id ) ? true : false;
            $line_checked = ( $line_type && $line_id ) ? true : false;

            if( $line_checked )
            {
                $this->checked[] = $line_checked;
                $line_parts['name'] = $line;
                $line_parts['type'] = $line_explode[0];
                $line_parts['id'] = (int)$line_explode[1];
                $this->data->setValue($type,$line_parts);
            }
        }
    }
}