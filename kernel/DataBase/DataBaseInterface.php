<?php

declare(strict_types=1);

namespace App\Kernel\DataBase;

interface DataBaseInterface
{
    public static function query(): self;
}