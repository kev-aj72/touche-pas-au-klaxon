<?php

declare(strict_types=1);

namespace App\Model;

use Core\DefaultModel;

class AgenceModel extends DefaultModel
{
    /**
     * Récupère toutes les agences.
     */
    public function getAgences(): array
    {
        return $this->findAll(
            'SELECT id_agence, ville
            FROM agences
            ORDER BY ville ASC'
        );
    }

    /**
     * Enregistre une nouvelle agence.
     */
    public function createAgence(
        string $ville
    ): bool {
        return $this->executeQuery(
            'INSERT INTO agences (ville)
            VALUES (:ville)',
            [
                'ville' => $ville,
            ]
        );
    }

    /**
     * Recherche une agence avec son nom de ville.
     */
    public function getAgenceByVille(
        string $ville
    ): array|false {
        return $this->findOne(
            'SELECT id_agence, ville
            FROM agences
            WHERE ville = :ville',
            [
                'ville' => $ville,
            ]
        );
    }

    /**
     * Récupère une agence avec son identifiant.
     */
    public function getAgenceById(
        int $idAgence
    ): array|false {
        return $this->findOne(
            'SELECT id_agence, ville
            FROM agences
            WHERE id_agence = :id_agence',
            [
                'id_agence' => $idAgence,
            ]
        );
    }

    /**
     * Modifie le nom d’une agence.
     */
    public function updateAgence(
        int $idAgence,
        string $ville
    ): bool {
        return $this->executeQuery(
            'UPDATE agences
            SET ville = :ville
            WHERE id_agence = :id_agence',
            [
                'ville' => $ville,
                'id_agence' => $idAgence,
            ]
        );
    }

    /**
     * Vérifie si une agence est utilisée dans un trajet.
     */
    public function isAgenceUsed(
        int $idAgence
    ): bool {
        $result = $this->findOne(
            'SELECT COUNT(*) AS total
            FROM trajets
            WHERE id_agence_depart = :agence_depart
            OR id_agence_arrivee = :agence_arrivee',
            [
                'agence_depart' => $idAgence,
                'agence_arrivee' => $idAgence,
            ]
        );

        return $result !== false
            && (int) $result['total'] > 0;
    }

    /**
     * Supprime une agence.
     */
    public function deleteAgence(
        int $idAgence
    ): bool {
        return $this->executeQuery(
            'DELETE FROM agences
            WHERE id_agence = :id_agence',
            [
                'id_agence' => $idAgence,
            ]
        );
    }
}