<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\NewsFilter;
use App\Repository\NewsRepository;

final readonly class NewsFeedService
{
    private NewsRepository $newsRepository;

    public function __construct()
    {
        $this->newsRepository = new NewsRepository();
    }

    public function getNews(NewsFilter $filter): array
    {
        return $this->newsRepository->getAllWithFilters($filter) ?? [];
    }
}