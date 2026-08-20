<?php

/** @var array $trajet */
/** @var array $agences */

?>

<h1>Modifier le trajet</h1>

<?= $this->component(
    'trajetForm',
    [
        'action' =>
            '/touche-pas-au-klaxon/public/trajets/'
            . (int) $trajet['id_trajet']
            . '/modifier',

        'submitLabel' =>
            'Enregistrer les modifications',

        'agences' =>
            $agences,

        'trajet' =>
            $trajet,
    ]
) ?>