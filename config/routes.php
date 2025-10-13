<?php

declare(strict_types=1);

use App\Controller\IndexController;
use App\Kernel\Route\Route;

return [
    Route::get('/', [IndexController::class, 'index']),
];
