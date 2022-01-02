<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use Library\Base;

class QualLadoDoJogador extends Base
{
    public function fazer(): void
    {
        if ($this->dados->jogador->isBranco()) {
            $this->dados->jogadorSuperiorDireito = '2';
            $this->dados->jogadorInferiorDireito = '1';
        }
        if ($this->dados->jogador->isPreto()) {
            $this->dados->jogadorSuperiorDireito = '1';
            $this->dados->jogadorInferiorDireito = '2';
        }
    }
}
