<?php

declare(strict_types=1);

namespace App\Model;

use Core\DefaultModel;

class UserModel extends DefaultModel
{
    /**
     * Recherche un employé avec son adresse email.
     */
    public function getEmployeByEmail(
        string $email
    ): array|false {
        return $this->findOne(
            'SELECT
                id_employe,
                nom,
                prenom,
                telephone,
                email,
                mot_de_passe,
                role
            FROM employes
            WHERE email = :email',
            [
                'email' => $email,
            ]
        );
    }

    /**
     * Récupère tous les employés.
     */
    public function getEmployes(): array
    {
        return $this->findAll(
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
}