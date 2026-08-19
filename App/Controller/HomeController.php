<?php

declare(strict_types=1);

namespace App\Controller;

require_once __DIR__ . '/../Model/postModel.php';

class HomeController
{
    public function index(): string
    {
        // Données des trajets
        $trajets = \getTrajets();

        // Utilisateur connecté ou null
        $utilisateurConnecte =
            $_SESSION['user'] ?? null;

        // Chargement du template
        ob_start();

        require dirname(__DIR__) . '/Templates/home.php';

        return (string) ob_get_clean();
    }
}