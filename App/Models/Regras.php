<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use Components\Peca;
use Library\Base;
use Exception;

class Regras extends Base
{
    public function aplicar(): bool
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
            }
            throw new Exception('Movimento Inválido');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function turnoDeQuem(): void
    {
        $historico = $this->dados->historico;
        $ultimoMovimento = $historico->getUltimoMovimento();
        $pAtc = $this->dados->pecaAtacante;

        if ($ultimoMovimento && $ultimoMovimento['pecaAtacante']->cor === $pAtc->cor) {
            throw new Exception('Não é sua vez de jogar');
        } elseif (!$ultimoMovimento && $pAtc->isPreta()) {
            throw new Exception('Peças brancas devem fazer o lance inicial');
        }
    }

    private function movimento(): bool
    {
        $jogador = $this->dados->jogador;
        $tabuleiro = $this->dados->tabuleiro;
        $pAtc = $this->dados->pecaAtacante;
        $lOrigem = $this->dados->linhaOrigem;
        $cOrigem = $this->dados->colunaOrigem;
        $lDst = $this->dados->linhaDestino;
        $cDst = $this->dados->colunaDestino;
        $subirCasa = [
            [1, -1],
            [1, 1],
            [-1, -1],
            [-1, +1]
        ];
        $direcao = [
            1 => [
                1 => $lOrigem < $lDst,
                2 => $lOrigem > $lDst
            ],
            2 => [
                1 => $lOrigem > $lDst,
                2 => $lOrigem < $lDst
            ]
        ];

        for ($n = 0; $n <= 3; ++$n) {
            $l = $lOrigem + $subirCasa[$n][0];
            $c = $cOrigem + $subirCasa[$n][1];

            if (
                $this->checarLimitesDaMargemDoTabuleiro($l, $c) &&
                $tabuleiro->colunaEmpty($l, $c) && $l === $lDst && $c === $cDst
            ) {
                if ($direcao[$jogador->id][$pAtc->cor]) {
                    $this->dados->tipoMovimento = 'mover';
                }
                return $direcao[$jogador->id][$pAtc->cor];
            }
        }

        return false;
    }

    private function mapearOpcoesDeCapturasInternas(Peca $pAtc, int $lOrigem, int $cOrigem): array
    {
        $tabuleiro = $this->dados->tabuleiro;
        $jogador = $this->dados->jogador;
        $nivelDeProfundidade = $nivelMaximoDeProfundidade = $opcao = 1;
        $trajetoBase = $opcoesMapeadas = $pecasAlvosIgnoradas = [];
        $subirCasa = [
            [1, -1, 2, -2],
            [1, 1, 2, 2],
            [-1, -1, -2, -2],
            [-1, 1, -2, 2]
        ];

        $mapear = function ($lOrigem, $cOrigem) use (
            &$mapear,
            &$subirCasa,
            &$jogador,
            &$tabuleiro,
            &$pAtc,
            &$nivelDeProfundidade,
            &$nivelMaximoDeProfundidade,
            &$opcao,
            &$trajetoBase,
            &$opcoesMapeadas,
            &$pecasAlvosIgnoradas
        ) {
            for ($i = 0; $i <= 3; ++$i) {
                $lMeio = $lOrigem + $subirCasa[$i][0];
                $cMeio = $cOrigem + $subirCasa[$i][1];
                $lDst = $lOrigem + $subirCasa[$i][2];
                $cDst = $cOrigem + $subirCasa[$i][3];

                if (
                    $this->checarLimitesDaMargemDoTabuleiro($lMeio, $cMeio, $lDst, $cDst) &&
                    $tabuleiro->colunaNotEmpty($lMeio, $cMeio) && $tabuleiro->colunaEmpty($lDst, $cDst)
                ) {
                    $pecaAlvo = $tabuleiro->getPeca($lMeio, $cMeio);

                    if (!in_array($pecaAlvo, $pecasAlvosIgnoradas, true) && $pAtc->cor !== $pecaAlvo->cor) {
                        if ($nivelDeProfundidade < $nivelMaximoDeProfundidade) {
                            ++$opcao;
                            $opcoesMapeadas[$opcao] = $trajetoBase;
                        }

                        $trajetoBase[] = $opcoesMapeadas[$opcao][] = [
                            'linhaOrigem' => $lOrigem,
                            'ColunaOrigem' => $cOrigem,
                            'linhaMeio' => $lMeio,
                            'colunaMeio' => $cMeio,
                            'linhaDestino' => $lDst,
                            'colunaDestino' => $cDst,
                            'pecaAlvo' => $pecaAlvo,
                            'pecaAtacante' => $pAtc,
                            'jogador' => $jogador
                        ];

                        $tabuleiro->deslocarPeca($lOrigem, $cOrigem, $lDst, $cDst);
                        $pecasAlvosIgnoradas[] = $pecaAlvo;
                        $nivelMaximoDeProfundidade = ++$nivelDeProfundidade;

                        $mapear($lDst, $cDst);

                        $tabuleiro->deslocarPeca($lDst, $cDst, $lOrigem, $cOrigem);
                    }
                }
            }

            array_pop($trajetoBase);
            array_pop($pecasAlvosIgnoradas);
            --$nivelDeProfundidade;
        };

        $mapear($lOrigem, $cOrigem);
        return $opcoesMapeadas;
    }

    private function aplicarLeiDaMaioria(array $opcoesMapeadas): bool
    {
        $pAtc = $this->dados->pecaAtacante;
        $lDst = $this->dados->linhaDestino;
        $cDst = $this->dados->colunaDestino;
        $retorno = false;

        $count = array_map('count', $opcoesMapeadas);
        $max = max($count);

        $chaveDasMelhoresOpcoes = array_keys(array_filter($count, function ($value) use ($max) {
            return $value === $max;
        }));

        $opcoesFiltradas = array_map(function ($key) use ($opcoesMapeadas) {
            return $opcoesMapeadas[$key];
        }, $chaveDasMelhoresOpcoes);

        array_walk($opcoesFiltradas, function ($value) use (&$retorno, $pAtc, $lDst, $cDst) {
            $last = end($value);
            if (
                !$retorno && $last['pecaAtacante'] === $pAtc &&
                $last['linhaDestino'] === $lDst && $last['colunaDestino'] === $cDst
            ) {
                $this->dados->pecasAlvos = $value;
                $this->dados->tipoMovimento = 'capturar';
                $retorno = true;
            }
        });

        return $retorno;
    }

    private function mapearOpcoesDeCapturasExternas(): array
    {
        $tabuleiro = $this->dados->tabuleiro->getTabuleiro();
        $pAtc = $this->dados->pecaAtacante;
        $opcoesMapeadas = [];
        $linha = 8;

        array_walk_recursive($tabuleiro, function ($peca, $coluna) use ($pAtc, &$linha, &$opcoesMapeadas) {
            if ($peca instanceof Peca && $peca->cor === $pAtc->cor) {
                $opcoesMapeadas = array_merge($opcoesMapeadas, $this->mapearOpcoesDeCapturasInternas($peca, $linha, $coluna));
            }
            if (($coluna === 104)) {
                --$linha;
            }
        });

        return $opcoesMapeadas;
    }

    private function checarLimitesDaMargemDoTabuleiro(int $l1, int $c1, ?int $l2 = null, ?int $c2 = null): bool
    {
        $checar = function ($l1, $c1, $l2 = null, $c2 = null) use (&$checar) {
            if ($l1 >= 1 && $l1 <= 8 && $c1 >= 97 && $c1 <= 104) {
                if ($l2 !== null && $c2 !== null) {
                    return $checar($l2, $c2);
                }
                return true;
            }
            return false;
        };
        return $checar($l1, $c1, $l2, $c2);
    }
}
