<?php

declare(strict_types=1);

namespace App\Controller;

use App\Kernel\Controller\AbstractController;
use App\Kernel\Response\Response;

class IndexController extends AbstractController
{
    public function index(): Response
    {
        return new Response('pages.index.index');
    }
}