<?php

namespace App;
class Router
{
    protected array $routes = [];

    public function addRoute(string $route, $controller, $action): void
    {
        $this->routes[$route] = ['controller' => $controller, 'action' => $action];
    }

    public function dispatch($uri): void
    {
        if(isset($this->routes[$uri])) {
            $controller = $this->routes[$uri]['controller'];
            $action = $this->routes[$uri]['action'];

            $controller = new $controller();
            $controller->$action();
        }
    }
}