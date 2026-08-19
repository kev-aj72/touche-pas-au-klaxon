<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Core/DefaultModel.php';

/**
 * Récupère les trajets futurs ayant des places disponibles.
 */
function getTrajets(): array
{
    return findAll(
        'SELECT
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
            ON depart.id_agence = trajets.id_agence_depart

        INNER JOIN agences AS arrivee
            ON arrivee.id_agence = trajets.id_agence_arrivee

        INNER JOIN employes
            ON employes.id_employe = trajets.id_employe

        WHERE trajets.nombre_places_disponibles > 0
        AND trajets.date_heure_depart >= NOW()

        ORDER BY trajets.date_heure_depart ASC'
    );
}

/**
 * Enregistre un nouveau trajet.
 */
function createTrajet(
    int $idEmploye,
    int $idAgenceDepart,
    int $idAgenceArrivee,
    string $dateDepart,
    string $dateArrivee,
    int $nombrePlaces
): bool {
    return executeQuery(
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
function getTrajetByIdAndEmploye(
    int $idTrajet,
    int $idEmploye
): array|false {
    return findOne(
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
function updateTrajet(
    int $idTrajet,
    int $idEmploye,
    int $idAgenceDepart,
    int $idAgenceArrivee,
    string $dateDepart,
    string $dateArrivee,
    int $nombrePlaces
): bool {
    return executeQuery(
        'UPDATE trajets
        SET
            id_agence_depart = :agence_depart,
            id_agence_arrivee = :agence_arrivee,
            date_heure_depart = :date_depart,
            date_heure_arrivee = :date_arrivee,
            nombre_places_total = :places_total,
            nombre_places_disponibles = :places_disponibles
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
function deleteTrajet(
    int $idTrajet,
    int $idEmploye
): bool {
    return executeQuery(
        'DELETE FROM trajets
        WHERE id_trajet = :id_trajet
        AND id_employe = :id_employe',
        [
            'id_trajet' => $idTrajet,
            'id_employe' => $idEmploye,
        ]
    );
}
?>