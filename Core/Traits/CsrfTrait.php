<?php

declare(strict_types=1);

namespace Core\Traits;

/**
 * Protège les formulaires contre
 * les attaques CSRF.
 */
trait CsrfTrait {
    /**
     * Nom utilisé pour enregistrer
     * le jeton dans la session.
     */
    private const CSRF_TOKEN_KEY = 'csrf_token';

    /**
     * Génère ou récupère le jeton CSRF
     *
     * @return string Jeton CSRF.
     */
    protected function csrfToken(): string {
        $token = $_SESSION[self::CSRF_TOKEN_KEY] ?? null;

        if (!is_string($token)|| $token === '') {
            $token = bin2hex(random_bytes(32));
            $_SESSION[self::CSRF_TOKEN_KEY] = $token;
        }
        return $token;
    }

    /**
     * Génère le champ caché à ajouter
     * dans un formulaire POST.
     *
     * @return string Champ HTML contenant le jeton.
     */
    protected function csrfField(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . $this->escape($this->csrfToken()) . '">';
    }

    /**
     * Vérifie le jeton envoyé par le formulaire.
     *
     * @return void
     */
    protected function requireValidCsrfToken(): void {
        $sessionToken = $_SESSION[self::CSRF_TOKEN_KEY] ?? null;
        $submittedToken = $_POST[self::CSRF_TOKEN_KEY] ?? null;
        if (!is_string($sessionToken)|| !is_string($submittedToken)|| $submittedToken === ''|| !hash_equals($sessionToken,$submittedToken)) {
            http_response_code(403);
            exit('Requête invalide Veuillez réessayer.');
        }
    }

    /**
     * Protège une valeur avant son affichage.
     *
     * @param string $value Valeur à protéger.
     * @return string Valeur protégée.
     */
    abstract protected function escape(string $value): string;
}
?>