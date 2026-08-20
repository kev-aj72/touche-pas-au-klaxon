<?php

declare(strict_types=1);

namespace Core;

use Core\Traits\FlashMessageTrait;
use Core\Traits\TemplateTrait;

abstract class DefaultController
{
    use TemplateTrait;
    use FlashMessageTrait;

    protected function redirect(string $path): never
    {
        header(
            'Location: /touche-pas-au-klaxon/public'
            . $path
        );

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