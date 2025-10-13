<?php

declare(strict_types=1);

namespace App\Kernel\Route;

readonly class Route implements RouteInterface
{
    public function __construct(
        private string $uri,
        private string $method,
        private mixed  $action
    )
    {
    }

    public static function get(string $uri, mixed $handler): static
    {
        return new self($uri, 'GET', $handler);
    }

    public static function post(string $uri, mixed $handler): static
    {
        return new self($uri, 'POST', $handler);
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getAction(): mixed
    {
        return $this->action;
    }
}