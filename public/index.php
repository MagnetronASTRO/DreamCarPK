<?php
ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 4);
session_start();
?>

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
//$homeController = $container->get(HomeController::class);

include_once __DIR__ . '/header.php';
include_once __DIR__ . '/signUpForm.php';
include_once __DIR__ . '/loginForm.php';
?>

<div class="page-wrapper">
    <main>
        <?php

        $router = new Router();

        // homepage
        $router->get('/', [App\Controllers\HomeController::class, 'showHomepage', 'all']);
        $router->get('/home', [App\Controllers\HomeController::class, 'showHomepage', 'all']);

        // car specs and reservation form
        $router->post('/car_page', [App\Controllers\CarController::class, 'showCarPage', 'all']);

        // user reservations page
        $router->get('/user_reservations', [App\Controllers\ReservationController::class, 'showUserReservations', 'customer']);

        // admin user panel
        $router->get('/admin=user_manager', [App\Controllers\AdminController::class, 'showUserManager', 'admin']);
        $router->get('/admin=sauf', [App\Controllers\AdminController::class, 'showAddUserForm', 'admin']); // add user form
        $router->post('/admin=sedf', [App\Controllers\AdminController::class, 'showEditUserForm', 'admin']); // edit user form

        // admin car panel
        $router->get('/admin=car_manager', [App\Controllers\AdminController::class, 'showCarManager', 'admin']);
        $router->get('/admin=sacf', [App\Controllers\AdminController::class, 'showAddCarForm', 'admin']); // add car form
        $router->post('/admin=secf', [App\Controllers\AdminController::class, 'showEditCarForm', 'admin']); // edit car form

        // admin reservation panel
        $router->post('/admin=reservation_manager', [App\Controllers\AdminController::class, 'showReservationManager', 'admin']);

        $router->dispatch();
        ?>
    </main>

    <?php include_once __DIR__ . '/footer.php'; ?>
</div>
</body>
</html>
