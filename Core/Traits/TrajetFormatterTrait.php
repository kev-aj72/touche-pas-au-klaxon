<?php

declare(strict_types=1);

namespace Core\Traits;

use DateTimeImmutable;

trait TrajetFormatterTrait
{
    abstract protected function escape(
        string $value
    ): string;

    /**
     * Formate un trajet pour son affichage.
     */
    protected function formatTrajet(
        array $trajet,
        string $auteurKey = 'auteur'
    ): array {
        return [
            'id_trajet' =>
                (int) $trajet['id_trajet'],

            'ville_depart' =>
                $this->escape($trajet['ville_depart']),

            'ville_arrivee' =>
                $this->escape($trajet['ville_arrivee']),

            'date_depart' =>
                $this->formatDate(
                    $trajet['date_heure_depart']
                ),

            'date_arrivee' =>
                $this->formatDate(
                    $trajet['date_heure_arrivee']
                ),

            'places_total' =>
                (int) $trajet['nombre_places_total'],

            'places_disponibles' =>
                (int) $trajet[
                    'nombre_places_disponibles'
                ],

            $auteurKey => $this->escape(
                $trajet['auteur_prenom']
                    . ' '
                    . $trajet['auteur_nom']
            ),
        ];
    }

    /**
     * Formate plusieurs trajets.
     */
    protected function formatTrajets(
        array $trajets
    ): array {
        $resultat = [];

        foreach ($trajets as $trajet) {
            $resultat[] =
                $this->formatTrajet($trajet);
        }

        return $resultat;
    }

    private function formatDate(
        string $date
    ): string {
        return (
            new DateTimeImmutable($date)
        )->format('d/m/Y à H:i');
    }
}