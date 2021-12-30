<?php

/**
 *
 * @author Rafael Arend
 *
**/

require_once __DIR__.'/../Core/Config.php';
require_once __DIR__.'/../vendor/autoload.php';

use Library\{Session, Request, Router};

new Session();
$request = new Request();
$router = new Router($request);

require_once __DIR__.'/../Routes/Routes.php';

$router->parseRoutes();
$router->dispatch();