<?php

declare(strict_types=1);

namespace Core\Traits;

trait TemplateTrait
{
    /**
     * Charge une page complète.
     */
    protected function render(
        string $template,
        array $data = []
    ): string {
        extract($data, EXTR_SKIP);

        ob_start();

        require dirname(__DIR__, 2)
            . '/App/Templates/'
            . $template
            . '.php';

        return (string) ob_get_clean();
    }

    /**
     * Charge un composant réutilisable.
     */
    protected function component(
        string $component,
        array $data = []
    ): string {
        return $this->render(
            'components/' . $component,
            $data
        );
    }

    /**
     * Sécurise une valeur affichée.
     */
    protected function escape(string $value): string
    {
        return htmlspecialchars(
            $value,
            ENT_QUOTES,
            'UTF-8'
        );
    }
}