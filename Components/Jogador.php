<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace Components;

class Jogador
{
    public readonly int $id;
    public readonly int $cor;

    public function __construct(int $jogadorId)
    {
        $this->id = $jogadorId;
        $this->cor = $jogadorId; //pensando em uma futura implementação
    }

    public function isBranco(): bool
    {
        return $this->id === 1;
    }

    public function isPreto(): bool
    {
        return $this->id === 2;
    }
}
