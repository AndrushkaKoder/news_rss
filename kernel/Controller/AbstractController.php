<?php

declare(strict_types=1);

namespace App\Kernel\Controller;

use App\Kernel\Request\RequestInterface;

abstract class AbstractController
{
    private RequestInterface $request;

    public function setRequest(RequestInterface $request): void
    {
        $this->request = $request;
    }

    public function request(): RequestInterface
    {
        return $this->request;
    }
}