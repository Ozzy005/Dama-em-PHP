<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class MarkingsHtml
{
    private static $marcacoes =
    [
        'marcacoes-painel-esquerdo' =>
        [
            '{turno-atual}',
            '{jogador-atual-esquerdo}',
            '{mensagem-erro}'
        ],
        'marcacoes-painel-direito' =>
        [
            '{jogador-atual-superior-direito}',
            '{jogador-superior-direito}',
            '{jogador-atual-inferior-direito}',
            '{jogador-inferior-direito}'
        ],
        'marcacoes-tabuleiro' =>
        [
            '{linha-8-coluna-a}',
            '{linha-8-coluna-b}',
            '{linha-8-coluna-c}',
            '{linha-8-coluna-d}',
            '{linha-8-coluna-e}',
            '{linha-8-coluna-f}',
            '{linha-8-coluna-g}',
            '{linha-8-coluna-h}',
            '{linha-7-coluna-a}',
            '{linha-7-coluna-b}',
            '{linha-7-coluna-c}',
            '{linha-7-coluna-d}',
            '{linha-7-coluna-e}',
            '{linha-7-coluna-f}',
            '{linha-7-coluna-g}',
            '{linha-7-coluna-h}',
            '{linha-6-coluna-a}',
            '{linha-6-coluna-b}',
            '{linha-6-coluna-c}',
            '{linha-6-coluna-d}',
            '{linha-6-coluna-e}',
            '{linha-6-coluna-f}',
            '{linha-6-coluna-g}',
            '{linha-6-coluna-h}',
            '{linha-5-coluna-a}',
            '{linha-5-coluna-b}',
            '{linha-5-coluna-c}',
            '{linha-5-coluna-d}',
            '{linha-5-coluna-e}',
            '{linha-5-coluna-f}',
            '{linha-5-coluna-g}',
            '{linha-5-coluna-h}',
            '{linha-4-coluna-a}',
            '{linha-4-coluna-b}',
            '{linha-4-coluna-c}',
            '{linha-4-coluna-d}',
            '{linha-4-coluna-e}',
            '{linha-4-coluna-f}',
            '{linha-4-coluna-g}',
            '{linha-4-coluna-h}',
            '{linha-3-coluna-a}',
            '{linha-3-coluna-b}',
            '{linha-3-coluna-c}',
            '{linha-3-coluna-d}',
            '{linha-3-coluna-e}',
            '{linha-3-coluna-f}',
            '{linha-3-coluna-g}',
            '{linha-3-coluna-h}',
            '{linha-2-coluna-a}',
            '{linha-2-coluna-b}',
            '{linha-2-coluna-c}',
            '{linha-2-coluna-d}',
            '{linha-2-coluna-e}',
            '{linha-2-coluna-f}',
            '{linha-2-coluna-g}',
            '{linha-2-coluna-h}',
            '{linha-1-coluna-a}',
            '{linha-1-coluna-b}',
            '{linha-1-coluna-c}',
            '{linha-1-coluna-d}',
            '{linha-1-coluna-e}',
            '{linha-1-coluna-f}',
            '{linha-1-coluna-g}',
            '{linha-1-coluna-h}'
        ]
    ];

    public static function getMarkings()
    {
        return self::$marcacoes;
    }
}