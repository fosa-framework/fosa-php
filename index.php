<?php

require __DIR__ . '/autoload.php';

use Fosa\Core\Router;
use Fosa\Controllers\AppController;
// Uncomment the following line to add more controller examples
// use Fosa\Controllers\ExampleController;

$router = new Router();

/* API routes */
$router->route('/api/say-hello', 'GET', AppController::class, 'hello');
// Uncomment the following line to add more API route examples
// $router->route('/api/example/show', 'GET', ExampleController::class, 'show');


/* WEB routes */
$router->route('/', 'GET', AppController::class);
// Uncomment the following line to add more WEB route examples
// $router->route('/example', 'GET', ExampleController::class);

$router->run();

/* Exit scripts */
exit(0);