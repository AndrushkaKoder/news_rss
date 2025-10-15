<?php

declare(strict_types=1);

namespace App\Kernel\Request;

interface RequestInterface
{
    public static function create(): static;

    public function get(?string $key = null): array|string|null;
}