<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class ReplaceMarkings
{
    private $pagina;
    private $marcacoes;
    private $dados;

    public function __construct( $marcacoes, $dados )
    {
        $this->pagina = file_get_contents('html/Tabuleiro.html');
        $this->marcacoes = $marcacoes;
        $this->dados = $dados;
    }

    public function replace()
    {
        //substitua marcações do painel esquerdo
        $marcacoes_painel_esquerdo = $this->marcacoes['marcacoes-painel-esquerdo'];
        $replace_painel_esquerdo =
        [
            'turno' => $this->dados['turno'],
            'jogador-atual-esquerdo' => $this->dados['jogador-atual-esquerdo'],
            'mensagem-erro' => $this->dados['mensagem-erro']
        ];
        $this->pagina = str_replace( $marcacoes_painel_esquerdo, $replace_painel_esquerdo, $this->pagina );

        //substitua marcações do painel direito
        $marcacoes_painel_direito = $this->marcacoes['marcacoes-painel-direito'];
        $replace_painel_direito =
        [
            'jogador-atual-superior-direito' => $this->dados['jogador-atual-superior-direito'],
            'jogador-superior-direito' => $this->dados['jogador-superior-direito'],
            'jogador-atual-inferior-direito' => $this->dados['jogador-atual-inferior-direito'],
            'jogador-inferior-direito' => $this->dados['jogador-inferior-direito']
        ];
        $this->pagina = str_replace( $marcacoes_painel_direito, $replace_painel_direito, $this->pagina);

        //substitua marcações do tabuleiro
        $marcacoes_tabuleiro = $this->marcacoes['marcacoes-tabuleiro'];
        $replace_tabuleiro = $this->dados['pecas'];
        $this->pagina = str_replace( $marcacoes_tabuleiro, $replace_tabuleiro, $this->pagina);
    }

    public function getPage()
    {
        return $this->pagina;
    }
}
?>