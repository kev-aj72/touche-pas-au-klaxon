<?php

declare(strict_types=1);

require_once __DIR__ . '/database.php';

/**
 * Récupère plusieurs lignes.
 */
function findAll(
    string $stmt,
    array $parameters = []
): array {
    $bdd = connection();

    $query = $bdd->prepare($stmt);

    $query->execute($parameters);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère une seule ligne.
 */
function findOne(
    string $stmt,
    array $parameters = []
): array|false {
    $bdd = connection();

    $query = $bdd->prepare($stmt);

    $query->execute($parameters);

    return $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Exécute une requête INSERT, UPDATE ou DELETE.
 */
function executeQuery(
    string $stmt,
    array $parameters = []
): bool {
    $bdd = connection();

    $query = $bdd->prepare($stmt);

    return $query->execute($parameters);
}