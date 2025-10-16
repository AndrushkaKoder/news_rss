<?php

declare(strict_types=1);

namespace App\Services\Cache;

use Memcached;

final class MemcacheService implements CacheService
{
    private Memcached $memcache;

    private const int EXPIRED_TIME = 3600 * 24;

    public function __construct(private readonly string $key)
    {
        $this->memcache = new Memcached();

        $this->memcache->addServer(
            $_ENV['MEMCACHED_HOST'],
            (int)$_ENV['MEMCACHED_PORT']
        );
    }

    public function write(mixed $data): bool
    {
        return $this->memcache->set($this->key, $data, self::EXPIRED_TIME);
    }


    public function getIfExists(): mixed
    {
        return $this->memcache->get($this->key) ?? null;
    }
}