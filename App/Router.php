<?php

namespace App;

class Router
{
    protected array $routes = [];

    public function get($path, $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function dispatch(): void
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        if (isset($this->routes[$httpMethod][$uri])) {
            $handler = $this->routes[$httpMethod][$uri];
            [$controller, $method] = $handler;

            // Get the container from bootstrap
            $container = require __DIR__ . '/DIContainerConfig.php';
            $controllerInstance = $container->get($controller);

            call_user_func_array([$controllerInstance, $method], []);
        } else {
            http_response_code(404);
            echo '404 Not Found';
        }
    }
}
