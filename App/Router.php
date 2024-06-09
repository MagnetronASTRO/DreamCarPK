<?php

namespace App;

class Router
{
    private array $routes = [];
    private DIContainer $diContainer;

    public function __construct(DIContainer $diContainer)
    {
        $this->diContainer = $diContainer;
    }

    public function addRoute(string $method, string $path, string $controller, string $action): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch(string $method, string $path): void
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                $controllerName = 'App\\Controllers\\' . $route['controller'];

                print_r($controllerName);

                if (class_exists($controllerName)) {
                    $controller = $this->diContainer->get($controllerName);
                    $action = $route['action'];

                    if (method_exists($controller, $action)) {
                        $controller->$action();
                        return;
                    }
                }
            }
        }

        http_response_code(404);
        echo '404 Not Found';
    }
}
