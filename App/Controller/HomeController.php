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
        $utilisateurConnecte = $_SESSION['user'] ?? null;
        $trajetsAffiches = [];

        $nomUtilisateur = null;

        if ($utilisateurConnecte !== null) {
            $nomUtilisateur = $this->escape(
                $utilisateurConnecte['prenom']
                    . ' '
                    . $utilisateurConnecte['nom']
            );
        }

        foreach ($trajets as $trajet) {
            $trajetsAffiches[] = [
                'id_trajet' => (int) $trajet['id_trajet'],

                'ville_depart' => $this->escape(
                    $trajet['ville_depart']
                ),

                'ville_arrivee' => $this->escape(
                    $trajet['ville_arrivee']
                ),

                'date_depart' => (
                    new DateTimeImmutable(
                        $trajet['date_heure_depart']
                    )
                )->format('d/m/Y à H:i'),

                'date_arrivee' => (
                    new DateTimeImmutable(
                        $trajet['date_heure_arrivee']
                    )
                )->format('d/m/Y à H:i'),

                'places_disponibles' =>
                    (int) $trajet['nombre_places_disponibles'],

                'places_total' =>
                    (int) $trajet['nombre_places_total'],

                'contact' => $this->escape(
                    $trajet['auteur_prenom']
                        . ' '
                        . $trajet['auteur_nom']
                ),

                'telephone' => $this->escape(
                    $trajet['auteur_telephone']
                ),

                'email' => $this->escape(
                    $trajet['auteur_email']
                ),

                'est_auteur' =>
                    $utilisateurConnecte !== null
                    && (int) $trajet['id_employe']
                        === (int) $utilisateurConnecte['id_employe'],
            ];
        }

        $messageSucces = $_SESSION['success'] ?? null;

        if ($messageSucces !== null) {
            $messageSucces = $this->escape($messageSucces);
        }

        unset($_SESSION['success']);

        ob_start();

        require dirname(__DIR__) . '/Templates/home.php';

        return (string) ob_get_clean();
    }

    private function escape(string $value): string
    {
        return htmlspecialchars(
            $value,
            ENT_QUOTES,
            'UTF-8'
        );
    }
}