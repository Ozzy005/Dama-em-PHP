<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace Components;

class Turno
{
    private int $turno = 1;

    public function proximo(): void
    {
        ++$this->turno;
    }

    public function getTurno(): int
    {
        return $this->turno;
    }
}
