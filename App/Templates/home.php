<?php

/** @var array $trajetsAffiches */
/** @var array|null $utilisateurConnecte */
/** @var string|null $messageSucces */

?>

<main class="pb-4">
    <?= $this->component(
        'messages',
        [
            'success' => $messageSucces,
        ]
    ) ?>

    <?php if ($utilisateurConnecte !== null): ?>
        <h1 class="h2 mb-3">
            Trajets proposés
        </h1>
    <?php else: ?>
        <h1 class="h3 mb-3">
            Pour obtenir plus d’informations sur un
            trajet, veuillez vous connecter
        </h1>
    <?php endif; ?>

    <?php if ($trajetsAffiches === []): ?>
        <p>
            Aucun trajet disponible pour le moment.
        </p>
    <?php else: ?>
        <div
            class="table-responsive rounded-4
                overflow-hidden"
        >
            <table
                class="table table-striped table-hover
                    align-middle text-center mb-0"
            >
                <thead class="table-dark">
                    <tr>
                        <th>Départ</th>
                        <th>Arrivée</th>
                        <th>Date de départ</th>
                        <th>Date d’arrivée</th>
                        <th>Places</th>

                        <?php if (
                            $utilisateurConnecte !== null
                        ): ?>
                            <th>Détails</th>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach (
                        $trajetsAffiches as $trajet
                    ): ?>
                        <?= $this->component(
                            'trajetRow',
                            [
                                'trajet' => $trajet,

                                'utilisateurConnecte' =>
                                    $utilisateurConnecte,
                            ]
                        ) ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>