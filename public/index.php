<!DOCTYPE html>
<html lang="eng">
<meta name="viewport" content="initial-scale=1" />
<head>
    <title>DreamCarPK</title>
    <?php include_once __DIR__ . '/loadScirptAndStyle.php'; ?>
</head>
<body>
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthenticationController;
use App\Controllers\HomeController;
use App\Router;

$container = require_once __DIR__ . '/../App/DIContainerConfig.php';
$authenticationController = $container->get(AuthenticationController::class);
$homeController = $container->get(HomeController::class);

include_once __DIR__ . '/header.php';
include_once __DIR__ . '/signUpForm.php';
include_once __DIR__ . '/loginForm.php';
?>

<div class="page-wrapper">
    <main>
        <?php

        $router = new Router();

        // homepage
        $router->get('/', ['App\Controllers\HomeController', 'showHomepage', 'all']);
        $router->get('/home', ['App\Controllers\HomeController', 'showHomepage', 'all']);

        // car specs and reservation form
        $router->post('/car_page', ['App\Controllers\CarController', 'showCarPage', 'all']);

        // admin user panel
        $router->get('/admin=user_manager', ['App\Controllers\AdminController', 'showUserManager', 'admin']);
        $router->get('/admin=sauf', ['App\Controllers\AdminController', 'showAddUserForm', 'admin']); // add user form
        $router->post('/admin=sedf', ['App\Controllers\AdminController', 'showEditUserForm', 'admin']); // edit user form

        // admin car panel
        $router->get('/admin=car_manager', ['App\Controllers\AdminController', 'showCarManager', 'admin']);
        $router->get('/admin=sacf', ['App\Controllers\AdminController', 'showAddCarForm', 'admin']); // add car form
        $router->post('/admin=secf', ['App\Controllers\AdminController', 'showEditCarForm', 'admin']); // edit car form

        // admin reservation panel
        $router->post('/admin=reservation_manager', ['App\Controllers\AdminController', 'showReservationManager', 'admin']);

        $router->dispatch();
        ?>
    </main>

    <?php include_once __DIR__ . '/footer.php'; ?>
</div>
</body>
</html>
