<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\UserModel;
use Core\DefaultController;

/**
 * Gère la connexion et la déconnexion
 * des utilisateurs.
 */

class UserController extends DefaultController {
    /**
     * Nombre maximal de tentatives de connexion.
     */
    private const MAX_LOGIN_ATTEMPTS = 5;

    /**
     * Durée du blocage en secondes.
     */
    private const LOGIN_BLOCK_DURATION = 300;

    /**
     * Modèle pour accéder aux employés.
     */
    private UserModel $userModel;

    /**
     * Initialise le modèle des utilisateurs.
     */
    public function __construct() {
        $this->userModel = new UserModel();
    }

    /**
     * Affiche le formulaire de connexion.
     *
     * @return string Contenu HTML du formulaire.
     */
    public function login(): string {
        return $this->renderLogin();
    }

    /**
     * Vérifie les identifiants de connexion
     * envoyés par l’utilisateur.
     *
     * @return string Contenu HTML en cas d’erreur.
     */
    public function authenticate(): string {
        $this->requireValidCsrfToken();

        if ($this->isLoginBlocked()) {
            return $this->renderLogin('Trop de tentatives. Réessayez dans 5 minutes.');
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!filter_var($email,FILTER_VALIDATE_EMAIL) || $password === '') {
            return $this->renderLogin('Veuillez remplir correctement tous les champs.');
            }

        $employe = $this->userModel->getEmployeByEmail($email);

        if ($employe === false || !password_verify($password,(string) $employe['mot_de_passe'])) {
            $isBlocked = $this->registerFailedAttempt();
            $message = $isBlocked ? 'Trop de tentatives. Réessayez dans 5 minutes.' : 'Adresse email ou mot de passe incorrect.';

            return $this->renderLogin($message);
            }

            $this->resetLoginAttempts();

        session_regenerate_id(true);

        $_SESSION['user'] = ['id_employe' => (int) $employe['id_employe'],
                  'nom' => $employe['nom'],
                  'prenom' => $employe['prenom'],
                  'telephone' => $employe['telephone'],
                  'email' => $employe['email'],
                  'role' => $employe['role']];

        $this->redirect('/');
    }

    /**
     * Déconnecte l’utilisateur et détruit sa session.
     *
     * @return void
     */
    public function logout(): void {
        $this->requireValidCsrfToken();
        $_SESSION = [];
        session_destroy();
        $this->redirect('/login');
    }

    /**
    * Génère le formulaire avec un possible
    * message d’erreur.
    *
    * @param string|null $error Message d’erreur.
    * @return string Contenu HTML du formulaire.
    */

    private function renderLogin( ?string $error = null ): string {
        return $this->render('login', ['error' => $error]);
        }

    /**
     * Vérifie si les tentatives de connexion
     * sont temporairement bloquées.
     *
     * @return bool True si la connexion est bloquée.
     */

    private function isLoginBlocked(): bool {
        $blockedUntil = (int) ($_SESSION['login_blocked_until'] ?? 0 );

        if ($blockedUntil === 0) {
            return false;
        }
        if ($blockedUntil <= time()) {
            $this->resetLoginAttempts();
            return false;
        }

        return true;
    }

    /**
     * Enregistre une tentative de connexion échouée.
     *
     * @return bool True si la limite est atteinte.
     */

    private function registerFailedAttempt(): bool {

        $attempts =(int) ($_SESSION['login_attempts'] ?? 0) + 1;
        $_SESSION['login_attempts'] = $attempts;

        if ($attempts < self::MAX_LOGIN_ATTEMPTS) {
            return false;
        }
            $_SESSION['login_blocked_until'] = time() + self::LOGIN_BLOCK_DURATION;
            return true;
    }

    /**
     * Supprime les informations concernant
     * les tentatives de connexion.
     *
     * @return void
     */
    
    private function resetLoginAttempts(): void {
        unset($_SESSION['login_attempts'],
              $_SESSION['login_blocked_until']);
    }
}
?>