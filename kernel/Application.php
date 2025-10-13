<?php

namespace App\Kernel;

use App\Kernel\Router\Router;

class Application
{
    public function run(string $httpMethod, string $uri): void
    {
        $router = new Router();
        $router->dispatch($httpMethod, $uri);
    }
}