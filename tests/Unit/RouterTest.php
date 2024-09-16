<?php

namespace Tests\Unit;

use App\Router;
use PHPUnit\Framework\TestCase;
class RouterTest extends TestCase
{
    private Router $router;

    protected function setUp(): void
    {
        parent::setUp();

        $this->router = new Router();
    }

    public function testIfItRegisterRoute(): void
    {
        $this->router->register('get', '/users', ['Users', 'index']);

        $expected = [
            'get' => [
                '/users' => ['Users', 'index'],
            ],
        ];

        $this->assertSame($expected, $this->router->routes());
    }

    public function testIfItRegisterGetRoute(): void
    {
        $this->router->get('/users', ['Users', 'index']);

        $expected = [
            'GET' => [
                '/users' => ['Users', 'index'],
            ],
        ];

        $this->assertSame($expected, $this->router->routes());
    }

    public function testIfItRegisterPostRoute(): void
    {
        $this->router->post('/users', ['Users', 'store']);

        $expected = [
            'POST' => [
                '/users' => ['Users', 'store'],
            ],
        ];

        $this->assertSame($expected, $this->router->routes());
    }

    public function testIfThereAreNoRoutesWhenRouterIsCreated(): void
    {
        $this->assertEmpty((new Router())->routes());
    }
    public function testDispatchRouteNotFound(): void
    {
        // Capture the output
        $this->expectOutputString('404 Page Not Found');

        // Simulate an unknown route
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/unknown-route';

        // Dispatch with an unregistered route
        $this->router->dispatch();
    }
}
