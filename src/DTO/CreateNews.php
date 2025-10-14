<?php

declare(strict_types=1);

namespace App\DTO;

final readonly class CreateNews
{
    public function __construct(
        private int     $categoryId,
        private string  $title,
        private ?string $link = null,
        private ?string $image = null,
        private ?string $date = null
    )
    {
    }

    public function forInsert(): array
    {
        return [
            'category_id' => $this->categoryId,
            'title' => $this->title,
            'link' => $this->link,
            'image' => $this->image,
            'date' => $this->date
        ];
    }
}