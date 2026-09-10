<?php

declare(strict_types=1);

namespace Core\Traits;

/**
 * Gère les messages temporaires affichés
 * 
 */
trait FlashMessageTrait {
    /**
     * Enregistre un message.
     *
     * @param string $type Type du message.
     * @param string $message Texte du message.
     * @return void
     */
    protected function flash(string $type, string $message): void {
        $_SESSION[$type] = $message;
    }

    /**
     * Récupère puis supprime un message
     * enregistré dans la session.
     *
     * @param string $type Type du message.
     * @return string|null Message trouvé ou null.
     */
    protected function pullFlash(string $type): ?string {
        $message = $_SESSION[$type] ?? null;
        unset($_SESSION[$type]);
        return $message !== null? (string) $message: null;
    }

    /**
     * Récupère les messages de réussite
     * et d’erreur.
     *
     * @return array{0: ?string, 1: ?string}
     * Messages de réussite et d’erreur.
     */
    protected function pullFlashMessages(): array{
        return [$this->pullFlash('success'),
                $this->pullFlash('error')];
    }
}
?>