<?php

declare(strict_types=1);

use Dotenv\Dotenv;

$root = dirname(__DIR__);

require_once $root . '/vendor/autoload.php';

/*
 * Charge les paramètres de connexion présents
 * dans le fichier .env principal.
 */
$dotenv = Dotenv::createImmutable($root);
$dotenv->load();

/*
 * Force l’utilisation de la base réservée
 * aux tests PHPUnit.
 */
$_ENV['APP_ENV'] = 'testing';
$_ENV['APP_DEBUG'] = 'true';
$_ENV['DB_NAME'] = 'touche_pas_au_klaxon_test';

/*
 * Empêche les tests de fonctionner sur une base
 * qui ne porte pas le suffixe "_test".
 */
if (!str_ends_with($_ENV['DB_NAME'], '_test')) {
    throw new RuntimeException(
        'Les tests doivent utiliser une base séparée.'
    );
}