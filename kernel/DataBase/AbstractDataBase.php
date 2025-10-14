<?php

declare(strict_types=1);

namespace App\Kernel\DataBase;

use Exception;
use PDO;
use PDOException;
use RuntimeException;

abstract class AbstractDataBase
{
    protected static DataBase|null $instance = null;
    protected PDO $connect;
    protected bool $isConnected = false;

    protected string $table;

    protected function connect(): void
    {
        if ($this->isConnected) {
            return;
        }

        try {
            $host = $_ENV['DB_HOST'];
            $port = $_ENV['DB_PORT'];
            $database = $_ENV['DB_NAME'];
            $username = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASSWORD'];

            $dsn = "pgsql:host={$host};port={$port};dbname={$database}";

            $this->connect = new PDO($dsn, $username, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            $this->isConnected = true;

        } catch (PDOException|Exception $e) {
            throw new RuntimeException("Ошибка подключения к БД " . $e->getMessage());
        }
    }

    public function table(string $table): self
    {
        $this->table = $table;

        return $this;
    }
}