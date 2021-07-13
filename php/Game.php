<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class Game
{
    private $tabuleiro;
    private $peca;
    private $linha;
    private $coluna;
    private $acao;
    private $turno;
    private $peca_escolhida;
    private $ultimo_movimento;
    private $mensagem_erro;
    private $pecas_brancas;
    private $pecas_pretas;

    public function start()
    {
        $this->tabuleiro = $_SESSION['tabuleiro'] ?? null;
        $this->peca = $_POST['input-peca'] ?? null;
        $this->linha = $_POST['input-linha'] ?? null;
        $this->coluna = $_POST['input-coluna'] ?? null;
        $this->acao = $_POST['acao'] ?? null;
        $this->turno = $_SESSION['turno'] ?? 1;
        $this->peca_escolhida = $_SESSION['peca-escolhida'] ?? null;
        $this->ultimo_movimento = $_SESSION['ultimo-movimento'] ?? null;
        $this->mensagem_erro = null;
        $this->pecas_brancas = Pecas::getPecasBrancas();
        $this->pecas_pretas = Pecas::getPecasPretas();

        if( $this->acao === 'reset' )
        {
            $_SESSION = [];
            $HomePage = new HomePage();
            $HomePage->start();
            exit();
        }

        if( $this->tabuleiro === null )
        {
            //Monta o tabuleiro de acordo com a cor da peça escolhida
            $Tabuleiro = new Tabuleiro( $this->peca_escolhida, $this->pecas_brancas, $this->pecas_pretas );
            $Tabuleiro->mountTabuleiro();
            $this->tabuleiro = $Tabuleiro->getTabuleiro();
        }

        if( $this->acao === 'mover' )
        {
            try
            {
                $DataInput = new DataInput( $this->peca, $this->linha, $this->coluna );
                $DataInput->check();
                $dados = $DataInput->getData();

                $Regras = new Regras( $this->turno, $this->ultimo_movimento , $dados );
                $Regras->check();

                $MoverPeca = new MoverPeca( $this->tabuleiro, $this->turno, $this->ultimo_movimento, $dados );
                $MoverPeca->mover();
                $dados = $MoverPeca->getData();
            }
            catch( Exception $e )
            {
                $this->mensagem_erro = $e->getMessage();
            }

            if( isset( $dados['tabuleiro'], $dados['turno'], $dados['ultimo-movimento'] ) )
            {
                $this->tabuleiro = $dados['tabuleiro'];
                $this->turno = $dados['turno'];
                $this->ultimo_movimento = $dados['ultimo-movimento'];
            }
        }

        if( $this->acao !== 'reset' )
        {
            $_SESSION['tabuleiro'] = $this->tabuleiro;
            $_SESSION['turno'] = $this->turno;
            $_SESSION['ultimo-movimento'] = $this->ultimo_movimento;
        }

        $dados = [
            'tabuleiro' => $this->tabuleiro,
            'turno' => $this->turno,
            'peca-escolhida' => $this->peca_escolhida,
            'ultimo-movimento' => $this->ultimo_movimento,
            'mensagem-erro' => $this->mensagem_erro
        ];

        $marcacoes = MarkingsHtml::getMarkings();

        $ContentDynamic = new ContentDynamic( $dados );
        $ContentDynamic->make();
        $dados = $ContentDynamic->getData();

        $ReplaceMarkings = new ReplaceMarkings( $marcacoes, $dados );
        $ReplaceMarkings->replace();
        $pagina = $ReplaceMarkings->getPage();

        print $pagina;
    }
}



?>