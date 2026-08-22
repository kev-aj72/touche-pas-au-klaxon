<?php

/** @var array $agenceAffichee */

?>

<main class="pb-4">
    <h1 class="h2 mb-4">
        Modifier une agence
    </h1>

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