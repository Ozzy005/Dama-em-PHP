<?php

/**
 *
 * @author Rafael Arend
 *
 **/

require_once '../App/AutoLoader.php';

$al = new AutoLoader;
$al->addDirectory('../App/Controllers');
$al->addDirectory('../App/Data');
$al->addDirectory('../App/Data/Others');
$al->addDirectory('../App/Core');
$al->addDirectory('../App/Models');
$al->addDirectory('../App/Views/Board');
$al->addDirectory('../App/Views/Home');
$al->register();

$method = $_POST['method'] ?? false;

$controller = new Game();

if($method)
{
    $controller->$method();
}

$controller->show();