<?php

/**
 * Contenu HTML de la page affichée
 * à l’intérieur du layout.
 *
 * @var string $content
 */

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Touche pas au klaxon</title>
    <!-- Feuille de style générée avec Sass et Bootstrap -->
    <link rel="stylesheet" href="<?php echo $this->url('/assets/css/app.css'); ?>">
</head>

<body class="bg-light text-dark min-vh-100 d-flex flex-column">
    <!-- header commun à toutes les pages -->
    <?php echo $this->component('header'); ?>

    <!-- Contenu de la page demandée -->
    <div class="container flex-grow-1"><?php echo $content ?></div>

    <!-- Pied de page commun -->
    <?php echo $this->component('footer'); ?>

    <!-- fichier Bootstrap pour la fenêtres modales -->
    <script
        src="<?php echo $this->url('/assets/js/bootstrap.bundle.min.js'); ?>"
    ></script>
</body>
</html>