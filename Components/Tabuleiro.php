<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace Components;

use Error;

class Tabuleiro
{
    private array $tabuleiro = [
        8 => [97 => null, 98 => null, 99 => null, 100 => null, 101 => null, 102 => null, 103 => null, 104 => null],
        7 => [97 => null, 98 => null, 99 => null, 100 => null, 101 => null, 102 => null, 103 => null, 104 => null],
        6 => [97 => null, 98 => null, 99 => null, 100 => null, 101 => null, 102 => null, 103 => null, 104 => null],
        5 => [97 => null, 98 => null, 99 => null, 100 => null, 101 => null, 102 => null, 103 => null, 104 => null],
        4 => [97 => null, 98 => null, 99 => null, 100 => null, 101 => null, 102 => null, 103 => null, 104 => null],
        3 => [97 => null, 98 => null, 99 => null, 100 => null, 101 => null, 102 => null, 103 => null, 104 => null],
        2 => [97 => null, 98 => null, 99 => null, 100 => null, 101 => null, 102 => null, 103 => null, 104 => null],
        1 => [97 => null, 98 => null, 99 => null, 100 => null, 101 => null, 102 => null, 103 => null, 104 => null],
    ];

    public function colunaIsPreta(int $l, int $c): bool
    {
        if ($l % 2 > 0 && $c % 2 > 0) {
            return true;
        }
        if ($l % 2 === 0 && $c % 2 === 0) {
            return true;
        }

        return false;
    }

    public function colunaIsBranca(int $l, int $c): bool
    {
        if ($l % 2 > 0 && $c % 2 === 0) {
            return true;
        }
        if ($l % 2 === 0 && $c % 2 > 0) {
            return true;
        }

        return false;
    }

    public function colunaEmpty(int $l, int $c): bool
    {
        return !$this->tabuleiro[$l][$c];
    }

    public function colunaNotEmpty(int $l, int $c): bool
    {
        return $this->tabuleiro[$l][$c] instanceof Peca;
    }

    public function putPeca(int $l, int $c, Peca $p): void
    {
        if ($this->colunaIsBranca($l, $c) || $this->colunaNotEmpty($l, $c)) {
            throw new Error('Disposicao de peca no tabuleiro invalida');
        }

        $this->tabuleiro[$l][$c] = $p;
    }

    public function forgetPeca(int $l, int $c): void
    {
        if ($this->colunaEmpty($l, $c)) {
            throw new Error('Tentando remover peca de uma casa vazia');
        }

        $this->tabuleiro[$l][$c] = null;
    }

    public function getPeca(int $l, int $c): Peca
    {
        if ($this->colunaEmpty($l, $c)) {
            throw new Error('Tentando pegar peca de uma casa vazia');
        }

        return $this->tabuleiro[$l][$c];
    }

    public function pecaExits(int $l, int $c, Peca $peca): bool
    {
        return $this->tabuleiro[$l][$c] === $peca;
    }

    public function deslocarPeca(int $lOrigem, int $cOrigem, int $lDst, int $cDst): void
    {
        if (
            $this->colunaEmpty($lOrigem, $cOrigem) || $this->colunaIsBranca($lDst, $cDst) ||
            $this->colunaNotEmpty($lDst, $cDst)
        ) {
            throw new Error('Deslocamento de peca invalida');
        }

        $peca = $this->getPeca($lOrigem, $cOrigem);
        $this->putPeca($lDst, $cDst, $peca);
        $this->forgetPeca($lOrigem, $cOrigem);
    }

    public function getTabuleiro(): array
    {
        return $this->tabuleiro;
    }
}
