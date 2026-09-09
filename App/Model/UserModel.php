<?php

declare(strict_types=1);

namespace App\Model;

use Core\DefaultModel;

/**
 * Gère la récupération des employés
 * dans la base de données.
 */

class UserModel extends DefaultModel{
    /**
     * Recherche un employé avec son adresse email.
     *
     * @param string $email Adresse email recherchée.
     * @return array|false Employé trouvé ou false.
     */

    public function getEmployeByEmail(string $email): array|false {
        return $this->findOne('SELECT id_employe, nom, prenom, telephone, email, mot_de_passe, role FROM employes WHERE email = :email',
            ['email' => $email,]);
    }

    /**
     * Récupère tous les employés
     * par ordre alphabétique.
     *
     * @return array Liste des employés.
     */

    public function getEmployes(): array {
        return $this->findAll('SELECT id_employe, nom, prenom, telephone, email, role FROM employes ORDER BY nom ASC, prenom ASC');
    }
}
?>