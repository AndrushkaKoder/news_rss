<?php

declare(strict_types=1);

namespace App\Kernel\Response;

class Response
{
    private string $includeFile {
        set(string $value) => $this->normalizeFilePath($value);
    }

    private array $params;

    public function __construct(string $filePath, ?array $params = null)
    {
        $this->includeFile = $filePath;
        $this->params = $params ?? [];

        $this->handleView();
    }

    public function handleView(): void
    {
        if (!file_exists($this->includeFile)) {
            throw new \Exception('Файл представления не найден');
        }

        extract($this->params);
        include_once $this->includeFile;

    }

    private function normalizeFilePath(string $path): string
    {
        return RESOURCES . '/' . preg_replace('/[.]+/', '/', $path) . '.php';
    }

}