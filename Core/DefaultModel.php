<?php

declare(strict_types=1);

namespace Core;

use PDO;

require_once __DIR__ . '/database.php';

abstract class DefaultModel
{
    /**
     * Récupère plusieurs lignes.
     */
    protected function findAll(
        string $stmt,
        array $parameters = []
    ): array {
        $bdd = \connection();

        $query = $bdd->prepare($stmt);
        $query->execute($parameters);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une seule ligne.
     */
    protected function findOne(
        string $stmt,
        array $parameters = []
    ): array|false {
        $bdd = \connection();

        $query = $bdd->prepare($stmt);
        $query->execute($parameters);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Exécute une requête INSERT, UPDATE ou DELETE.
     */
    protected function executeQuery(
        string $stmt,
        array $parameters = []
    ): bool {
        $bdd = \connection();

        $query = $bdd->prepare($stmt);

        return $query->execute($parameters);
    }
}