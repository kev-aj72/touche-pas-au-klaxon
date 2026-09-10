<?php

declare(strict_types=1);

namespace Core\Traits;

use DateTimeImmutable;

/**
 * Prépare les données des trajets
 * avant leur affichage.
 */
trait TrajetFormatterTrait {

    /**
     * Prépare un trajet pour son affichage.
     *
     * @param array $trajet Données du trajet.
     * @param string $auteurKey Nom de la clé
     * contenant l’auteur.
     *
     * @return array Trajet préparé.
     */
    protected function formatTrajet(array $trajet,string $auteurKey = 'auteur'): array {
        return ['id_trajet' => (int) $trajet['id_trajet'],
                'ville_depart' => (string) $trajet['ville_depart'],
                'ville_arrivee' => (string) $trajet['ville_arrivee'],
                'date_depart' => $this->formatDate($trajet['date_heure_depart']),
                'date_arrivee' => $this->formatDate($trajet['date_heure_arrivee']),
                'places_total' => (int) $trajet['nombre_places_total'],
                'places_disponibles' => (int) $trajet['nombre_places_disponibles'],
                $auteurKey => (string) $trajet['auteur_prenom']. ' '. (string) $trajet['auteur_nom'],];
    }

    /**
     * Transforme une date SQL
     * au format français.
     *
     * @param string $date Date provenant de MySQL.
     * @return string Date formatée.
     */
    private function formatDate(string $date): string {
        return (new DateTimeImmutable($date))->format('d/m/Y à H:i');
    }
}
?>