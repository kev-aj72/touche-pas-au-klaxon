<?php

declare(strict_types=1);

$router->get('/', 'App\Controller\HomeController@index');
$router->get('/test', function (): string {
    return 'Le routeur fonctionne';
});

?>