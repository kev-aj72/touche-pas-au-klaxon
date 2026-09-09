<?php

declare(strict_types=1);

namespace App\Model;

use Core\DefaultModel;

/**
 * Gère les opérations concernant
 * les trajets dans la base de données.
 */
class PostModel extends DefaultModel {
    /**
     * Récupère les trajets futurs qui possèdent
     * encore des places disponibles.
     *
     * @return array Liste des trajets disponibles.
     */
    public function getTrajets(): array {
        return $this->findAll('SELECT trajets.id_trajet, trajets.date_heure_depart, trajets.date_heure_arrivee, trajets.nombre_places_total, trajets.nombre_places_disponibles,
                             trajets.id_employe, depart.ville AS ville_depart, arrivee.ville AS ville_arrivee, employes.nom AS auteur_nom, employes.prenom AS auteur_prenom, 
                             employes.telephone AS auteur_telephone, employes.email AS auteur_email FROM trajets 
                             INNER JOIN agences AS depart ON depart.id_agence = trajets.id_agence_depart
                             INNER JOIN agences AS arrivee ON arrivee.id_agence = trajets.id_agence_arrivee
                             INNER JOIN employes ON employes.id_employe = trajets.id_employe
                             WHERE trajets.nombre_places_disponibles > 0 AND trajets.date_heure_depart >= NOW() ORDER BY trajets.date_heure_depart ASC');
    }

    /**
     * Récupère tous les trajets pour
     * l’administration.
     *
     * @return array Liste de tous les trajets.
     */
    public function getAllTrajets(): array {
        return $this->findAll('SELECT trajets.id_trajet, trajets.date_heure_depart, trajets.date_heure_arrivee, trajets.nombre_places_total, trajets.nombre_places_disponibles,
                              trajets.id_employe, depart.ville AS ville_depart, arrivee.ville AS ville_arrivee,
                              employes.nom AS auteur_nom, employes.prenom AS auteur_prenom, employes.telephone AS auteur_telephone, employes.email AS auteur_email FROM trajets
                              INNER JOIN agences AS depart ON depart.id_agence = trajets.id_agence_depart
                              INNER JOIN agences AS arrivee ON arrivee.id_agence = trajets.id_agence_arrivee
                              INNER JOIN employes ON employes.id_employe = trajets.id_employe ORDER BY trajets.date_heure_depart DESC');
    }

    /**
     * Enregistre un nouveau trajet.
     *
     * @param int $idEmploye Identifiant de l’auteur.
     * @param int $idAgenceDepart Agence de départ.
     * @param int $idAgenceArrivee Agence d’arrivée.
     * @param string $dateDepart Date de départ.
     * @param string $dateArrivee Date d’arrivée.
     * @param int $nombrePlacesTotal Places totales.
     * @param int $nombrePlacesDisponibles
     * Places encore disponibles.
     *
     * @return bool True si la création réussit.
     */
    public function createTrajet( int $idEmploye, int $idAgenceDepart, int $idAgenceArrivee, string $dateDepart, string $dateArrivee, int $nombrePlacesTotal, int $nombrePlacesDisponibles): bool {
        return $this->executeQuery
        ('INSERT INTO trajets ( date_heure_depart, date_heure_arrivee, nombre_places_total, nombre_places_disponibles, id_employe, id_agence_depart, id_agence_arrivee) 
          VALUES (:date_depart,:date_arrivee,:places_total,:places_disponibles,:id_employe,:agence_depart,:agence_arrivee)',
               ['date_depart' => $dateDepart,
                'date_arrivee' => $dateArrivee,
                'places_total' => $nombrePlacesTotal,
                'places_disponibles' => $nombrePlacesDisponibles,
                'id_employe' => $idEmploye,
                'agence_depart' => $idAgenceDepart,
                'agence_arrivee' => $idAgenceArrivee,]);
    }

    /**
     * Récupère un trajet appartenant
     * à un employé.
     *
     * @param int $idTrajet Identifiant du trajet.
     * @param int $idEmploye Identifiant de l’employé.
     * @return array|false Trajet trouvé ou false.
     */

    public function getTrajetByIdAndEmploye(int $idTrajet, int $idEmploye): array|false {
        return $this->findOne('SELECT * FROM trajets WHERE id_trajet = :id_trajet AND id_employe = :id_employe',
            ['id_trajet' => $idTrajet,
             'id_employe' => $idEmploye,]);
    }

    /**
     * Modifie un trajet appartenant
     * à un employé.
     *
     * @param int $idTrajet Identifiant du trajet.
     * @param int $idEmploye Identifiant de l’auteur.
     * @param int $idAgenceDepart Agence de départ.
     * @param int $idAgenceArrivee Agence d’arrivée.
     * @param string $dateDepart Date de départ.
     * @param string $dateArrivee Date d’arrivée.
     * @param int $nombrePlacesTotal Places totales.
     * @param int $nombrePlacesDisponibles
     * Places encore disponibles.
     *
     * @return bool True si la modification réussit.
     */
    public function updateTrajet( int $idTrajet, int $idEmploye, int $idAgenceDepart, int $idAgenceArrivee, string $dateDepart, string $dateArrivee, int $nombrePlacesTotal, int $nombrePlacesDisponibles): bool {
        return $this->executeQuery
        ('UPDATE trajets SET id_agence_depart = :agence_depart, id_agence_arrivee = :agence_arrivee, date_heure_depart = :date_depart,
         date_heure_arrivee = :date_arrivee, nombre_places_total = :places_total, nombre_places_disponibles = :places_disponibles
          WHERE id_trajet = :id_trajet AND id_employe = :id_employe',
               ['agence_depart' => $idAgenceDepart,
                'agence_arrivee' => $idAgenceArrivee,
                'date_depart' => $dateDepart,
                'date_arrivee' => $dateArrivee,
                'places_total' => $nombrePlacesTotal,
                'places_disponibles' => $nombrePlacesDisponibles,
                'id_trajet' => $idTrajet,
                'id_employe' => $idEmploye,]);
    }

    /**
     * Supprime un trajet appartenant
     * à un employé.
     *
     * @param int $idTrajet Identifiant du trajet.
     * @param int $idEmploye Identifiant de l’auteur.
     * @return bool True si la suppression réussit.
     */
    public function deleteTrajet(int $idTrajet, int $idEmploye): bool {
        return $this->executeQuery
        ('DELETE FROM trajets WHERE id_trajet = :id_trajet AND id_employe = :id_employe',
            ['id_trajet' => $idTrajet,
             'id_employe' => $idEmploye,]);
    }

    /**
     * Recherche un trajet avec son identifiant.
     *
     * @param int $idTrajet Identifiant du trajet.
     * @return array|false Trajet trouvé ou false.
     */
    public function getTrajetById(int $idTrajet): array|false {
        return $this->findOne('SELECT id_trajet FROM trajets WHERE id_trajet = :id_trajet',
            ['id_trajet' => $idTrajet,]);
    }

    /**
     * Supprime un trajet sans vérifier son auteur.
     * Cette méthode est réservée à l’administrateur.
     *
     * @param int $idTrajet Identifiant du trajet.
     * @return bool True si la suppression réussit.
     */
    public function deleteTrajetAdmin(int $idTrajet): bool {
        return $this->executeQuery('DELETE FROM trajets WHERE id_trajet = :id_trajet',
            ['id_trajet' => $idTrajet,]);
    }
}