<?php

declare(strict_types=1);

require_once __DIR__ . '/database.php';

function findAll(string $stmt): array
{
    // Connexion à la base de données
    $bdd = connection();

    // Exécution de la requête SQL reçue en paramètre
    $query = $bdd->query($stmt);

    // Récupération de toutes les lignes
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function findOne(string $stmt, array $parameters): array|false
{
    // Connexion à la base de données
    $bdd = connection();

    // Préparation de la requête
    $query = $bdd->prepare($stmt);

    // Exécution avec les données sécurisées
    $query->execute($parameters);

    // Récupération d’une seule ligne
    return $query->fetch(PDO::FETCH_ASSOC);
}