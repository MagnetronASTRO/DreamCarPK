<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../App/dbConnection.php';

use App\Router;

$diContainer = $GLOBALS['container'];

$router = new Router($diContainer);

// Load routes
require_once __DIR__ . '/../App/routes.php';

// Dispatch the current request
$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';

$router->dispatch($method, '/users');

//if ($path === '/') {
//    include 'home.php';
//} else {
//    $router->dispatch($method, $path);
//}