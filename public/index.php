<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Router;

$router = new Router();
//$router->get('/', ['home', 'index']);
$router->get('/users', ['App\Controllers\UserController', 'listUsers']);

//$path = $_SERVER['PATH_INFO'] ?? '/';
// Dispatch the request
$router->dispatch();

