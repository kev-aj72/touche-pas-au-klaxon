<?php

/**
 * Page de gestion des trajets administrateur.
 */

/** @var array $trajetsAffiches Liste complète des trajets. */
/** @var string|null $messageSucces Message de réussite. */
/** @var string|null $messageErreur Message d’erreur. */
?>

<main class="pb-4">
    <h1 class="h2 mb-4">Gestion des trajets</h1>

    <!-- Affichage des messages flash -->
    <?php echo $this->component('messages',['success' => $messageSucces, 'error' => $messageErreur,]); ?>

    <!-- Affichage du composant réutilisable -->
    <?php echo $this->component('adminTrajetsTable',['trajetsAffiches' => $trajetsAffiches,]); ?>
</main>