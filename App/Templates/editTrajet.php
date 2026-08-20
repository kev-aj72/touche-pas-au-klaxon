<?php

/** @var array $trajet */
/** @var array $agences */

?>

<main>
    <h1>Modifier le trajet</h1>

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