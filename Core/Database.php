<?php

declare(strict_types=1);

function connection(): PDO
{
    try {
        $bdd = new PDO(
            'mysql:host=' . $_ENV['DB_HOST']
            . ';port=' . $_ENV['DB_PORT']
            . ';dbname=' . $_ENV['DB_NAME']
            . ';charset=utf8mb4',
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD']
        );

        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $bdd;
    } catch (PDOException $e) {
        die('Erreur de connexion : ' . $e->getMessage());
    }
}