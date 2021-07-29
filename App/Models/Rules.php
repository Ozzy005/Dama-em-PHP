<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class Rules
{
    private $data;

    public function __construct()
    {
        $this->data = Data::getInstance();
    }

    public function check()
    {
        try
        {
            if($this->data->getValue('move-type') === 'capturePiece')
            {
                $this->firstMove();
                $this->whoseTurn();
                $this->houseOccupied();
                $this->pieceTarget();
            }
            elseif($this->data->getValue('move-type') === 'movePiece')
            {
                $this->firstMove();
                $this->whoseTurn();
                $this->mandatoryCapture();
                $this->forward();
                $this->houseOccupied();
            }
            else
            {
                throw new Exception('Movimento inválido');
            }

        }
        catch( Exception $e )
        {
            throw new Exception( $e->getMessage() );
        }
    }

    //método responsável por verificar obrigatoriedade de captura
    private function mandatoryCapture()
    {
        $board = $this->data->getValue('board');
        $p_color = $this->data->getValue('piece')['color'];

        foreach($board as $l_key => $l_value)
        {
            foreach($l_value as $c_key => $p)
            {
                if($p !== null && explode('-',$p)[1] === $p_color)
                {
                    $code = ord(explode('-',$c_key)[1]);

                    $c_inc1 = 'column-'.(chr($code+1)).'-black';
                    $c_dec1 = 'column-'.(chr($code-1)).'-black';
                    $l_inc1 = 'line-'.(explode('-',$l_key)[1]+1);
                    $l_dec1 = 'line-'.(explode('-',$l_key)[1]-1);

                    $c_inc2 = 'column-'.(chr($code+2)).'-black';
                    $c_dec2 = 'column-'.(chr($code-2)).'-black';
                    $l_inc2 = 'line-'.(explode('-',$l_key)[1]+2);
                    $l_dec2 = 'line-'.(explode('-',$l_key)[1]-2);

                    //verificar coluna superior esquerda
                    if($code-1 >= 97 && $code-2 >= 97 && substr($l_inc1,-1) <= 8 && substr($l_inc2,-1) <= 8)
                    {
                        if($board[$l_inc1][$c_dec1] !== null && explode('-',$board[$l_inc1][$c_dec1])[1] !== $p_color )
                        {
                            if($board[$l_inc2][$c_dec2] === null)
                            {
                                throw new Exception( 'Captura de peça obrigatória' );
                            }
                        }
                    }

                    //verificar coluna superior direita
                    if($code+1 <= 104 && $code+2 <= 104 && substr($l_inc1,-1) <= 8 && substr($l_inc2,-1) <= 8)
                    {
                        if($board[$l_inc1][$c_inc1] !== null && explode('-',$board[$l_inc1][$c_inc1])[1] !== $p_color )
                        {
                            if($board[$l_inc2][$c_inc2] === null)
                            {
                                throw new Exception( 'Captura de peça obrigatória' );
                            }
                        }
                    }

                    //verificar coluna inferior esquerda
                    if($code-1 >= 97 && $code-2 >= 97 && substr($l_dec1,-1) >= 1 && substr($l_dec2,-1) >= 1)
                    {
                        if($board[$l_dec1][$c_dec1] !== null && explode('-',$board[$l_dec1][$c_dec1])[1] !== $p_color )
                        {
                            if($board[$l_dec2][$c_dec2] === null)
                            {
                                throw new Exception( 'Captura de peça obrigatória' );
                            }
                        }
                    }

                    //verificar coluna inferior direita
                    if($code+1 <= 104 && $code+2 <= 104 && substr($l_dec1,-1) >= 1 && substr($l_dec2,-1) >= 1)
                    {
                        if($board[$l_dec1][$c_inc1] !== null && explode('-',$board[$l_dec1][$c_inc1])[1] !== $p_color )
                        {
                            if($board[$l_dec2][$c_inc2] === null)
                            {
                                throw new Exception( 'Captura de peça obrigatória' );
                            }
                        }
                    }
                }
            }
        }
    }

    //método responsável por verificar se trata-se do primeiro movimento
    private function firstMove()
    {
        $turn = $this->data->getValue('turn');
        $last_move = $this->data->getValue('last-move');
        $piece_color = $this->data->getValue('piece')['color'];

        if( $turn === 1 && $last_move === null )
        {
            if( $piece_color === 'black' )
            {
                throw new Exception( 'Peça branca deve fazer o primeiro movimento' );
            }
        }
    }

    //método responsável por verificar de quem é a vez de jogar
    private function whoseTurn()
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

    //método responsável por verificar se a casa pra onde está sendo movida a peça está ocupada
    private function houseOccupied()
    {
        $board = $this->data->getValue('board');
        $line_target = $this->data->getValue('line-target')['name'];
        $column_target = $this->data->getValue('column-target')['name'];

        if( $board[$line_target][$column_target] !== null )
        {
            throw new Exception( 'Proibido mover-se para uma casa ocupada' );
        }
    }

    //método responsável por verificar se a peça está movendo-se para direção correta
    private function forward()
    {
        $piece_color = $this->data->getValue('piece')['color'];
        $piece_chosen = $this->data->getValue('piece-chosen');
        $line_target_id = (integer)$this->data->getValue('line-target')['id'];
        $line_source_id = (integer)$this->data->getValue('line-source')['id'];

        if( $piece_color === 'black' )
        {
            if( $piece_chosen === 'color-black' && $line_target_id <= $line_source_id )
            {
                throw new Exception( 'Permitido mover-se apenas para frente' );
            }
            if( $piece_chosen === 'color-white' && $line_target_id >= $line_source_id )
            {
                throw new Exception( 'Permitido mover-se apenas para frente' );
            }
        }
        if( $piece_color === 'white' )
        {
            if( $piece_chosen === 'color-white' && $line_target_id <= $line_source_id )
            {
                throw new Exception( 'Permitido mover-se apenas para frente' );
            }
            if( $piece_chosen === 'color-black' && $line_target_id >= $line_source_id )
            {
                throw new Exception( 'Permitido mover-se apenas para frente' );
            }
        }
    }

    //método responsável por verificar se o movimento de captura é válido
    private function pieceTarget()
    {
        $board = $this->data->getValue('board');
        $piece_color = $this->data->getValue('piece')['color'];
        $piece_target = $this->data->getValue('piece-target');
        $line_middle = $this->data->getValue('line-middle');
        $column_middle = $this->data->getValue('column-middle');

        $p_trt_parts = explode('-',$piece_target);

        if($board[$line_middle][$column_middle] === null)
        {
            throw new Exception('Movimento inválido');
        }
        if($board[$line_middle][$column_middle] !== null)
        {
            if($piece_color === $p_trt_parts[1])
            {
                throw new Exception('Proibido capturar sua própria peça =D');
            }
        }
    }
}