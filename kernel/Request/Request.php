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

    public function get(): array
    {
        return $this->GET;
    }

    public function post(): array
    {
        return $this->POST;
    }
}