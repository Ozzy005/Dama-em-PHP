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
        if ($this->id === 1) {
            return true;
        }

        return false;
    }

    public function isPreto(): bool
    {
        if ($this->id === 2) {
            return true;
        }

        return false;
    }
}
