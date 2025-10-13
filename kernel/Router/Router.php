<?php

declare(strict_types=1);

namespace App\Kernel\Router;

use App\Kernel\Request\Request;
use App\Kernel\Response\Response;
use App\Kernel\Route\Route;
use JetBrains\PhpStorm\NoReturn;

class Router implements RouterInterface
{
    private array $routes = [];
    private Request $request;

    public function __construct()
    {
        $this->initRoutes();

        $this->request = Request::create();
    }

    public function dispatch(string $method, string $uri): void
    {
        $currentRoute = $this->findRoute($this->clearUri($uri), $method);

        if (!$currentRoute) {
            $this->notFoundRoute($uri);
        }

        $action = $currentRoute->getAction();

        if (is_callable($action)) {
            call_user_func($action);
        } else {
            $this->handleRoute($action);
        }
    }

    private function handleRoute(array $routeHandler): void
    {
        if (count($routeHandler) !== 2) {
            throw new \Exception('Неверное определение сигнатуры маршрута');
        }

        [$controller, $action] = $routeHandler;

        if (!class_exists($controller)) {
            throw new \Exception('Контроллер не найден');
        }

        $controller = new $controller;

        call_user_func([$controller, 'setRequest'], $this->request);

        $response = call_user_func([$controller, $action]);

        if ($response instanceof Response) {
            $response->handleView();
        }
    }

    private function findRoute(string $uri, string $method): ?Route
    {
        return $this->routes[$method][$uri] ?? null;
    }

    private function initRoutes(): void
    {
        foreach ($this->getRoutes() as $route) {
            /*** @var Route $route */
            $this->routes[$route->getMethod()][$route->getUri()] = $route;
        }
    }

    private function getRoutes(): array
    {
        if (!is_file(ROUTES)) {
            throw new \Exception('Маршруты не определены', 500);
        }

        return require_once ROUTES;
    }

    #[NoReturn]
    private function notFoundRoute(string $foundUri): void
    {
        $pageNotFound = RESOURCES . '/404.php';

        if (is_file($pageNotFound)) {
            extract(['page' => $foundUri]);
            include_once $pageNotFound;
        } else {
            echo 'Даже страница 404 не найдена. Все грустно';
        }

        exit();
    }

    private function clearUri(string $uri): string
    {
        return preg_replace('/[?]+.+/', '', $uri);
    }
}