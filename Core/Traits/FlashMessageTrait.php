<?php

declare(strict_types=1);

namespace Core\Traits;

trait FlashMessageTrait
{
    protected function flash(
        string $type,
        string $message
    ): void {
        $_SESSION[$type] = $message;
    }

    protected function pullFlash(
        string $type
    ): ?string {
        $message = $_SESSION[$type] ?? null;

        unset($_SESSION[$type]);

        return $message !== null
            ? $this->escape((string) $message)
            : null;
    }

    /**
     * @return array{0: ?string, 1: ?string}
     */
    protected function pullFlashMessages(): array
    {
        return [
            $this->pullFlash('success'),
            $this->pullFlash('error'),
        ];
    }
}