<?php

declare(strict_types=1);

namespace App\Command;

use App\Kernel\Command\AbstractCommand;
use App\Kernel\Command\CommandInterface;

class Parse extends AbstractCommand implements CommandInterface
{

    public function execute(): void
    {
        echo 'parsing..';
    }
}