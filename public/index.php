<!DOCTYPE html>
<html lang="eng">
    <head>
        <title>DreamCarPK</title>
        <?php include_once __DIR__ . '/loadScirptAndStyle.php'; ?>
    </head>
    <body>
    <?php
        include_once __DIR__ . '/header.php';
        require_once __DIR__ . '/../vendor/autoload.php';

        use App\Router;

        $router = new Router();
        $router->get('/', ['App\Controllers\HomeController', 'showHomepage']);
        $router->get('/home', ['App\Controllers\HomeController', 'showHomepage']);
        $router->get('/login', ['App\Controllers\AuthenticationController', 'showLoginRegisterForm']);
        $router->post('/signin', ['App\Controllers\AuthenticationController', 'signin']);
        $router->post('/signup', ['App\Controllers\AuthenticationController', 'signup']);
        $router->get('/admin', ['App\Controllers\AdminController', 'showAdminPage']);

        $router->dispatch();

        include_once __DIR__ . '/footer.php';
    ?>
    </body>
</html>
