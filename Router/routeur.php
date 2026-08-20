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

$router->get(
    '/admin',
    'App\Controller\AdminController@index'
);

$router->get(
    '/admin/employes',
    'App\Controller\AdminController@employes'
);

$router->get(
    '/admin/agences',
    'App\Controller\AdminController@agences'
);

$router->post(
    '/admin/agences/ajouter',
    'App\Controller\AdminController@storeAgence'
);

$router->get(
    '/admin/agences/:id/modifier',
    'App\Controller\AdminController@editAgence'
);

$router->post(
    '/admin/agences/:id/modifier',
    'App\Controller\AdminController@updateAgence'
);

$router->post(
    '/admin/agences/:id/supprimer',
    'App\Controller\AdminController@deleteAgence'
);

$router->get(
    '/admin/trajets',
    'App\Controller\AdminController@trajets'
);

$router->post(
    '/admin/trajets/:id/supprimer',
    'App\Controller\AdminController@deleteTrajet'
);

$router->notFound(
    function ($request, $response) {
        ob_start();

        require dirname(__DIR__)
            . '/App/Templates/errors404.php';

        $response->setStatusCode(404);
        $response->setContent(
            (string) ob_get_clean()
        );

        return $response;
    }
);

$router->get('/test', function (): string {
    return 'Le routeur fonctionne';
});
?>