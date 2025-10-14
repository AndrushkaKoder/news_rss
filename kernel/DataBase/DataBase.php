<?php

declare(strict_types=1);

namespace App\Kernel\DataBase;

use PDO;

final class DataBase extends AbstractDataBase implements DataBaseInterface
{
    private function __construct()
    {
        $this->connect();
    }

    private function __clone()
    {
    }

    public static function query(): self
    {
        if (!self::$instance) {
            return new self();
        }

        return self::$instance;
    }

    public function insert(array $data): int|false
    {
        $fields = array_keys($data);
        $columns = implode(', ', $fields);

        if (!$columns) return false;

        $bind = implode(', ', array_map(fn($item) => ":$item", array_values($fields)));

        $query = "INSERT INTO {$this->table} ($columns) VALUES ($bind)";

        $sql = $this->connect->prepare($query);

        $sql->execute($data);

        return intval($this->connect->lastInsertId());
    }

    public function insertMultiple(array $data): void
    {
        if (empty($data)) {
            return;
        }

        $fields = array_keys($data[0]);
        $fieldsStr = implode(', ', $fields);

        $placeholders = [];
        $values = [];

        foreach ($data as $index => $item) {
            $placeholders[] = '(' . implode(', ', array_fill(0, count($fields), '?')) . ')';
            $values = array_merge($values, array_values($item));
        }

        $placeholdersStr = implode(', ', $placeholders);

        $query = "INSERT INTO {$this->table} ({$fieldsStr}) VALUES {$placeholdersStr}";

        $sql = $this->connect->prepare($query);
        $sql->execute($values);
    }

    public function getAll(array $filters = []): ?array
    {
        $where = '';

        if (count($filters)) {
            $where = "WHERE " . implode(' AND ', array_map(function ($item) {
                    return "$item = :$item";
                }, array_keys($filters)));
        }


        $query = "SELECT * FROM {$this->table} WHERE {$where}";

        $statement = $this->connect->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    public function findOne(int $id): ?array
    {
        $query = "SELECT * FROM {$this->table} WHERE `id` = :id LIMIT = 1";

        $statement = $this->connect->prepare($query);
        $statement->execute(['id' => $id]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sql(string $sqlRaw): void
    {
        $statement = $this->connect->prepare($sqlRaw);
        $statement->execute();
    }

}