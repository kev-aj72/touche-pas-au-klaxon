<?php

/** @var array $trajet */
/** @var array $agences */

?>

<main class="pb-4">
    <h1 class="h2 mb-4">
        Modifier le trajet
    </h1>

    <?= $this->component(
        'trajetForm',
        [
            'action' =>
                $this->url(
                    '/trajets/'
                    . (int) $trajet['id_trajet']
                    . '/modifier'
                ),

            'submitLabel' =>
                'Enregistrer les modifications',

            'agences' =>
                $agences,

            'trajet' =>
                $trajet,
        ]
    ) ?>
</main>