<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace Library;

use Components\{Tabuleiro, Peca, Jogador, Turno, Historico, Cemiterio};

class Dados
{
    private static self $instance;
    public Tabuleiro $tabuleiro;
    public Jogador $jogador;
    public Turno $turno;
    public Historico $historico;
    public Cemiterio $cemiterio;
    public string $jogadorAtualEsquerdo;
    public string $jogadorSuperiorDireito;
    public string $jogadorInferiorDireito;
    public string $jogadorAtualSuperiorDireito;
    public string $jogadorAtualInferiorDireito;
    public Peca $pecaAtacante;
    public int $linhaOrigem;
    public int $colunaOrigem;
    public int $linhaDestino;
    public int $colunaDestino;
    public string $tipoMovimento;
    public array $pecasAlvos;
    public string $alerta;

    private function __construct()
    {
    }

    private function __clone(): void
    {
    }

    public function __wakeup(): void
    {
        self::$instance = $this;
    }

    public function __sleep(): array
    {
        return [
            'tabuleiro',
            'jogador',
            'turno',
            'historico',
            'cemiterio',
            'jogadorAtualEsquerdo',
            'jogadorSuperiorDireito',
            'jogadorInferiorDireito',
            'jogadorAtualSuperiorDireito',
            'jogadorAtualInferiorDireito'
        ];
    }

    public static function getInstance(): self
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
