<?php

/**
 *
 * @author Rafael Arend
 *
 **/

use App\Http\Controllers\{Home, Tabuleiro};
use App\Http\Middlewares\{RedirectSeEmExecucao, RedirectSeNaoEmExecucao};
use Library\Router;

Router::middleware(RedirectSeEmExecucao::class, function () {
    Router::get('/', [Home::class, 'exibir']);
    Router::get('/home', [Home::class, 'exibir']);
    Router::post('/dama-em-php/montar', [Tabuleiro::class, 'montar']);
});

Router::middleware(RedirectSeNaoEmExecucao::class, function () {
    Router::get('/dama-em-php', [Tabuleiro::class, 'exibir']);
    Router::get('/home/reiniciar', [Home::class, 'reiniciar']);
    Router::get('/dama-em-php/montar', [Tabuleiro::class, 'exibir']);
    Router::get('/dama-em-php/mover', [Tabuleiro::class, 'exibir']);
    Router::post('/dama-em-php/mover', [Tabuleiro::class, 'mover']);
});
