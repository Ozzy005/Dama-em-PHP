<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class MoverPeca
{
    private $tabuleiro;
    private $peca;
    private $linha;
    private $coluna;
    private $turno;
    private $ultimo_movimento;
    private $dados = [];


    public function __construct( $tabuleiro, $turno, $ultimo_movimento, $dados )
    {
        $this->tabuleiro = $tabuleiro;
        $this->turno = $turno;
        $this->peca = $dados['peca'];
        $this->linha = $dados['linha'];
        $this->coluna = $dados['coluna'];
        $this->ultimo_movimento = $ultimo_movimento;
    }

    public function mover()
    {
        foreach( $this->tabuleiro as $chave_linha => $valor_linha )
        {
            if( $chave_coluna = array_search( $this->peca['peca-nome'], $valor_linha ) )
            {
                $peca_pos = [$chave_linha, $chave_coluna];
                break;
            }
        }

        if( ( $this->tabuleiro[$peca_pos[0]][$peca_pos[1]] ) === $this->peca['peca-nome'])
        {
            $this->tabuleiro[$this->linha['linha-nome']][$this->coluna['coluna-nome']] = $this->peca['peca-nome'];
            $this->tabuleiro[$peca_pos[0]][$peca_pos[1]] = null;

            $this->dados['tabuleiro'] = $this->tabuleiro;
            $this->dados['turno'] = ++$this->turno;
            $this->dados['ultimo-movimento'] = $this->peca['peca-cor'];
        }
    }

    public function getData()
    {
        return $this->dados;
    }
}


?>