<?php

declare(strict_types=1);

namespace App\Services\Cache;

interface CacheService
{
    public function write(mixed $data): bool;

    public function getIfExists(): mixed;
}