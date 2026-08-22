<?php

declare(strict_types=1);

use App\Controller\AdminController;
use App\Controller\HomeController;
use App\Controller\TrajetController;
use App\Controller\UserController;

$homeController = HomeController::class;
$userController = UserController::class;
$trajetController = TrajetController::class;
$adminController = AdminController::class;

$router->get(
    '/',
    $homeController . '@index'
);

$router->get(
    '/login',
    $userController . '@login'
);

$router->post(
    '/login',
    $userController . '@authenticate'
);

$router->post(
    '/logout',
    $userController . '@logout'
);

$router->group(
    '/trajets',
    function ($router) use ($trajetController): void {
        $router->get(
            '/ajouter',
            $trajetController . '@create'
        );

        $router->post(
            '/ajouter',
            $trajetController . '@store'
        );

        $router->get(
            '/:id/modifier',
            $trajetController . '@edit'
        );

        $router->post(
            '/:id/modifier',
            $trajetController . '@update'
        );

        $router->post(
            '/:id/supprimer',
            $trajetController . '@delete'
        );
    }
);

$router->group(
    '/admin',
    function ($router) use ($adminController): void {
        $router->get(
            '/',
            $adminController . '@index'
        );

        $router->get(
            '/employes',
            $adminController . '@employes'
        );

        $router->group(
            '/agences',
            function ($router) use ($adminController): void {
                $router->get(
                    '/',
                    $adminController . '@agences'
                );

                $router->post(
                    '/ajouter',
                    $adminController . '@storeAgence'
                );

                $router->get(
                    '/:id/modifier',
                    $adminController . '@editAgence'
                );

                $router->post(
                    '/:id/modifier',
                    $adminController . '@updateAgence'
                );

                $router->post(
                    '/:id/supprimer',
                    $adminController . '@deleteAgence'
                );
            }
        );

        $router->get(
            '/trajets',
            $adminController . '@trajets'
        );

        $router->post(
            '/trajets/:id/supprimer',
            $adminController . '@deleteTrajet'
        );
    }
);

$router->notFound(
    function ($request, $response) {
        $controller =
            new \App\Controller\ErrorController();

        $response->setStatusCode(404);

        $response->setContent(
            $controller->index()
        );

        return $response;
    }
);