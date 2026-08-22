<?php

/** @var array $agences */
/** @var string|null $error */
/** @var array $auteur */

?>

<main class="pb-4">
    <h1 class="h2 mb-4">
        Proposer un trajet
    </h1>

    <section class="card shadow-sm mb-4">
        <div class="card-body">
            <h2 class="h5 card-title mb-3">
                Contact du trajet
            </h2>

            <div class="row">
                <div class="col-md-4">
                    <strong>Nom :</strong>

                    <?= $this->escape(
                        $auteur['prenom']
                        . ' '
                        . $auteur['nom']
                    ) ?>
                </div>

                <div class="col-md-4">
                    <strong>Téléphone :</strong>

                    <?= $this->escape(
                        $auteur['telephone']
                    ) ?>
                </div>

                <div class="col-md-4">
                    <strong>Email :</strong>

                    <?= $this->escape(
                        $auteur['email']
                    ) ?>
                </div>
            </div>
        </div>
    </section>

    <?= $this->component(
        'messages',
        [
            'error' => $error,
        ]
    ) ?>

    <?= $this->component(
        'trajetForm',
        [
            'action' =>
                $this->url('/trajets/ajouter'),

            'submitLabel' =>
                'Créer le trajet',

            'agences' =>
                $agences,

            'trajet' =>
                null,
        ]
    ) ?>
</main>