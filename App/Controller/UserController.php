<?php

declare(strict_types=1);

namespace App\Controller;

require_once __DIR__ . '/../Model/userModel.php';

class UserController
{

 private const MAX_LOGIN_ATTEMPTS = 5;
    private const LOGIN_BLOCK_DURATION = 300;
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
    $blockedUntil =
        (int) ($_SESSION['login_blocked_until'] ?? 0);

    if ($blockedUntil > time()) {
        return $this->renderLogin(
            'Trop de tentatives. Réessayez dans 5 minutes.'
        );
    }

    if ($blockedUntil !== 0) {
        unset(
            $_SESSION['login_attempts'],
            $_SESSION['login_blocked_until']
        );
    }

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (
        !filter_var($email, FILTER_VALIDATE_EMAIL)
        || $password === ''
    ) {
        return $this->renderLogin(
            'Veuillez remplir correctement tous les champs.'
        );
    }

    $employe = \getEmployeByEmail($email);

    if (
        $employe === false
        || !password_verify(
            $password,
            (string) $employe['mot_de_passe']
        )
    ) {
        $tentatives =
            (int) ($_SESSION['login_attempts'] ?? 0) + 1;

        $_SESSION['login_attempts'] = $tentatives;

        if ($tentatives >= self::MAX_LOGIN_ATTEMPTS) {
            $_SESSION['login_blocked_until'] =
                time() + self::LOGIN_BLOCK_DURATION;

            return $this->renderLogin(
                'Trop de tentatives. Réessayez dans 5 minutes.'
            );
        }

        return $this->renderLogin(
            'Adresse email ou mot de passe incorrect.'
        );
    }

    unset(
        $_SESSION['login_attempts'],
        $_SESSION['login_blocked_until']
    );

    session_regenerate_id(true);

    $_SESSION['user'] = [
        'id_employe' => (int) $employe['id_employe'],
        'nom' => $employe['nom'],
        'prenom' => $employe['prenom'],
        'telephone' => $employe['telephone'],
        'email' => $employe['email'],
        'role' => $employe['role'],
    ];

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