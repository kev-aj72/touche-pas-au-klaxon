<?php

/** @var array $agenceAffichee */

?>

<h1>Modifier une agence</h1>

<?= $this->component('adminNavigation') ?>

<?= $this->component(
    'agenceForm',
    [
        'action' =>
            '/touche-pas-au-klaxon/public/admin/agences/'
            . $agenceAffichee['id_agence']
            . '/modifier',

        'submitLabel' =>
            'Enregistrer les modifications',

        'ville' =>
            $agenceAffichee['ville'],

        'cancelUrl' =>
            '/touche-pas-au-klaxon/public/admin/agences',
    ]
) ?>