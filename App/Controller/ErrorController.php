<?php

declare(strict_types=1);

namespace App\Controller;

use Core\DefaultController;

/**
 * Gère l’affichage des pages d’erreur.
 */
class ErrorController extends DefaultController {
    /**
     * Affiche la page correspondant à une erreur 404.
     *
     * @return string Contenu HTML de la page 404.
     */
    public function index(): string {
        return $this->render('errors404');
    }
}