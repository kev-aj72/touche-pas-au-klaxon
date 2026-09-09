<?php

declare(strict_types=1);

namespace Core;

use Core\Traits\CsrfTrait;
use Core\Traits\FlashMessageTrait;
use Core\Traits\TemplateTrait;

/**
 * Fournit les fonctionnalités communes
 * à tous les contrôleurs.
 */
abstract class DefaultController {
    use TemplateTrait;
    use FlashMessageTrait;
    use CsrfTrait;

    /**
     * Construit une URL de l’application.
     *
     * @param string $path Chemin à ajouter.
     * @return string URL complète de l’application.
     */
    protected function url(string $path = ''): string {
        $basePath = rtrim($_ENV['APP_BASE_PATH'],'/');
        if ($path === ''|| $path === '/') {
            return $basePath . '/';
        }
        return $basePath. '/'. ltrim($path, '/');
    }

    /**
     * Redirige l’utilisateur vers une autre page.
     *
     * @param string $path Chemin de destination.
     * @return never
     */
    protected function redirect(string $path): never {
        header('Location: ' . $this->url($path));
        exit;
    }

    /**
     * Vérifie qu’un utilisateur est connecté.
     *
     * @return void
     */
    protected function requireLogin(): void{
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
        }
    }

    /**
     * Vérifie que l’utilisateur connecté
     * possède le rôle administrateur.
     *
     * @return void
     */
    protected function requireAdmin(): void{
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'ADMIN') {
            http_response_code(403);
            exit('Accès interdit.');
        }
    }
}
?>