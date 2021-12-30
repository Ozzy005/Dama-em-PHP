<?php

/**
 *
 * @author Rafael Arend
 *
**/

namespace App\Models;

use Components\{Tabuleiro as TabuleiroComponente, Peca};
use Library\Base;

class Tabuleiro extends Base
{
    public function fazer(): void
    {
        if ($this->dados->jogador->isBranco()) {
            $this->montar(1, 2);
        }
        if ($this->dados->jogador->isPreto()) {
            $this->montar(2, 1);
        }
    }

    private function montar(int $jogadorInferior, int $jogadorSuperior): void
    {
        $tabuleiro = new TabuleiroComponente;
        $pecaInferiorId = 1;
        $pecaSuperiorId = 12;

        for ($l = 1; $l <= 8; ++$l) {
            for ($c = 97; $c <= 104; ++$c) {
                if ($tabuleiro->colunaIsPreta($l, $c)) {
                    if ($l >= 1 && $l <= 3) {
                        $tabuleiro->putPeca($l, $c, new Peca($pecaInferiorId, 3, $jogadorInferior));
                        ++$pecaInferiorId;
                    }
                    if ($l >= 6 && $l <= 8) {
                        $tabuleiro->putPeca($l, $c, new Peca($pecaSuperiorId, 3, $jogadorSuperior));
                        --$pecaSuperiorId;
                    }
                }
            }
        }

        $this->dados->tabuleiro = $tabuleiro;
    }
}
