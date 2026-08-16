<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Buki\Router\Router;

$router = new Router([
    'base_folder' => '/touche-pas-au-klaxon/public',
    'debug' => true,
]);

require_once dirname(__DIR__) . '/Router/routeur.php';

$router->run();
?>