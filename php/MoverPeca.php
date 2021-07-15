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
        if( ( $this->tabuleiro[$this->peca['posicao-atual'][0]][$this->peca['posicao-atual'][1]] ) === $this->peca['nome'])
        {
            $this->tabuleiro[$this->linha['nome']][$this->coluna['nome']] = $this->peca['nome'];
            $this->tabuleiro[$this->peca['posicao-atual'][0]][$this->peca['posicao-atual'][1]] = null;
            $this->dados['tabuleiro'] = $this->tabuleiro;
            $this->dados['turno'] = ++$this->turno;
            $this->dados['ultimo-movimento'] = $this->peca['cor'];
        }
    }

    public function getData()
    {
        return $this->dados;
    }
}


?>