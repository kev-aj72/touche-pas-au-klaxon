<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Core/DefaultModel.php';

/**
 * Récupère toutes les agences.
 */
function getAgences(): array
{
    return findAll(
        'SELECT id_agence, ville
        FROM agences
        ORDER BY ville ASC'
    );
}
/**
 * Enregistre une nouvelle agence.
 */
function createAgence(string $ville): bool
{
    return executeQuery(
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
function getAgenceByVille(string $ville): array|false
{
    return findOne(
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
function getAgenceById(int $idAgence): array|false
{
    return findOne(
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
function updateAgence(
    int $idAgence,
    string $ville
): bool {
    return executeQuery(
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
function isAgenceUsed(int $idAgence): bool
{
    $result = findOne(
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
function deleteAgence(int $idAgence): bool
{
    return executeQuery(
        'DELETE FROM agences
        WHERE id_agence = :id_agence',
        [
            'id_agence' => $idAgence,
        ]
    );
}