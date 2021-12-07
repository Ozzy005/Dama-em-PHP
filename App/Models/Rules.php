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
    public function check()
    {
        try {
            $this->turnoDeQuem();
            $opcoesMapeadas = $this->mapearOpcoesDeCapturasExternas();
            if ($opcoesMapeadas) {
                if ($this->aplicarLeiDaMaioria($opcoesMapeadas)) {
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

            if ($this->checarLimitesDaMargemDoTabuleiro($l, $c) && $tabuleiro->isEmpty($l, $c) && $l == $lDst && $c == $cDst) {
                if ($direcao[$corEscolhida][$pAtacante->color]) {
                    $this->data->moveType = 'mover';
                }
                return $direcao[$corEscolhida][$pAtacante->color];
            }
        }
    }

    private function mapearOpcoesDeCapturasInternas($pAtacante, $lOrigem, $cOrigem)
    {
        $subirCasa = [[1, -1, 2, -2], [1, 1, 2, 2], [-1, -1, -2, -2], [-1, 1, -2, 2]];
        $descerCasa = [[-2, 2], [-2, -2], [2, 2], [2, -2]];
        $pontoDePartida = ['linha' => $lOrigem, 'coluna' => $cOrigem];
        $tabuleiro = $this->data->board;
        $nivelDeProfundidade = $nivelMaximoDeProfundidade = $opcao = 1;
        $trajetoBase = $opcoesMapeadas = $pecasAlvosIgnoradas = [];

        $mapear = function () use (
            &$mapear,
            &$subirCasa,
            &$descerCasa,
            &$pontoDePartida,
            &$tabuleiro,
            &$pAtacante,
            &$nivelDeProfundidade,
            &$nivelMaximoDeProfundidade,
            &$opcao,
            &$trajetoBase,
            &$opcoesMapeadas,
            &$pecasAlvosIgnoradas
        ) {
            for ($i = 0; $i <= 3; ++$i) {
                $lMeioTmp = $pontoDePartida['linha'] + $subirCasa[$i][0];
                $cMeioTmp = $pontoDePartida['coluna'] + $subirCasa[$i][1];
                $lDstTmp = $pontoDePartida['linha'] + $subirCasa[$i][2];
                $cDstTmp = $pontoDePartida['coluna'] + $subirCasa[$i][3];

                if (
                    $this->checarLimitesDaMargemDoTabuleiro($lMeioTmp, $cMeioTmp, $lDstTmp, $cDstTmp)
                    && $tabuleiro->notEmpty($lMeioTmp, $cMeioTmp) && $tabuleiro->isEmpty($lDstTmp, $cDstTmp)
                ) {
                    $pecaAlvo = $tabuleiro->getPiece($lMeioTmp, $cMeioTmp);

                    if (!in_array($pecaAlvo, $pecasAlvosIgnoradas, true) && $pAtacante->color != $pecaAlvo->color) {
                        if ($nivelDeProfundidade < $nivelMaximoDeProfundidade) {
                            ++$opcao;
                            $opcoesMapeadas[$opcao] = $trajetoBase;
                        }

                        $trajetoBase[] = $opcoesMapeadas[$opcao][] = [
                            'linhaOrigem' => $pontoDePartida['linha'],
                            'ColunaOrigem' => $pontoDePartida['coluna'],
                            'linhaDoMeio' => $lMeioTmp,
                            'colunaDoMeio' => $cMeioTmp,
                            'linhaDestino' => $lDstTmp,
                            'colunaDestino' => $cDstTmp,
                            'pecaAlvo' => $pecaAlvo,
                            'pecaAtacante' => $pAtacante
                        ];

                        $tabuleiro->unsetPiece($pontoDePartida['linha'], $pontoDePartida['coluna']);
                        $tabuleiro->setPiece($lDstTmp, $cDstTmp, $pAtacante);
                        $pontoDePartida = ['linha' => $lDstTmp, 'coluna' => $cDstTmp];
                        $pecasAlvosIgnoradas[] = $pecaAlvo;
                        $nivelMaximoDeProfundidade = ++$nivelDeProfundidade;

                        $mapear();

                        $tabuleiro->unsetPiece($pontoDePartida['linha'], $pontoDePartida['coluna']);
                        $pontoDePartida['linha'] += $descerCasa[$i][0];
                        $pontoDePartida['coluna'] += $descerCasa[$i][1];
                        $tabuleiro->setPiece($pontoDePartida['linha'], $pontoDePartida['coluna'], $pAtacante);
                    }
                }
            }

            array_pop($trajetoBase);
            array_pop($pecasAlvosIgnoradas);
            --$nivelDeProfundidade;
        };

        $mapear();
        return $opcoesMapeadas;
    }

    private function aplicarLeiDaMaioria($opcoesMapeadas)
    {
        $pAtacante = $this->data->pieceAttacking;
        $lDst = $this->data->lineDestiny;
        $cDst = $this->data->columnDestiny;
        $sucesso = false;

        $count = array_map('count', $opcoesMapeadas);
        $max = max($count);

        $chaveDasMelhoresOpcoes = array_keys(array_filter($count, function ($value) use ($max) {
            return $value === $max;
        }));

        $opcoesFiltradas = array_map(function ($key) use ($opcoesMapeadas) {
            return $opcoesMapeadas[$key];
        }, $chaveDasMelhoresOpcoes);

        array_walk($opcoesFiltradas, function ($value) use (&$sucesso, $pAtacante, $lDst, $cDst) {
            $last = end($value);
            if (
                !$sucesso && $last['pecaAtacante'] === $pAtacante &&
                $last['linhaDestino'] == $lDst && $last['colunaDestino'] == $cDst
            ) {
                $this->data->targetPieces = $value;
                $this->data->moveType = 'capturar';
                $sucesso = true;
            }
        });

        return $sucesso;
    }

    private function mapearOpcoesDeCapturasExternas()
    {
        $tabuleiro = $this->data->board->getBoard();
        $pAtacante = $this->data->pieceAttacking;
        $opcoesMapeadas = [];
        $linha = 8;

        array_walk_recursive($tabuleiro, function ($peca, $coluna) use ($pAtacante, &$linha, &$opcoesMapeadas) {
            if ($peca && $peca->color == $pAtacante->color) {
                $opcoesMapeadas = array_merge($opcoesMapeadas, $this->mapearOpcoesDeCapturasInternas($peca, $linha, $coluna));
            }
            if (($coluna == 104)) {
                --$linha;
            }
        });

        return $opcoesMapeadas;
    }

    private function checarLimitesDaMargemDoTabuleiro($l1, $c1, $l2 = null, $c2 = null)
    {
        $checar = function ($l1, $c1, $l2 = null, $c2 = null) use (&$checar) {
            if ($l1 >= 1 && $l1 <= 8 && $c1 >= 97 && $c1 <= 104) {
                if ($l2 !== null && $c2 !== null) {
                    return $checar($l2, $c2);
                }
                return true;
            }
        };
        return $checar($l1, $c1, $l2, $c2);
    }
}
