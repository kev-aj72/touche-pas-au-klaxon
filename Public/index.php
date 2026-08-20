<?php

declare(strict_types=1);

use Buki\Router\Router;
use Dotenv\Dotenv;

$root = dirname(__DIR__);

require_once $root . '/vendor/autoload.php';

Dotenv::createImmutable($root)->load();

session_start();

$router = new Router([
    'base_folder' => $_ENV['APP_BASE_PATH'],
    'debug' => true,

    'paths' => [
        'controllers' => $root . '/App/Controller',
    ],

    'namespaces' => [
        'controllers' => 'App\Controller',
    ],
]);

require_once $root . '/Router/routeur.php';

$router->run();