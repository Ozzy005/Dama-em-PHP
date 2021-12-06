<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use App\Core\Father;
use Exception;

class Rules extends Father
{
    private $nivelDeProfundidade = 1;
    private $nivelMaximoDeProfundidade = 1;
    private $pontoDePartida;
    private $trajetoBase = [];
    private $opcao = 1;
    private $opcoesInternasMapeadas = [];
    private $pecasAlvosIgnoradas = [];

    public function check()
    {
        try {
            $this->turnoDeQuem();
            $opcoesExternasMapeadas = $this->mapearOpcoesDeCapturasExternas();
            if ($opcoesExternasMapeadas) {
                if ($this->aplicarLeiDaMaioria($opcoesExternasMapeadas)) {
                    return true;
                }
                throw new Exception('Movimento Inválido');
            }
            if ($this->movimento()) {
                return true;
            } else {
                throw new Exception('Movimento Inválido');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function turnoDeQuem()
    {
        $historicoDeMovimento = $this->data->movementHistory;
        $pAtacante = $this->data->pieceAttacking;
        $ultimoMovimento = $historicoDeMovimento->getLastMove();

        if ($ultimoMovimento && $ultimoMovimento['piece-attacking']->color == $pAtacante->color) {
            throw new Exception('Não é sua vez de jogar');
        } elseif (!$ultimoMovimento && $pAtacante->isBlack()) {
            throw new Exception('O lance inicial cabe ao jogador que estiver com as peças brancas');
        }
    }

    private function movimento()
    {
        $corEscolhida = $this->data->playerChosen;
        $tabuleiro = $this->data->board;
        $pAtacante = $this->data->pieceAttacking;
        $lOrigem = $this->data->lineSource;
        $cOrigem = $this->data->columnSource;
        $lDst = $this->data->lineDestiny;
        $cDst = $this->data->columnDestiny;
        $subirCasa = [[1, -1], [1, 1], [-1, -1], [-1, +1]];
        $direcao = [1 => [1 => $lOrigem < $lDst, 2 => $lOrigem > $lDst], 2 => [1 => $lOrigem > $lDst, 2 => $lOrigem < $lDst]];

        for ($n = 0; $n <= 3; ++$n) {
            $l = $lOrigem + $subirCasa[$n][0];
            $c = $cOrigem + $subirCasa[$n][1];

            if ($this->checarLimitesDaMargemDoTabuleiro($l, $c) && $tabuleiro->isEmpty($l, $c) && $l + $c == $lDst + $cDst) {
                if ($direcao[$corEscolhida][$pAtacante->color]) {
                    $this->data->moveType = 'mover';
                }

                return $direcao[$corEscolhida][$pAtacante->color];
            }
        }
    }

    private function mapearOpcoesDeCapturasInternas($pAtacante, $lOrigem = null, $cOrigem = null)
    {
        $tabuleiro = $this->data->board;
        $subirCasa = [[1, -1, 2, -2], [1, 1, 2, 2], [-1, -1, -2, -2], [-1, 1, -2, 2]];
        $descerCasa = [[-2, 2], [-2, -2], [2, 2], [2, -2]];

        if (!$this->pontoDePartida && $lOrigem && $cOrigem) {
            $this->pontoDePartida = ['linha' => $lOrigem, 'coluna' => $cOrigem];
        }

        for ($i = 0; $i <= 3; ++$i) {
            $lMeioTmp = $this->pontoDePartida['linha'] + $subirCasa[$i][0];
            $cMeioTmp = $this->pontoDePartida['coluna'] + $subirCasa[$i][1];
            $lDstTmp = $this->pontoDePartida['linha'] + $subirCasa[$i][2];
            $cDstTmp = $this->pontoDePartida['coluna'] + $subirCasa[$i][3];

            if ($this->checarLimitesDaMargemDoTabuleiro($lMeioTmp, $cMeioTmp, $lDstTmp, $cDstTmp)) {
                if ($tabuleiro->notEmpty($lMeioTmp, $cMeioTmp) && $tabuleiro->isEmpty($lDstTmp, $cDstTmp)) {
                    $pecaAlvo = $tabuleiro->getPiece($lMeioTmp, $cMeioTmp);

                    $pecaAlvoIgnoradaId = 0;
                    $pecasAlvosIgnoradasQuantidade = count($this->pecasAlvosIgnoradas);
                    for ($n = 0; $n < $pecasAlvosIgnoradasQuantidade; ++$n) {
                        $pecaAlvoIgnoradaId = $this->pecasAlvosIgnoradas[$n]->id;
                        if ($pecaAlvo->id == $pecaAlvoIgnoradaId) {
                            break;
                        }
                    }

                    if ($pecaAlvo->id != $pecaAlvoIgnoradaId && $pAtacante->color != $pecaAlvo->color) {
                        if ($this->nivelDeProfundidade < $this->nivelMaximoDeProfundidade) {
                            ++$this->opcao;
                            $this->opcoesInternasMapeadas[$this->opcao] = $this->trajetoBase;
                        }

                        $this->trajetoBase[] = $this->opcoesInternasMapeadas[$this->opcao][] = [
                            'linhaOrigem' => $this->pontoDePartida['linha'],
                            'ColunaOrigem' => $this->pontoDePartida['coluna'],
                            'linhaDoMeio' => $lMeioTmp,
                            'colunaDoMeio' => $cMeioTmp,
                            'linhaDestino' => $lDstTmp,
                            'colunaDestino' => $cDstTmp,
                            'pecaAlvo' => $pecaAlvo,
                            'pecaAtacante' => $pAtacante
                        ];

                        $tabuleiro->unsetPiece($this->pontoDePartida['linha'], $this->pontoDePartida['coluna']);
                        $tabuleiro->setPiece($lDstTmp, $cDstTmp, $pAtacante);
                        $this->pontoDePartida = ['linha' => $lDstTmp, 'coluna' => $cDstTmp];
                        $this->pecasAlvosIgnoradas[] = $pecaAlvo;
                        $this->nivelMaximoDeProfundidade = ++$this->nivelDeProfundidade;
                        $this->mapearOpcoesDeCapturasInternas($pAtacante);

                        $tabuleiro->unsetPiece($this->pontoDePartida['linha'], $this->pontoDePartida['coluna']);
                        $this->pontoDePartida['linha'] += $descerCasa[$i][0];
                        $this->pontoDePartida['coluna'] += $descerCasa[$i][1];
                        $tabuleiro->setPiece($this->pontoDePartida['linha'], $this->pontoDePartida['coluna'], $pAtacante);
                    }
                }
            }
        }

        array_pop($this->trajetoBase);
        array_pop($this->pecasAlvosIgnoradas);
        --$this->nivelDeProfundidade;

        if (!$this->nivelDeProfundidade && count($this->opcoesInternasMapeadas)) {
            $opcoesContadas = array_map('count', $this->opcoesInternasMapeadas);
            $melhorOpcao = array_keys($opcoesContadas, max($opcoesContadas));

            $retorno = [];
            foreach ($melhorOpcao as $value) {
                $retorno[$value] = $this->opcoesInternasMapeadas[$value];
            }

            return $retorno;
        }
    }

    private function aplicarLeiDaMaioria($opcoesMapeadas)
    {
        $pAtacante = $this->data->pieceAttacking;
        $lDst = $this->data->lineDestiny;
        $cDst = $this->data->columnDestiny;

        $opcoesContadas = array_map('count', $opcoesMapeadas);
        $chaveDasMelhoresOpcoes = array_keys($opcoesContadas, max($opcoesContadas));

        if (count($chaveDasMelhoresOpcoes) == 1) {
            $chaveDaMelhorOpcao = $chaveDasMelhoresOpcoes[0];
            $pecasAlvos = $opcoesMapeadas[$chaveDaMelhorOpcao];
            $ultimaPecaAlvo = end($pecasAlvos);

            if ($ultimaPecaAlvo['linhaDestino'] == $lDst && $ultimaPecaAlvo['colunaDestino'] == $cDst) {
                $this->data->moveType = 'capturar';
                $this->data->targetPieces = $pecasAlvos;
                return true;
            }
        } elseif (count($chaveDasMelhoresOpcoes) > 1) {
            for ($i = 0; $i < count($chaveDasMelhoresOpcoes); ++$i) {
                $chaveDaMelhorOpcao = $chaveDasMelhoresOpcoes[$i];
                $pecasAlvos = $opcoesMapeadas[$chaveDaMelhorOpcao];
                $ultimaPecaAlvo = end($pecasAlvos);

                if (
                    $ultimaPecaAlvo['pecaAtacante']->id == $pAtacante->id &&
                    $ultimaPecaAlvo['linhaDestino'] == $lDst && $ultimaPecaAlvo['colunaDestino'] == $cDst
                ) {
                    $this->data->moveType = 'capturar';
                    $this->data->targetPieces = $pecasAlvos;
                    return true;
                }
            }
        }
    }

    private function mapearOpcoesDeCapturasExternas()
    {
        $tabuleiro = $this->data->board;
        $pAtacante = $this->data->pieceAttacking;
        $opcoesExternasMapeadas = [];

        foreach ($tabuleiro->getBoard() as $chaveDaLinha => $linha) {
            foreach ($linha as $coluna => $peca) {
                if ($tabuleiro->isBlack($chaveDaLinha, $coluna) && $peca && $peca->color == $pAtacante->color) {
                    $melhorOpcaoInterna = $this->mapearOpcoesDeCapturasInternas($peca, $chaveDaLinha, $coluna);

                    if ($melhorOpcaoInterna) {
                        $opcoesExternasMapeadas = array_merge($opcoesExternasMapeadas, $melhorOpcaoInterna);
                    }
                    $this->nivelDeProfundidade = $this->nivelMaximoDeProfundidade = $this->opcao = 1;
                    $this->pontoDePartida = $this->pecasAlvosIgnoradas = $this->trajetoBase = $this->opcoesInternasMapeadas = [];
                }
            }
        }

        if (count($opcoesExternasMapeadas)) {
            return $opcoesExternasMapeadas;
        }
    }

    private function checarLimitesDaMargemDoTabuleiro($lMeio, $cMeio, $lDst = null, $cDst = null)
    {
        $checar = function ($l, $c) {
            if ($l >= 1 && $l <= 8 && $c >= 97 && $c <= 104) {
                return true;
            }
        };

        if (!$lDst && !$cDst) {
            if ($checar($lMeio, $cMeio)) {
                return true;
            }
        }
        if ($checar($lMeio, $cMeio) && $checar($lDst, $cDst)) {
            return true;
        }
    }
}
