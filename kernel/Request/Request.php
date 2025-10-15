<?php

declare(strict_types=1);

namespace App\Kernel\Request;

readonly class Request implements RequestInterface
{
    public function __construct(private array $GET, private array $POST)
    {

    }

    public static function create(): static
    {
        return new self($_GET, $_POST);
    }

    public function get(?string $key = null): array|string|null
    {
        return !$key ? $this->GET : ($this->GET[$key] ?? null);
    }

    public function post(): array
    {
        return $this->POST;
    }
}