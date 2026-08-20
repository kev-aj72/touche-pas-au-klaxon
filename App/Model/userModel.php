<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Core/DefaultModel.php';

function getEmployeByEmail(string $email): array|false
{
    return findOne(
        "SELECT
            id_employe,
            nom,
            prenom,
            email,
            mot_de_passe,
            role
        FROM employes
        WHERE email = :email",
        [
            'email' => $email,
        ]
    );
}

/**
 * Récupère tous les employés.
 */
function getEmployes(): array
{
    return findAll(
        'SELECT
            id_employe,
            nom,
            prenom,
            telephone,
            email,
            role
        FROM employes
        ORDER BY nom ASC, prenom ASC'
    );
}