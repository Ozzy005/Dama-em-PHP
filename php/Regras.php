<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class Regras
{
    private $turno;
    private $peca_escolhida;
    private $ultimo_movimento;
    private $peca;
    private $linha;
    private $coluna;

    public function __construct( $tabuleiro, $turno, $peca_escolhida, $ultimo_movimento , $dados )
    {
        $this->tabuleiro = $tabuleiro;
        $this->turno = $turno;
        $this->peca_escolhida = $peca_escolhida;
        $this->ultimo_movimento = $ultimo_movimento;
        $this->peca = $dados['peca'];
        $this->linha = $dados['linha'];
        $this->coluna = $dados['coluna'];
    }

    public function check()
    {
        try
        {
            $this->firstBid();
            $this->lastMove();
            $this->moveOneLineForward();
            $this->moveHouseOccupied();
            $this->moveHouseNeighbor();
            $this->columnColor();
        }
        catch( Exception $e )
        {
            throw new Exception( $e->getMessage() );
        }
    }

    private function moveHouseOccupied()
    {
        $tabuleiro = $this->tabuleiro;
        $linha_alvo = $this->linha['nome'];
        $coluna_alvo = $this->coluna['nome'];

        if( $tabuleiro[$linha_alvo][$coluna_alvo] !== null )
        {
            throw new Exception( 'Não é possível mover-se para uma casa ocupada!' );
        }
    }

    private function moveHouseNeighbor()
    {
        $tabuleiro = $this->tabuleiro;
        $linha_alvo = $this->linha['nome'];
        $coluna_alvo = $this->coluna['nome'];
        $linha_atual = $this->peca['posicao-atual'][0];
        $coluna_atual = $this->peca['posicao-atual'][1];

        $keys_linha_atual = array_keys( $tabuleiro[$linha_atual] );
        $keys_linha_alvo = array_keys( $tabuleiro[$linha_alvo] );

        $key_atual = array_search( $coluna_atual, $keys_linha_atual );
        $key_alvo = array_search( $coluna_alvo, $keys_linha_alvo );

        if( $key_alvo === ( $key_atual - 1 ) xor $key_alvo === $key_atual xor $key_alvo === ( $key_atual + 1 ) )
        {
            return true;
        }
        else
        {
            throw new Exception( 'Permitido mover-se apenas para sua casa vizinha!' );
        }

    }

    private function moveOneLineForward()
    {
        $peca_cor = $this->peca['cor'];
        $peca_escolhida = $this->peca_escolhida;
        $linha_id = (integer)$this->linha['id'];
        $linha_atual = $this->peca['posicao-atual'][0];
        $linha_atual_explode = explode('-',$linha_atual);

        if( $peca_cor === 'preta' )
        {
            if( $peca_escolhida === 'cor-preta' )
            {
                $linha_permitida = ++$linha_atual_explode[1];
            }
            else
            {
                $linha_permitida = --$linha_atual_explode[1];
            }
        }
        else
        {
            if( $peca_escolhida === 'cor-branca' )
            {
                $linha_permitida = ++$linha_atual_explode[1];
            }
            else
            {
                $linha_permitida = --$linha_atual_explode[1];
            }
        }

        if( $linha_permitida !== $linha_id )
        {
            throw new Exception( 'Permitido mover-se apenas uma linha para frente !' );
        }

    }

    private function columnColor()
    {
        if( $this->coluna['cor'] === 'branca' )
        {
            throw new Exception( 'Proibido mover-se para a casa branca' );
        }
    }

    private function firstBid()
    {
        if( $this->turno === 1 && $this->ultimo_movimento === null )
        {
            if( $this->peca['cor'] === 'preta' )
            {
                throw new Exception( 'Lance inicial deve ser feito pela cor branca' );
            }
        }
    }

    private function lastMove()
    {
        if( $this->ultimo_movimento === 'branca' && $this->peca['cor'] === 'branca' )
        {
            throw new Exception( 'Agora é a vez da cor preta jogar' );
        }
        elseif( $this->ultimo_movimento === 'preta' && $this->peca['cor'] === 'preta' )
        {
            throw new Exception(' Agora é a vez da cor branca jogar' );
        }
    }
}


?>