<?php

declare(strict_types=1);

use App\Kernel\Application;

require_once '../vendor/autoload.php';

define("APP_PATH", dirname($_SERVER['DOCUMENT_ROOT']));

const CONFIG = APP_PATH . '/config';
const ROUTES = CONFIG . '/routes.php';
const RESOURCES = APP_PATH . '/resources';

new Application()->run(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);

