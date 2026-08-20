<?php

declare(strict_types=1);

namespace Core\Traits;

trait TemplateTrait
{
    protected function render(
        string $template,
        array $data = []
    ): string {
        $content = $this->renderFile(
            $template,
            $data
        );

        return $this->renderFile(
            'layout',
            ['content' => $content]
        );
    }

    protected function component(
        string $component,
        array $data = []
    ): string {
        return $this->renderFile(
            'components/' . $component,
            $data
        );
    }

    protected function escape(
        string $value
    ): string {
        return htmlspecialchars(
            $value,
            ENT_QUOTES,
            'UTF-8'
        );
    }

    private function renderFile(
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
}