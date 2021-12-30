<?php

/**
 *
 * @author Rafael Arend
 *
**/

namespace Components;

class Historico
{
    private array $historico = [];
    private array $ultimoMovimento = [];

    public function push(Turno $turno, array $movimento): void
    {
        $this->historico[$turno->getTurno()] = $movimento;
        $this->ultimoMovimento = $movimento;
    }

    public function getUltimoMovimento(): array
    {
        return $this->ultimoMovimento;
    }
}
