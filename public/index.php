<?php

/**
 *
 * @author Rafael Arend
 *
 **/

require_once '../config/config.php';
require_once '../vendor/autoload.php';

use App\Core\{Session, Request};

new Session;

if(Session::empty('data')){
    $class = Request::post('class') ?? 'App\Controllers\Home';
}
else{
    $class = Request::post('class') ?? 'App\Controllers\Board';
}

$method = Request::post('method');

$controller = new $class;

if($method){
    $controller->$method();
}

$controller->show();