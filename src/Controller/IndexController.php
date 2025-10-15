<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\NewsFilter;
use App\Kernel\Controller\AbstractController;
use App\Kernel\Response\Response;
use App\Service\NewsFeedService;

class IndexController extends AbstractController
{
    public function index(): Response
    {
        $filter = new NewsFilter(
            $this->request()->get('categoryId'),
            $this->request()->get('date')
        );

        $news = new NewsFeedService()->getNews($filter);

        return new Response('pages.index.index', [
            'news' => $news
        ]);
    }
}