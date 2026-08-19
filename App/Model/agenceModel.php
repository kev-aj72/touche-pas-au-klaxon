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