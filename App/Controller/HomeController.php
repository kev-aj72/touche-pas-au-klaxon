<?php

declare(strict_types=1);

namespace App\Controller;

use DateTimeImmutable;

require_once __DIR__ . '/../Model/postModel.php';

class HomeController
{
    public function index(): string
    {
        $trajets = \getTrajets();
        $trajetsAffiches = [];

        foreach ($trajets as $trajet) {
            $trajetsAffiches[] = [
                'ville_depart' => htmlspecialchars(
                    $trajet['ville_depart'],
                    ENT_QUOTES,
                    'UTF-8'
                ),

                'ville_arrivee' => htmlspecialchars(
                    $trajet['ville_arrivee'],
                    ENT_QUOTES,
                    'UTF-8'
                ),

                'date_depart' => (
                    new DateTimeImmutable($trajet['date_heure_depart'])
                )->format('d/m/Y à H:i'),

                'date_arrivee' => (
                    new DateTimeImmutable($trajet['date_heure_arrivee'])
                )->format('d/m/Y à H:i'),

                'places_disponibles' =>
                    (int) $trajet['nombre_places_disponibles'],
            ];
        }

        ob_start();

        require dirname(__DIR__) . '/Templates/home.php';

        return (string) ob_get_clean();
    }
}