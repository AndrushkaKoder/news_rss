<?php

declare(strict_types=1);

namespace App\DTO;

final readonly class NewsFilter
{
    public function __construct(
        private ?string $categoryId = null,
        private ?string $date = null
    )
    {
    }

    public function getCategoryId(): ?string
    {
        return $this->categoryId;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function toArray(): array
    {
        $arr = [];

        if ($this->getCategoryId()) {
            $arr['categoryId'] = $this->categoryId;
        }

        if ($this->getDate()) {
            $arr['date'] = $this->getDate();
        }

        return $arr;
    }
}