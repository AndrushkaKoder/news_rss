<?php

declare(strict_types=1);

namespace App\Kernel\Route;

interface RouteInterface
{
    public static function get(string $uri, mixed $handler): static;


    public static function post(string $uri, mixed $handler): static;


    public function getUri(): string;


    public function getMethod(): string;


    public function getAction(): mixed;
}