<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\UserModel;
use Core\DefaultController;

class UserController extends DefaultController
{
    private const MAX_LOGIN_ATTEMPTS = 5;
    private const LOGIN_BLOCK_DURATION = 300;

    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login(): string
    {
        return $this->renderLogin();
    }

    public function authenticate(): string
    {
        if ($this->isLoginBlocked()) {
            return $this->renderLogin(
                'Trop de tentatives. Réessayez dans 5 minutes.'
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

        $employe =
            $this->userModel->getEmployeByEmail($email);

        if (
            $employe === false
            || !password_verify(
                $password,
                (string) $employe['mot_de_passe']
            )
        ) {
            $isBlocked =
                $this->registerFailedAttempt();

            $message = $isBlocked
                ? 'Trop de tentatives. Réessayez dans 5 minutes.'
                : 'Adresse email ou mot de passe incorrect.';

            return $this->renderLogin($message);
        }

        $this->resetLoginAttempts();

        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id_employe' =>
                (int) $employe['id_employe'],

            'nom' =>
                $employe['nom'],

            'prenom' =>
                $employe['prenom'],

            'telephone' =>
                $employe['telephone'],

            'email' =>
                $employe['email'],

            'role' =>
                $employe['role'],
        ];

        $this->redirect('/');
    }

    public function logout(): void
    {
        $_SESSION = [];

        session_destroy();

        $this->redirect('/login');
    }

    private function renderLogin(
        ?string $error = null
    ): string {
        return $this->render(
            'login',
            [
                'error' => $error,
            ]
        );
    }

    private function isLoginBlocked(): bool
    {
        $blockedUntil =
            (int) ($_SESSION['login_blocked_until'] ?? 0);

        if ($blockedUntil === 0) {
            return false;
        }

        if ($blockedUntil <= time()) {
            $this->resetLoginAttempts();

            return false;
        }

        return true;
    }

    private function registerFailedAttempt(): bool
    {
        $attempts =
            (int) ($_SESSION['login_attempts'] ?? 0) + 1;

        $_SESSION['login_attempts'] = $attempts;

        if ($attempts < self::MAX_LOGIN_ATTEMPTS) {
            return false;
        }

        $_SESSION['login_blocked_until'] =
            time() + self::LOGIN_BLOCK_DURATION;

        return true;
    }

    private function resetLoginAttempts(): void
    {
        unset(
            $_SESSION['login_attempts'],
            $_SESSION['login_blocked_until']
        );
    }
}