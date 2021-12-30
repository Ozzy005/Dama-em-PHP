<?php

/**
 *
 * @author Rafael Arend
 *
**/

use App\Controllers\{Tabuleiro, Home};

$router->addRoute('GET', '/', Home::class, 'exibir');
$router->addRoute('GET', '/home', Home::class, 'exibir');
$router->addRoute('GET', '/dama-em-php', Tabuleiro::class, 'exibir');
$router->addRoute('GET', '/dama-em-php/reiniciar', Tabuleiro::class, 'reiniciar');
$router->addRoute('POST', '/dama-em-php/montar', Tabuleiro::class, 'montar');
$router->addRoute('POST', '/dama-em-php/mover', Tabuleiro::class, 'mover');