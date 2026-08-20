<?php

declare(strict_types=1);

namespace App\Model;

use Core\DefaultModel;

class PostModel extends DefaultModel
{
    /**
     * Partie commune aux requêtes qui récupèrent les trajets.
     */
    private const TRAJET_SELECT = <<<'SQL'
        SELECT
            trajets.id_trajet,
            trajets.date_heure_depart,
            trajets.date_heure_arrivee,
            trajets.nombre_places_total,
            trajets.nombre_places_disponibles,
            trajets.id_employe,

            depart.ville AS ville_depart,
            arrivee.ville AS ville_arrivee,

            employes.nom AS auteur_nom,
            employes.prenom AS auteur_prenom,
            employes.telephone AS auteur_telephone,
            employes.email AS auteur_email

        FROM trajets

        INNER JOIN agences AS depart
            ON depart.id_agence =
                trajets.id_agence_depart

        INNER JOIN agences AS arrivee
            ON arrivee.id_agence =
                trajets.id_agence_arrivee

        INNER JOIN employes
            ON employes.id_employe =
                trajets.id_employe
        SQL;

    /**
     * Récupère les trajets futurs avec des places disponibles.
     */
    public function getTrajets(): array
    {
        return $this->findAll(
            self::TRAJET_SELECT . '
            WHERE trajets.nombre_places_disponibles > 0
            AND trajets.date_heure_depart >= NOW()
            ORDER BY trajets.date_heure_depart ASC'
        );
    }

    /**
     * Récupère tous les trajets pour l’administration.
     */
    public function getAllTrajets(): array
    {
        return $this->findAll(
            self::TRAJET_SELECT . '
            ORDER BY trajets.date_heure_depart DESC'
        );
    }

    /**
     * Enregistre un nouveau trajet.
     */
    public function createTrajet(
        int $idEmploye,
        int $idAgenceDepart,
        int $idAgenceArrivee,
        string $dateDepart,
        string $dateArrivee,
        int $nombrePlaces
    ): bool {
        return $this->executeQuery(
            'INSERT INTO trajets (
                date_heure_depart,
                date_heure_arrivee,
                nombre_places_total,
                nombre_places_disponibles,
                id_employe,
                id_agence_depart,
                id_agence_arrivee
            ) VALUES (
                :date_depart,
                :date_arrivee,
                :places_total,
                :places_disponibles,
                :id_employe,
                :agence_depart,
                :agence_arrivee
            )',
            [
                'date_depart' => $dateDepart,
                'date_arrivee' => $dateArrivee,
                'places_total' => $nombrePlaces,
                'places_disponibles' => $nombrePlaces,
                'id_employe' => $idEmploye,
                'agence_depart' => $idAgenceDepart,
                'agence_arrivee' => $idAgenceArrivee,
            ]
        );
    }

    /**
     * Récupère un trajet appartenant à un employé.
     */
    public function getTrajetByIdAndEmploye(
        int $idTrajet,
        int $idEmploye
    ): array|false {
        return $this->findOne(
            'SELECT *
            FROM trajets
            WHERE id_trajet = :id_trajet
            AND id_employe = :id_employe',
            [
                'id_trajet' => $idTrajet,
                'id_employe' => $idEmploye,
            ]
        );
    }

    /**
     * Modifie un trajet appartenant à un employé.
     */
    public function updateTrajet(
        int $idTrajet,
        int $idEmploye,
        int $idAgenceDepart,
        int $idAgenceArrivee,
        string $dateDepart,
        string $dateArrivee,
        int $nombrePlaces
    ): bool {
        return $this->executeQuery(
            'UPDATE trajets
            SET
                id_agence_depart = :agence_depart,
                id_agence_arrivee = :agence_arrivee,
                date_heure_depart = :date_depart,
                date_heure_arrivee = :date_arrivee,
                nombre_places_total = :places_total,
                nombre_places_disponibles =
                    :places_disponibles
            WHERE id_trajet = :id_trajet
            AND id_employe = :id_employe',
            [
                'agence_depart' => $idAgenceDepart,
                'agence_arrivee' => $idAgenceArrivee,
                'date_depart' => $dateDepart,
                'date_arrivee' => $dateArrivee,
                'places_total' => $nombrePlaces,
                'places_disponibles' => $nombrePlaces,
                'id_trajet' => $idTrajet,
                'id_employe' => $idEmploye,
            ]
        );
    }

    /**
     * Supprime un trajet appartenant à un employé.
     */
    public function deleteTrajet(
        int $idTrajet,
        int $idEmploye
    ): bool {
        return $this->executeQuery(
            'DELETE FROM trajets
            WHERE id_trajet = :id_trajet
            AND id_employe = :id_employe',
            [
                'id_trajet' => $idTrajet,
                'id_employe' => $idEmploye,
            ]
        );
    }

    /**
     * Récupère un trajet avec son identifiant.
     */
    public function getTrajetById(
        int $idTrajet
    ): array|false {
        return $this->findOne(
            'SELECT id_trajet
            FROM trajets
            WHERE id_trajet = :id_trajet',
            [
                'id_trajet' => $idTrajet,
            ]
        );
    }

    /**
     * Supprime un trajet sans vérifier son auteur.
     */
    public function deleteTrajetAdmin(
        int $idTrajet
    ): bool {
        return $this->executeQuery(
            'DELETE FROM trajets
            WHERE id_trajet = :id_trajet',
            [
                'id_trajet' => $idTrajet,
            ]
        );
    }
}