<?php

declare(strict_types=1);

namespace App\Repository;

use App\DTO\NewsFilter;
use App\Enums\Tables;
use App\Kernel\DataBase\DataBase;
use App\Kernel\DataBase\DataBaseInterface;

final readonly class NewsRepository
{
    private DataBaseInterface $dataBase;

    public function __construct()
    {
        $this->dataBase = DataBase::query();
    }

    public function getAllWithFilters(NewsFilter $filter): ?array
    {
        $newsTable = Tables::NEWS->value;
        $categoriesTable = Tables::CATEGORIES->value;

        $categoryId = $filter->getCategoryId();
        $date = $filter->getDate();

        $filterParams = [];

        if ($categoryId) {
            $filterParams[] = "{$categoriesTable}.id = :categoryId";
        }

        if ($date) {
            $filterParams[] = "{$newsTable}.date = :date";
        }

        $where = $filterParams ? ('WHERE ' . implode('AND ', $filterParams)) : '';

        $sql = "
            SELECT 
                {$newsTable}.id as id,
                {$newsTable}.title as title,
                {$newsTable}.link as link,
                {$newsTable}.image as image,
                {$newsTable}.date as date,
                {$categoriesTable}.title as category_title
            FROM {$newsTable}
            JOIN {$categoriesTable}
            ON {$newsTable}.category_id = {$categoriesTable}.id
            {$where}
        ";

        return $this->dataBase->sql(
            $sql,
            $filter->toArray()
        )->fetchAll();
    }
}