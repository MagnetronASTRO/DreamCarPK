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
use App\Router;

$container = require_once __DIR__ . '/../App/DIContainerConfig.php';
$AuthenticationController = $container->get(AuthenticationController::class);

include_once __DIR__ . '/header.php';
include_once __DIR__ . '/signUpForm.php';
include_once __DIR__ . '/loginForm.php';
?>

<div class="page-wrapper">
    <main>
        <?php

        $router = new Router();

        // homepage
        $router->get('/', ['App\Controllers\HomeController', 'showHomepage']);
        $router->get('/home', ['App\Controllers\HomeController', 'showHomepage']);

        // car specs and reservation form
        $router->post('/car_page', ['App\Controllers\CarController', 'showCarPage']);

        // admin user panel
        $router->get('/admin=user_manager', ['App\Controllers\AdminController', 'showUserManager']);
        $router->get('/admin=sauf', ['App\Controllers\AdminController', 'showAddUserForm']); // add user form
        $router->post('/admin=sedf', ['App\Controllers\AdminController', 'showEditUserForm']); // edit user form

        // admin car panel
        $router->get('/admin=car_manager', ['App\Controllers\AdminController', 'showCarManager']);
        $router->get('/admin=sacf', ['App\Controllers\AdminController', 'showAddCarForm']); // add car form
        $router->post('/admin=secf', ['App\Controllers\AdminController', 'showEditCarForm']); // edit car form

        // admin reservation panel
        $router->post('/admin=reservation_manager', ['App\Controllers\AdminController', 'showReservationManager']);

        $router->dispatch();
        ?>
    </main>

    <?php include_once __DIR__ . '/footer.php'; ?>
</div>
</body>
</html>
