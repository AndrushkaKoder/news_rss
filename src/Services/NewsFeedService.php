<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\NewsFilter;
use App\Repository\NewsRepository;
use App\Services\Cache\MemcacheService;

final readonly class NewsFeedService
{
    private NewsRepository $newsRepository;
    private MemcacheService $cacheService;

    public function __construct()
    {
        $this->newsRepository = new NewsRepository();
        $this->cacheService = new MemcacheService('news');
    }

    public function getNews(NewsFilter $filter): array
    {
        if ($filter->hasFilters()) {
            return $this->newsRepository->getAllWithFilters($filter) ?? [];
        }

        if ($cachedNews = $this->cacheService->getIfExists()) {
            return $cachedNews;
        }

        $news = $this->newsRepository->getAllWithFilters($filter);

        $this->cacheService->write($news);

        return $news;
    }
}