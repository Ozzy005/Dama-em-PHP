<?php

/**
 *
 * @author Rafael Arend
 *
 **/

require_once '../Core/config.php';
require_once '../vendor/autoload.php';

use Library\{Session, Post};

new Session;

if (Session::notHas('dados')) {
    $classe = Post::get('classe') ?? 'App\Controllers\Home';
}
if (Session::has('dados')) {
    $classe = Post::get('classe') ?? 'App\Controllers\Tabuleiro';
}

$metodo = Post::get('metodo');

$controlador = new $classe;

if ($metodo) {
    $controlador->$metodo();
}

$controlador->exibir();
