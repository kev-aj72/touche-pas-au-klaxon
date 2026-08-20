<?php

/** @var array $agenceAffichee */

?>

<main>
    <h1>Modifier une agence</h1>

    <?= $this->component(
        'adminNavigation'
    ) ?>

    <?= $this->component(
        'agenceForm',
        [
            'action' =>
                $this->url(
                    '/admin/agences/'
                    . $agenceAffichee['id_agence']
                    . '/modifier'
                ),

            'submitLabel' =>
                'Enregistrer les modifications',

            'agence' =>
                $agenceAffichee,
        ]
    ) ?>
</main>