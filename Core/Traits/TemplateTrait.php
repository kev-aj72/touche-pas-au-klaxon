<?php

declare(strict_types=1);

namespace Core\Traits;

/**
 * Gère l’affichage des templates
 * et des composants HTML.
 */
trait TemplateTrait
{
    /**
     * Affiche un template à l’intérieur
     * du layout principal.
     *
     * @param string $template Nom du template.
     * @param array $data Données envoyées au template.
     * @return string Contenu HTML complet.
     */
    protected function render(string $template, array $data = []): string {
        $content = $this->renderFile($template, $data);
        return $this->renderFile('layout',['content' => $content,]);
    }

    /**
     * Affiche un composant HTML réutilisable.
     *
     * @param string $component Nom du composant.
     * @param array $data Données du composant.
     * @return string Contenu HTML du composant.
     */
    protected function component(string $component, array $data = []): string {
        return $this->renderFile('components/' . $component, $data);
    }

    /**
     * Protège une valeur avant son affichage HTML.
     *
     * @param string $value Valeur à protéger.
     * @return string Valeur protégée.
     */
    protected function escape(string $value): string {
        return htmlspecialchars($value,ENT_QUOTES,'UTF-8');
    }

    /**
     * Exécute un fichier de template
     * et récupère son contenu HTML.
     *
     * @param string $template Nom du template.
     * @param array $data Données du template.
     * @return string Contenu HTML généré.
     */
    private function renderFile(string $template,array $data = []): string {
        extract($data,EXTR_SKIP );
        ob_start();

        require dirname(__DIR__, 2). '/App/Templates/'. $template. '.php';
        return (string) ob_get_clean();
    }
}
?>