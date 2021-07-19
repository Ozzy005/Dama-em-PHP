<?php

/**
 *
 * @author Rafael Arend
 *
 **/

require_once '../App/AutoLoader.php';

$AutoLoader = new AutoLoader;
$AutoLoader->addDirectory('../App/Controllers');
$AutoLoader->addDirectory('../App/Models');
$AutoLoader->addDirectory('../App/Views');
$AutoLoader->addDirectory('../App/Data');
$AutoLoader->register();

$method = $_POST['method'] ?? false;

$controller = new Game();

if(!empty($_SESSION) xor $method === 'mountBoard')
{
    if(empty($_SESSION))
    {
        Session::setVars();
    }

    if($method !== 'reset')
    {
        $controller->setData();
    }
}

if($method)
{
    $controller->$method();
}

$controller->show();






?>