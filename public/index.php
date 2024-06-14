<!DOCTYPE html>
<html lang="eng">
<head>
    <title>DreamCarPK</title>
    <?php include_once __DIR__ . '/loadScirptAndStyle.php'; ?>
</head>
<body>
<?php
include_once __DIR__ . '/header.php';
include_once __DIR__ . '/loginForm.php';
include_once __DIR__ . '/signUpForm.php';
?>

<div class="page-wrapper">
    <main>
        <?php
        require_once __DIR__ . '/../vendor/autoload.php';

        use App\Router;

        $router = new Router();
        $router->get('/', ['App\Controllers\HomeController', 'showHomepage']);
        $router->get('/home', ['App\Controllers\HomeController', 'showHomepage']);
        $router->post('/login', ['App\Controllers\AuthenticationController', 'login']);
        $router->post('/signup', ['App\Controllers\AuthenticationController', 'signUp']);
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
