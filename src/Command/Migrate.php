<?php

declare(strict_types=1);

namespace App\Command;

use App\Kernel\Command\AbstractCommand;
use App\Kernel\Command\CommandInterface;
use App\Kernel\DataBase\DataBase;

class Migrate extends AbstractCommand implements CommandInterface
{
    public function execute(): void
    {
        $this->makeMigrations();
    }

    private function makeMigrations(): void
    {
        DataBase::query()->sql("
            CREATE TABLE categories (
                id SERIAL PRIMARY KEY NOT NULL,
                title VARCHAR(255) NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            )
        ");

        DataBase::query()->sql("
            CREATE TABLE news (
                id SERIAL PRIMARY KEY NOT NULL, 
                category_id INTEGER NOT NULL,
                title VARCHAR(255) NOT NULL,
                link VARCHAR(255) NOT NULL,
                image VARCHAR(255) NULL,
                date DATE NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            )
        ");

        DataBase::query()->sql("
            CREATE INDEX idx_news_date ON news (date)
        ");

        DataBase::query()->sql("
            ALTER TABLE news 
            ADD CONSTRAINT fk_news_categories 
            FOREIGN KEY (category_id) 
            REFERENCES categories (id)
            ON DELETE CASCADE 
            NOT DEFERRABLE INITIALLY IMMEDIATE
        ");
    }
}