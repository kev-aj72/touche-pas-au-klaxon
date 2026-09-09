<?php

declare(strict_types=1);

namespace App\Model;

use Core\DefaultModel;

/**
 * Gère les opérations concernant
 * les agences dans la base de données.
 */
class AgenceModel extends DefaultModel {
    /**
     * Récupère toutes les agences
     * par ordre alphabétique.
     *
     * @return array Liste des agences.
     */
    public function getAgences(): array {
        return $this->findAll('SELECT id_agence, ville FROM agences ORDER BY ville ASC');
    }

    /**
     * Enregistre une nouvelle agence.
     *
     * @param string $ville Nom de la ville.
     * @return bool True si la création réussit.
     */
    public function createAgence(string $ville): bool {
        return $this->executeQuery('INSERT INTO agences (ville) VALUES (:ville)',
            ['ville' => $ville]);
    }

    /**
     * Recherche une agence avec son nom.
     *
     * @param string $ville Nom de la ville.
     * @return array|false Agence trouvée ou false.
     */
    public function getAgenceByVille(string $ville): array|false {
        return $this->findOne('SELECT id_agence, ville FROM agences WHERE ville = :ville',
            ['ville' => $ville]);
    }

    /**
     * Recherche une agence avec son identifiant.
     *
     * @param int $idAgence Identifiant de l’agence.
     * @return array|false Agence trouvée ou false.
     */
    public function getAgenceById(int $idAgence): array|false {
        return $this->findOne('SELECT id_agence, ville FROM agences WHERE id_agence = :id_agence',
            ['id_agence' => $idAgence]);
    }

    /**
     * Modifie le nom d’une agence.
     *
     * @param int $idAgence Identifiant de l’agence.
     * @param string $ville Nouveau nom de la ville.
     * @return bool True si la modification réussit.
     */
    public function updateAgence(int $idAgence, string $ville): bool {
        return $this->executeQuery('UPDATE agences SET ville = :ville WHERE id_agence = :id_agence',
            ['ville' => $ville,
             'id_agence' => $idAgence]);
    }

    /**
     * Vérifie si une agence est utilisée
     * comme départ ou arrivée d’un trajet.
     *
     * @param int $idAgence Identifiant de l’agence.
     * @return bool True si l’agence est utilisée.
     */
    public function isAgenceUsed(int $idAgence): bool {
        $result = $this->findOne('SELECT COUNT(*) AS total FROM trajets WHERE id_agence_depart = :agence_depart OR id_agence_arrivee = :agence_arrivee',
            ['agence_depart' => $idAgence,
             'agence_arrivee' => $idAgence]);

        return $result !== false && (int) $result['total'] > 0;
    }

    /**
     * Supprime une agence.
     *
     * @param int $idAgence Identifiant de l’agence.
     * @return bool True si la suppression réussit.
     */
    public function deleteAgence(int $idAgence): bool {
        return $this->executeQuery('DELETE FROM agences WHERE id_agence = :id_agence',
            ['id_agence' => $idAgence,]);
    }
}