<?php

declare(strict_types=1);

namespace App\Kernel\CliRunner;

use App\Kernel\Command\CommandInterface;
use App\Kernel\Exception\CliException;

final readonly class CliRunner
{
    public function run(array $argv): void
    {
        $argument = $argv[1] ?? null;

        if (!$argument) {
            throw new CliException("Не передан аргумент команды \n");
        }

        $command = $this->getCommand($argument);

        if (!$command) {
            throw new CliException("Команда не найдена \n");
        }

        if (!method_exists($command, 'execute')) {
            throw new CliException("Команда нарушает правила наследования \n");
        }

        $command->execute();
        echo PHP_EOL;

        exit();
    }

    private function getCommand(string $param): ?CommandInterface
    {
        $commands = dirname($_SERVER['DOCUMENT_ROOT']) . 'config/console.php';

        if (!file_exists($commands)) {
            throw new CliException("Файл регистрации команд не найден \n");
        }

        foreach (require_once $commands as $commandName => $commandClass) {
            if ($param === $commandName) {
                return new $commandClass;
            }
        }

        return null;
    }

}