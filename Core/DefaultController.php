<?php

declare(strict_types=1);

namespace Core;

use Core\Traits\FlashMessageTrait;
use Core\Traits\TemplateTrait;

abstract class DefaultController
{
    use TemplateTrait;
    use FlashMessageTrait;

    protected function url(
        string $path = ''
    ): string {
        $basePath = rtrim(
            $_ENV['APP_BASE_PATH'],
            '/'
        );

        if ($path === '' || $path === '/') {
            return $basePath . '/';
        }

        return $basePath
            . '/'
            . ltrim($path, '/');
    }

    protected function redirect(
        string $path
    ): never {
        header('Location: ' . $this->url($path));

        exit;
    }

    protected function requireLogin(): void
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
        }
    }

    protected function requireAdmin(): void
    {
        if (
            !isset($_SESSION['user'])
            || $_SESSION['user']['role'] !== 'ADMIN'
        ) {
            http_response_code(403);

            exit('Accès interdit.');
        }
    }
}