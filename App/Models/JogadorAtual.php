<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Models;

use Library\Base;

class JogadorAtual extends Base
{
    public function fazer(): void
    {
        $ultimoMovimento = $this->dados->historico->getUltimoMovimento();

        if ($ultimoMovimento) {
            $jogadorAtualEsquerdo = $ultimoMovimento['pecaAtacante']->isPreta() ? '1' : '2';

            if (
                $ultimoMovimento['pecaAtacante']->isPreta() &&
                $this->dados->jogadorSuperiorDireito === '2'
            ) {
                $jogadorAtualSuperiorDireito = '';
                $jogadorAtualInferiorDireito = 'jogadorAtual';
            } else {
                $jogadorAtualSuperiorDireito = 'jogadorAtual';
                $jogadorAtualInferiorDireito = '';
            }
        } else {
            $jogadorAtualEsquerdo = 1;

            if ($this->dados->jogadorSuperiorDireito === '2') {
                $jogadorAtualSuperiorDireito = '';
                $jogadorAtualInferiorDireito = 'jogadorAtual';
            } else {
                $jogadorAtualSuperiorDireito = 'jogadorAtual';
                $jogadorAtualInferiorDireito = '';
            }
        }

        $this->dados->jogadorAtualEsquerdo = $jogadorAtualEsquerdo;
        $this->dados->jogadorAtualSuperiorDireito = $jogadorAtualSuperiorDireito;
        $this->dados->jogadorAtualInferiorDireito = $jogadorAtualInferiorDireito;
    }
}
