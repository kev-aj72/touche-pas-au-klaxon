<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Buki\Router\Router;

$router = new Router([
    'base_folder' => '/touche-pas-au-klaxon/public',
    'debug' => true,

    'paths' => [
        'controllers' => dirname(__DIR__) . '/App/Controller',
    ],

    'namespaces' => [
        'controllers' => 'App\Controller',
    ],
]);

require_once dirname(__DIR__) . '/Router/routeur.php';

$router->run();
?>