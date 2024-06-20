<!DOCTYPE html>
<html lang="eng">
<head>
    <title>DreamCarPK</title>
    <?php include_once __DIR__ . '/loadScirptAndStyle.php'; ?>
</head>
<body>
<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Controllers\AuthenticationController;

$container = require_once __DIR__ . '/../App/DIContainerConfig.php';
$AuthenticationController = $container->get(AuthenticationController::class);

include_once __DIR__ . '/header.php';
include_once __DIR__ . '/signUpForm.php';
include_once __DIR__ . '/loginForm.php';
?>

<div class="page-wrapper">
    <main>
        <?php

        use App\Router;

        $router = new Router();
        $router->get('/', ['App\Controllers\HomeController', 'showHomepage']);
        $router->get('/home', ['App\Controllers\HomeController', 'showHomepage']);
        $router->get('/admin=user_manager', ['App\Controllers\AdminController', 'showUserManager']);
        $router->get('/admin=car_manager', ['App\Controllers\AdminController', 'showCarManager']);
        $router->get('/admin=reservation_manager', ['App\Controllers\AdminController', 'showReservationManager']);
        $router->post('/car_page', ['App\Controllers\CarController', 'showCarPage']);

        $router->dispatch();
        ?>
    </main>

    <?php include_once __DIR__ . '/footer.php'; ?>
</div>
</body>
</html>
