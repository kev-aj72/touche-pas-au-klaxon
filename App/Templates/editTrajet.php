<?php

/** @var array $trajet Trajet à modifier. */
/** @var array $agences Liste des agences disponibles. */

?>

<main class="pb-4">
    <h1 class="h2 mb-4">Modifier le trajet</h1>

    <!--Réutilisation du même formulaire que pour la création.
        Les informations du trajet remplissent automatiquement les champs-->
    <?php echo $this->component('trajetForm',['action' => $this->url('/trajets/' . (int) $trajet['id_trajet'] . '/modifier'),
                                'submitLabel' => 'Enregistrer les modifications', 'agences' => $agences, 'trajet' => $trajet,]);
    ?>
</main>