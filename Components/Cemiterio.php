<?php

/**
 *
 * @author Rafael Arend
 *
**/

namespace Components;

class Cemiterio
{
    private array $cemiterio = [];

    public function push(Jogador $jogador, Peca $pecaAlvo): void
    {
        $this->cemiterio[$jogador->id][] = $pecaAlvo;
    }
}
