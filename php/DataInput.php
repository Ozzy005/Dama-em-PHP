<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class DataInput
{
    private $tabuleiro;
    private $peca;
    private $linha;
    private $coluna;
    private $peca_explode;
    private $linha_explode;
    private $coluna_explode;
    private $peca_checada;
    private $linha_checada;
    private $coluna_checada;
    private $dados = [];

    public function __construct( $tabuleiro, $peca, $linha, $coluna )
    {
        $this->tabuleiro = $tabuleiro;
        $this->peca = $peca;
        $this->linha = $linha;
        $this->coluna = $coluna;
        $this->peca_explode = explode( '-', $peca );
        $this->linha_explode = explode( '-', $linha );
        $this->coluna_explode = explode( '-', $coluna );
    }

    public function check()
    {
        $this->checkPeca();
        $this->checkLinha();
        $this->checkColuna();

        if(  !$this->peca_checada  || !$this->coluna_checada || !$this->linha_checada )
        {
            throw new Exception( 'Dados recebidos inválidos' );
        }
    }

    public function getData()
    {
        return $this->dados;
    }

    private function checkPeca()
    {
        /*
         * exemplo
         * [0] => pedra
         * [1] => branca
         * [2] => 1
         *
        */

        if( count( $this->peca_explode ) === 3 )
        {
            $peca_tipo = ( $this->peca_explode[0] === 'pedra' ) ? true : false;
            $peca_cor = ( $this->peca_explode[1] === 'branca' || $this->peca_explode[1] === 'preta' ) ? true : false;
            $id = preg_match('/^[1-9]$|^[1-9][0-9]$/',$this->peca_explode[2]);
            $peca_id = ( $this->peca_explode[2] >= 1 && $this->peca_explode[2] <= 12 && $id ) ? true : false;

            $peca_checada = ( $peca_tipo && $peca_cor && $peca_id ) ? true : false;

            if( $peca_checada )
            {
                foreach( $this->tabuleiro as $chave_linha => $valor_linha )
                {
                    if( $chave_coluna = array_search( $this->peca, $valor_linha ) )
                    {
                        $posicao_atual = [$chave_linha, $chave_coluna];
                        break;
                    }
                }

                $this->peca_checada = $peca_checada;
                $peca['tipo'] = $this->peca_explode[0];
                $peca['cor'] = $this->peca_explode[1];
                $peca['id'] = $this->peca_explode[2];
                $peca['nome'] = $this->peca;
                $peca['posicao-atual'] = $posicao_atual;
                $this->dados['peca'] = $peca;
            }
        }
    }

    private function checkColuna()
    {
        /*
         * exemplo
         * [0] => coluna
         * [1] => a
         * [2] => branca
        */

        if( count( $this->coluna_explode ) === 3 )
        {
            $coluna_tipo = ( $this->coluna_explode[0] === 'coluna' ) ? true : false;
            $coluna_id = preg_match( '/^[a-h]$/', $this->coluna_explode[1] );
            $coluna_cor = ( $this->coluna_explode[2] === 'branca' || $this->coluna_explode[2] === 'preta' ) ? true : false;

            $coluna_checada = ( $coluna_tipo && $coluna_id && $coluna_cor ) ? true : false;

            if( $coluna_checada )
            {
                $this->coluna_checada = $coluna_checada;
                $coluna['tipo'] = $this->coluna_explode[0];
                $coluna['id'] = $this->coluna_explode[1];
                $coluna['cor'] = $this->coluna_explode[2];
                $coluna['nome'] = $this->coluna;
                $this->dados['coluna'] = $coluna;
            }
        }
    }

    private function checkLinha()
    {
        /*
         * exemplo
         * [0] => linha
         * [1] => 8
        */

        if( count( $this->linha_explode ) === 2 )
        {
            $linha_tipo = ( $this->linha_explode[0] === 'linha' ) ? true : false;
            $id = preg_match('/^[1-8]$/',$this->linha_explode[1]);
            $linha_id = ( $this->linha_explode[1] >= 1 && $this->linha_explode[1] <= 8 && $id ) ? true : false;

            $linha_checada = ( $linha_tipo && $linha_id ) ? true : false;

            if( $linha_checada )
            {
                $this->linha_checada = $linha_checada;
                $linha['tipo'] = $this->linha_explode[0];
                $linha['id'] = $this->linha_explode[1];
                $linha['nome'] = $this->linha;
                $this->dados['linha'] = $linha;
            }
        }
    }
}


?>