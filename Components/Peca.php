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
        return $this->cor === 2;
    }

    public function isBranca(): bool
    {
        return $this->cor === 1;
    }

    public function isPedra(): bool
    {
        return $this->tipo === 3;
    }

    public function isDama(): bool
    {
        return $this->tipo === 4;
    }
}
