<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use Library\Base;

class Movimento extends Base
{
    public function fazer(): void
    {
        $tipoMovimento = $this->dados->tipoMovimento;

        if ($tipoMovimento === 'mover') {
            $this->mover();
        } elseif ($tipoMovimento === 'capturar') {
            $this->capturar();
        }
    }

    private function mover(): void
    {
        $tabuleiro = $this->dados->tabuleiro;
        $jogador = $this->dados->jogador;
        $turno = $this->dados->turno;
        $historico = $this->dados->historico;
        $pAtc = $this->dados->pecaAtacante;
        $lOrigem = $this->dados->linhaOrigem;
        $cOrigem = $this->dados->colunaOrigem;
        $lDst = $this->dados->linhaDestino;
        $cDst = $this->dados->colunaDestino;
        $tipoMovimento = $this->dados->tipoMovimento;

        $tabuleiro->deslocarPeca($lOrigem, $cOrigem, $lDst, $cDst);
        $movimento = [
            'linhaOrigem' => $lOrigem,
            'colunaOrigem' => $cOrigem,
            'linhaDestino' => $lDst,
            'colunaDestino' => $cDst,
            'pecaAtacante' => $pAtc,
            'jogador' => $jogador,
            'tipoMovimento' => $tipoMovimento
        ];
        $historico->push($turno, $movimento);
        $turno->proximo();
    }

    private function capturar(): void
    {
        $tabuleiro = $this->dados->tabuleiro;
        $jogador = $this->dados->jogador;
        $turno = $this->dados->turno;
        $historico = $this->dados->historico;
        $cemiterio = $this->dados->cemiterio;
        $pAtc = $this->dados->pecaAtacante;
        $lOrigem = $this->dados->linhaOrigem;
        $cOrigem = $this->dados->colunaOrigem;
        $lDst = $this->dados->linhaDestino;
        $cDst = $this->dados->colunaDestino;
        $pecasAlvos = $this->dados->pecasAlvos;
        $tipoMovimento = $this->dados->tipoMovimento;

        if ($lOrigem !== $lDst && $cOrigem !== $cDst) {
            $tabuleiro->deslocarPeca($lOrigem, $cOrigem, $lDst, $cDst);
        }
        array_map(function ($pecaAlvo) use ($tabuleiro, $jogador, $cemiterio) {
            $tabuleiro->forgetPeca($pecaAlvo['linhaMeio'], $pecaAlvo['colunaMeio']);
            $cemiterio->push($jogador, $pecaAlvo['pecaAlvo']);
        }, $pecasAlvos);

        $movimento = [
            'linhaOrigem' => $lOrigem,
            'colunaOrigem' => $cOrigem,
            'linhaDestino' => $lDst,
            'colunaDestino' => $cDst,
            'pecaAtacante' => $pAtc,
            'pecasAlvos' => $pecasAlvos,
            'jogador' => $jogador,
            'tipoMovimento' => $tipoMovimento
        ];
        $historico->push($turno, $movimento);
        $turno->proximo();
    }
}
