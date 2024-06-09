<?php

use App\Router;

$router = new Router($GLOBALS['container']);

$router->addRoute('GET', '/', 'AuthController', 'showLoginForm');
$router->addRoute('POST', '/login', 'AuthController', 'login');
$router->addRoute('GET', '/register', 'AuthController', 'showRegisterForm');
$router->addRoute('POST', '/register', 'AuthController', 'register');
$router->addRoute('GET', '/users', 'UserController', 'listUsers');
