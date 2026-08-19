<?php

declare(strict_types=1);

namespace App\Controller;

require_once __DIR__ . '/../Model/userModel.php';

class UserController
{
    /**
     * Affiche le formulaire de connexion.
     */
    public function login(): string
    {
        return $this->renderLogin();
    }

    /**
     * Traite le formulaire de connexion.
     */
    public function authenticate(): string
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Vérification des champs
        if (
            !filter_var($email, FILTER_VALIDATE_EMAIL)
            || $password === ''
        ) {
            return $this->renderLogin(
                'Veuillez remplir correctement tous les champs.'
            );
        }

        // Recherche de l’employé avec son email
        $employe = \getEmployeByEmail($email);

        // Vérification du compte et du mot de passe
        if (
            $employe === false
            || !password_verify(
                $password,
                (string) $employe['mot_de_passe']
            )
        ) {
            return $this->renderLogin(
                'Adresse email ou mot de passe incorrect.'
            );
        }

        // Sécurisation de la session
        session_regenerate_id(true);

        // Enregistrement de l’employé connecté
        $_SESSION['user'] = [
            'id_employe' => (int) $employe['id_employe'],
            'nom' => $employe['nom'],
            'prenom' => $employe['prenom'],
            'telephone' => $employe['telephone'],
            'email' => $employe['email'],
            'role' => $employe['role'],
        ];

        // Redirection vers l’accueil
        header(
            'Location: /touche-pas-au-klaxon/public/'
        );

        exit;
    }

    /**
     * Déconnecte l’utilisateur.
     */
    public function logout(): void
    {
        $_SESSION = [];

        session_destroy();

        header(
            'Location: /touche-pas-au-klaxon/public/login'
        );

        exit;
    }

    /**
     * Charge le template de connexion.
     */
    private function renderLogin(
        ?string $error = null
    ): string {
        ob_start();

        require dirname(__DIR__) . '/Templates/login.php';

        return (string) ob_get_clean();
    }
}