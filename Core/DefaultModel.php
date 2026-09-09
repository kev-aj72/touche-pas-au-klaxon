<?php

declare(strict_types=1);

namespace Core;
use PDO;
require_once __DIR__ . '/Database.php';

/**
 * Fournit les méthodes communes utilisées
 * par tous les modèles de l’application.
 */
abstract class DefaultModel {
    /**
     * Exécute une requête qui récupère
     * plusieurs lignes.
     *
     * @param string $stmt Requête SQL.
     * @param array $parameters Paramètres PDO.
     * @return array Liste des résultats.
     */
    protected function findAll(string $stmt, array $parameters = []): array {
        $bdd = \connection();
        $query = $bdd->prepare($stmt);
        $query->execute($parameters);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Exécute une requête qui récupère
     * une seule ligne.
     *
     * @param string $stmt Requête SQL.
     * @param array $parameters Paramètres PDO.
     * @return array|false Résultat ou false.
     */
    protected function findOne(string $stmt, array $parameters = []): array|false {
        $bdd = \connection();
        $query = $bdd->prepare($stmt);
        $query->execute($parameters);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Exécute une requête d’écriture :
     * INSERT, UPDATE ou DELETE.
     *
     * @param string $stmt Requête SQL.
     * @param array $parameters Paramètres PDO.
     * @return bool True si la requête réussit.
     */
    protected function executeQuery(string $stmt, array $parameters = []): bool {
        $bdd = \connection();
        $query = $bdd->prepare($stmt);

        return $query->execute($parameters);
    }
}