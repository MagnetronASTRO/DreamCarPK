<?php

namespace App;

use App\Controllers\AuthenticationController;

class Router
{
    private const string DEFAULT_CONTROLLER = 'App\Controllers\HomeController';
    private const string DEFAULT_METHOD = 'showHomepage';
    protected array $routes = [];

    public function register(string $requestMethod, string $route, callable|array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }

    public function get(string $route, callable|array $action): self
    {
        return $this->register('GET', $route, $action);
    }

    public function post(string $route, callable|array $action): self
    {
        return $this->register('POST', $route, $action);
    }

    public function routes(): array
    {
        return $this->routes;
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
            $controllerInstance = $container->get(self::DEFAULT_CONTROLLER);
            call_user_func_array([$controllerInstance, self::DEFAULT_METHOD], []);
            return;
        }

        $controllerInstance = $container->get($controller);
        call_user_func_array([$controllerInstance, $method], []);
    }
}
