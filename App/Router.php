<?php

namespace App;

use App\Controllers\AuthenticationController;

class Router
{
    protected array $routes = [];

    public function get($path, $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post($path, $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(): void
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        $uri = rawurldecode($uri);

        if (!isset($this->routes[$httpMethod][$uri])) {
            echo '404 Page Not Found';
            return;
        }

        $handler = $this->routes[$httpMethod][$uri];
        $role = 'all';
        [$controller, $method, $role] = $handler;

        $container = require __DIR__ . '/DIContainerConfig.php';
        $authenticationController = $container->get(AuthenticationController::class);

        if ($role !== 'all' && (!$authenticationController->userHasRole('admin') && !$authenticationController->userHasRole($role))) {
            echo '404 Page Not Found';
            return;
        }

        $controllerInstance = $container->get($controller);
        call_user_func_array([$controllerInstance, $method], []);
    }
}
