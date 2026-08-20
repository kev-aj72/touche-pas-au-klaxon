<?php

/** @var array $trajetsAffiches */
/** @var array|null $utilisateurConnecte */
/** @var string|null $nomUtilisateur */
/** @var string|null $messageSucces */

?>

<?= $this->component(
    'header',
    [
        'utilisateurConnecte' =>
            $utilisateurConnecte,

        'nomUtilisateur' =>
            $nomUtilisateur,
    ]
) ?>

<main>
    <?= $this->component(
        'messages',
        [
            'success' => $messageSucces,
        ]
    ) ?>

    <h1>Trajets proposés</h1>

    <?php if ($utilisateurConnecte !== null): ?>
        <a href="/touche-pas-au-klaxon/public/trajets/ajouter">
            Proposer un trajet
        </a>
    <?php endif; ?>

    <?php if ($trajetsAffiches === []): ?>
        <p>Aucun trajet disponible pour le moment.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Départ</th>
                    <th>Arrivée</th>
                    <th>Date de départ</th>
                    <th>Date d’arrivée</th>
                    <th>Places disponibles</th>

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
    <?php endif; ?>
</main>