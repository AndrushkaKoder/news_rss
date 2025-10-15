<?php

declare(strict_types=1);

namespace App\Kernel\DataBase;

interface DataBaseInterface
{
    public static function query(): self;

    public function insert(array $data): int|false;

    public function getAll(array $filters = []): ?array;

    public function findOne(int $id): ?array;
}