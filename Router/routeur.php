<?php

declare(strict_types=1);

$router->get('/', function (): string {
    return 'Touche pas au klaxon';
});

$router->get('/test', function (): string {
    return 'Le routeur fonctionne';
});

?>