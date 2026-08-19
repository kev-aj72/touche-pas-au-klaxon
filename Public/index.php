<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Buki\Router\Router;
use Dotenv\Dotenv;

// Chargement du fichier .env situé à la racine
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

session_start();

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