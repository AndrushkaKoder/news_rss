<?php

declare(strict_types=1);

namespace App\Kernel\Command;

abstract class AbstractCommand
{
    abstract public function execute(): void;
}