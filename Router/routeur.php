<?php

declare(strict_types=1);

$router->get(
    '/',
    'App\Controller\HomeController@index'
);

$router->get(
    '/login',
    'App\Controller\UserController@login'
);

$router->post(
    '/login',
    'App\Controller\UserController@authenticate'
);

$router->post(
    '/logout',
    'App\Controller\UserController@logout'
);

$router->get(
    '/trajets/ajouter',
    'App\Controller\TrajetController@create'
);

$router->post(
    '/trajets/ajouter',
    'App\Controller\TrajetController@store'
);

$router->get(
    '/trajets/:id/modifier',
    'App\Controller\TrajetController@edit'
);

$router->post(
    '/trajets/:id/modifier',
    'App\Controller\TrajetController@update'
);

$router->post(
    '/trajets/:id/supprimer',
    'App\Controller\TrajetController@delete'
);

$router->get('/test', function (): string {
    return 'Le routeur fonctionne';
});
?>