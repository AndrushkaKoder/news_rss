<?php

declare(strict_types=1);

namespace App\Command;

use App\DTO\CreateNews;
use App\Kernel\Command\AbstractCommand;
use App\Kernel\Command\CommandInterface;
use App\Kernel\DataBase\DataBase;
use Symfony\Component\DomCrawler\Crawler;
use Exception;

class Parse extends AbstractCommand implements CommandInterface
{
    public function execute(): void
    {
        $news = $this->parseNews();

        if (!$news) {
            throw new Exception('Парсинг новостей не прошел');
        }

        $this->saveNews($news);

    }

    private function getCrawler(): Crawler
    {
        $file = file_get_contents($_ENV['PARSE_URL']);

        return new Crawler($file);
    }

    private function parseNews(): array
    {
        $crawler = $this->getCrawler();

        return $crawler->filter('item')->each(function (Crawler $node) {
            return [
                'title' => $node->filter('title')->text(),
                'link' => $node->filter('link')->text(),
                'date' => $node->filter('pubDate')->text(),
                'category' => $node->filter('category')->text(),
                'image' => $node->filter('enclosure')->count() > 0
                    ? $node->filter('enclosure')->attr('url')
                    : null
            ];
        });
    }

    private function saveNews(array $news): void
    {
        $existsCategories = [];
        $preparedNews = [];

        foreach ($news as $item) {
            $category = $item['category'] ?? null;

            if (!array_key_exists($category, $existsCategories)) {
                $categoryId = DataBase::query()
                    ->table('categories')
                    ->insert(['title' => $category]);

                $existsCategories[$category] = $categoryId;
            }

            $dto = new CreateNews($existsCategories[$category], $item['title'], $item['link'], $item['image'], $item['date']);
            $preparedNews[] = $dto->forInsert();
        }

        DataBase::query()
            ->table('news')
            ->insertMultiple($preparedNews);
    }
}