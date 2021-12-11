<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace Components;

class Peca
{
    // 1 = branca
    // 2 = preta
    // 3 = pedra
    // 4 = dama
    // 1-12 = id

    public readonly int $id;
    public readonly int $tipo;
    public readonly int $cor;

    public function __construct(int $id, int $tipo, int $cor)
    {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->cor = $cor;
    }

    public function isPreta(): bool
    {
        if ($this->cor === 2) {
            return true;
        }

        return false;
    }

    public function isBranca(): bool
    {
        if ($this->cor === 1) {
            return true;
        }

        return false;
    }

    public function isPedra(): bool
    {
        if ($this->tipo === 3) {
            return true;
        }

        return false;
    }

    public function isDama(): bool
    {
        if ($this->tipo === 4) {
            return true;
        }

        return false;
    }
}
