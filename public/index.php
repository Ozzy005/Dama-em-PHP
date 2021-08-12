<?php

/**
 *
 * @author Rafael Arend
 *
 **/

require_once '../vendor/autoload.php';

use Core\{Session, Post};

new Session;

if(Session::empty())
{
    $class = Post::getValue('class') ?? 'App\Controllers\Home';
}
elseif(!Session::empty())
{
    $class = Post::getValue('class') ?? 'App\Controllers\Board';
}

$method = Post::getValue('method');

$controller = new $class;

if($method)
{
    $controller->$method();
}

$controller->show();