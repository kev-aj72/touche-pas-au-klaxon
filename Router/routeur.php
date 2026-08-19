<?php

declare(strict_types=1);

$router->get('/', 'App\Controller\HomeController@index');

// Affiche le formulaire
$router->get(
    '/login',
    'App\Controller\UserController@login'
);

// Traite le formulaire
$router->post(
    '/login',
    'App\Controller\UserController@authenticate'
);

$router->post(
    '/logout',
    'App\Controller\UserController@logout'
);

$router->get('/test', function (): string {
    return 'Le routeur fonctionne';
});
?>