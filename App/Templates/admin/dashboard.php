<?php

/**
 * Template du tableau de bord administrateur.
 *
 * Cette page présente les fonctionnalités
 * disponibles et la liste des trajets.
 */

/** @var array $trajetsAffiches Liste complète des trajets. */
/** @var string|null $messageSucces Message de réussite. */
/** @var string|null $messageErreur Message d’erreur. */

?>

<main class="pb-4">
    <!-- Présentation du tableau de bord -->
    <section class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <h1 class="h2 card-title">Administration</h1>
            <p class="card-text mb-0">Utilisez la navigation pour consulter les employés et gérer les agences et les trajets.</p>
        </div>
    </section>

    <!-- Liste de tous les trajets -->
    <section>
        <h2 class="h4 mb-3">Liste de tous les trajets</h2>
        <!-- Affichage des messages flash -->
        <?php echo $this->component('messages',['success' => $messageSucces,'error' => $messageErreur,]); ?>
        <!-- Tableau réutilisable des trajets -->
        <?php echo $this->component('adminTrajetsTable',['trajetsAffiches' => $trajetsAffiches,]); ?>
    </section>
</main>