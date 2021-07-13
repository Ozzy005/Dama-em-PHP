<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class Regras
{
    private $turno;
    private $ultimo_movimento;
    private $peca;
    private $linha;
    private $coluna;

    public function __construct( $turno, $ultimo_movimento , $dados )
    {
        $this->turno = $turno;
        $this->ultimo_movimento = $ultimo_movimento;
        $this->peca = $dados['peca'];
        $this->linha = $dados['linha'];
        $this->coluna = $dados['coluna'];
    }

    public function check()
    {
        try
        {
            $this->checkColumnColor();
            $this->checkFirstBid();
            $this->checkLastMove();
        }
        catch( Exception $e )
        {
            throw new Exception( $e->getMessage() );
        }
    }

    private function checkColumnColor()
    {
        if( $this->coluna['coluna-cor'] === 'branca' )
        {
            throw new Exception( 'Não é permitido mover-se para a coluna branca' );
        }
    }

    private function checkFirstBid()
    {
        if( $this->turno === 1 && $this->ultimo_movimento === null )
        {
            if( $this->peca['peca-cor'] === 'preta' )
            {
                throw new Exception( 'Lance inicial deve ser feito pela cor branca' );
            }
        }
    }

    private function checkLastMove()
    {
        if( $this->ultimo_movimento === 'branca' && $this->peca['peca-cor'] === 'branca' )
        {
            throw new Exception( 'Agora é a vez da cor preta jogar' );
        }
        elseif( $this->ultimo_movimento === 'preta' && $this->peca['peca-cor'] === 'preta' )
        {
            throw new Exception(' Agora é a vez da cor branca jogar' );
        }
    }
}


?>