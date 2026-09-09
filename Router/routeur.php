<?php

declare(strict_types=1);

use App\Controller\AdminController;
use App\Controller\HomeController;
use App\Controller\TrajetController;
use App\Controller\UserController;

/**
 * Déclaration des contrôleurs utilisés
 * par les routes de l’application.
 */

$homeController = HomeController::class;
$userController = UserController::class;
$trajetController = TrajetController::class;
$adminController = AdminController::class;

/**
 * Routes publiques.
 */

$router->get('/', $homeController . '@index');
$router->get('/login', $userController . '@login');
$router->post('/login', $userController . '@authenticate');
$router->post('/logout', $userController . '@logout');

/**
 * Routes permettant de gérer les trajets
 * d’un utilisateur connecté.
 */

$router->group('/trajets', function ($router) use ($trajetController): void {
        $router->get('/ajouter', $trajetController . '@create');
        $router->post('/ajouter', $trajetController . '@store');
        $router->get('/:id/modifier', $trajetController . '@edit');
        $router->post('/:id/modifier', $trajetController . '@update');
        $router->post('/:id/supprimer', $trajetController . '@delete');
    }
);

/**
 * Routes réservées aux administrateurs.
 */

$router->group('/admin', function ($router) use ($adminController): void {
        $router->get('/', $adminController . '@index');
        $router->get('/employes', $adminController . '@employes');
        $router->group('/agences', function ($router) use ($adminController): void {
            $router->get('/',$adminController . '@agences');
            $router->post('/ajouter',$adminController . '@storeAgence');
            $router->get('/:id/modifier', $adminController . '@editAgence');
            $router->post('/:id/modifier', $adminController . '@updateAgence');
            $router->post('/:id/supprimer', $adminController . '@deleteAgence');
            }
        );

        $router->get('/trajets', $adminController . '@trajets');
        $router->post('/trajets/:id/supprimer', $adminController . '@deleteTrajet');
    }
);

/**
 * Affiche la page 404 lorsqu’aucune
 * route ne correspond à l’adresse demandée.
 */

$router->notFound(
    function ($request, $response) {
        $controller =new \App\Controller\ErrorController();
        $response->setStatusCode(404);
        $response->setContent($controller->index());
        return $response;
    }
);