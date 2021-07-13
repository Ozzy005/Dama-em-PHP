<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class ContentDynamic
{
    private $tabuleiro;
    private $turno;
    private $peca_escolhida;
    private $ultimo_movimento;
    private $mensagem_erro;
    private $dados = [];

    public function __construct( $dados )
    {
        $this->tabuleiro = $dados['tabuleiro'];
        $this->turno = $dados['turno'];
        $this->dados['turno'] = $dados['turno'];
        $this->peca_escolhida = $dados['peca-escolhida'];
        $this->ultimo_movimento = $dados['ultimo-movimento'];
        $this->mensagem_erro = $dados['mensagem-erro'];
    }

    public function make()
    {
        $this->makePecas();
        $this->makeMessageError();
        $this->makeSelectedColor();
        $this->makePlayerCurrent();
    }

    public function getData()
    {
        return $this->dados;
    }

    private function makePecas()
    {
        $this->dados['pecas'] = [];
        $tag = '';

        foreach( $this->tabuleiro as $chave_linha => $valor_linha )
        {
            foreach( $valor_linha as $chave_coluna => $peca )
            {
                /*
                * exemplo
                * [0] => pedra
                * [1] => branca
                * [2] => 1
                *
                */

                $peca_explode = explode( '-', $peca );

                if( $peca )
                {
                    $tag = "<div id='{$peca}' class='peca {$peca_explode[0]}-{$peca_explode[1]}'></div>";
                    $this->dados['pecas'][] = $tag;
                }
                else
                {
                    $this->dados['pecas'][] = '';
                }
            }
        }
    }

    private function makeMessageError()
    {
        if( $this->mensagem_erro )
        {
            $this->dados['mensagem-erro'] = "<div class='mensagem-erro'>{$this->mensagem_erro}</div>";
        }
        else
        {
            $this->dados['mensagem-erro'] = '';
        }
    }

    private function makeSelectedColor()
    {
        if( $this->peca_escolhida === 'cor-branca' )
        {
            $this->dados['jogador-superior-direito'] = '2';
            $this->dados['jogador-inferior-direito'] = '1';
        }
        if( $this->peca_escolhida === 'cor-preta' )
        {
            $this->dados['jogador-superior-direito'] = '1';
            $this->dados['jogador-inferior-direito'] = '2';
        }
    }

    private function makePlayerCurrent()
    {
        $this->dados['jogador-atual-esquerdo'] = $this->ultimo_movimento === 'branca' ? '2' : '1';

        if( $this->dados['jogador-superior-direito'] === '1' )
        {
            if( $this->ultimo_movimento === 'branca' )
            {
                $this->dados['jogador-atual-superior-direito'] = '';
                $this->dados['jogador-atual-inferior-direito'] = 'jogador-atual';
            }
            if( $this->ultimo_movimento === 'preta' )
            {
                $this->dados['jogador-atual-superior-direito'] = 'jogador-atual';
                $this->dados['jogador-atual-inferior-direito'] = '';
            }
            if( $this->ultimo_movimento === null )
            {
                $this->dados['jogador-atual-superior-direito'] = 'jogador-atual';
                $this->dados['jogador-atual-inferior-direito'] = '';
            }
        }
        if( $this->dados['jogador-superior-direito'] === '2' )
        {
            if( $this->ultimo_movimento === 'branca' )
            {
                $this->dados['jogador-atual-superior-direito'] = 'jogador-atual';
                $this->dados['jogador-atual-inferior-direito'] = '';
            }
            if( $this->ultimo_movimento === 'preta' )
            {
                $this->dados['jogador-atual-superior-direito'] = '';
                $this->dados['jogador-atual-inferior-direito'] = 'jogador-atual';
            }
            if( $this->ultimo_movimento === null )
            {
                $this->dados['jogador-atual-superior-direito'] = '';
                $this->dados['jogador-atual-inferior-direito'] = 'jogador-atual';
            }
        }
    }
}
