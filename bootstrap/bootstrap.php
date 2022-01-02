<?php

/**
 *
 * @author Rafael Arend
 *
 **/

require_once __DIR__ . '/../core/config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Library\{Session, Request, Router};

new Session();
$router = new Router(new Request());

require_once __DIR__ . '/../routes/routes.php';

try {
    $router->dispatch();
} catch (Exception $e) {
    http_response_code(404);
    echo 'NOT FOUND';
}
