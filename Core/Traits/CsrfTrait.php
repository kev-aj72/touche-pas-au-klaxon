<?php

declare(strict_types=1);

namespace Core\Traits;

trait CsrfTrait
{
    private const CSRF_TOKEN_KEY = 'csrf_token';

    /**
     * Génère et conserve un jeton CSRF dans la session.
     */
    protected function csrfToken(): string
    {
        $token =
            $_SESSION[self::CSRF_TOKEN_KEY] ?? null;

        if (!is_string($token) || $token === '') {
            $token = bin2hex(random_bytes(32));

            $_SESSION[self::CSRF_TOKEN_KEY] =
                $token;
        }

        return $token;
    }

    /**
     * Retourne le champ caché à placer
     * dans les formulaires POST.
     */
    protected function csrfField(): string
    {
        return '<input type="hidden"
            name="csrf_token"
            value="'
            . $this->escape($this->csrfToken())
            . '">';
    }

    /**
     * Vérifie le jeton envoyé par le formulaire.
     */
    protected function requireValidCsrfToken(): void
    {
        $sessionToken =
            $_SESSION[self::CSRF_TOKEN_KEY] ?? null;

        $submittedToken =
            $_POST[self::CSRF_TOKEN_KEY] ?? null;

        if (
            !is_string($sessionToken)
            || !is_string($submittedToken)
            || $submittedToken === ''
            || !hash_equals(
                $sessionToken,
                $submittedToken
            )
        ) {
            http_response_code(403);

            exit(
                'Requête invalide. Veuillez réessayer.'
            );
        }
    }

    abstract protected function escape(
        string $value
    ): string;
}