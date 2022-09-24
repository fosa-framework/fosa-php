<?php

require __DIR__ . '/autoload.php';

use Fosa\Application\Router;
use Fosa\Controllers\AppController;
use Fosa\Controllers\ExampleController;
use Fosa\Controllers\AuthController;
use Fosa\Controllers\AdminController;
use Fosa\Middlewares\TokenMiddleware;
use Fosa\Middlewares\AuthBasicMiddleware;

$router = new Router();

/* API routes */
$router->route('/api/say-hello', 'GET', ExampleController::class);
$router->route('/api/auth/authenticate', 'POST', AuthController::class, 'login');


/* WEB routes */
$router->route('/', 'GET', AppController::class);

$router->run();

/* Exit scripts */
exit(0);