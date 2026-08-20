<?php

/** @var array $trajetsAffiches */
/** @var string|null $messageSucces */
/** @var string|null $messageErreur */

?>

<h1>Liste de tous les trajets</h1>

<?php if ($messageSucces !== null): ?>
    <p><?= $messageSucces ?></p>
<?php endif; ?>

<?php if ($messageErreur !== null): ?>
    <p><?= $messageErreur ?></p>
<?php endif; ?>

<?php if ($trajetsAffiches === []): ?>
    <p>Aucun trajet trouvé.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Départ</th>
                <th>Arrivée</th>
                <th>Date de départ</th>
                <th>Date d’arrivée</th>
                <th>Places</th>
                <th>Auteur</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($trajetsAffiches as $trajet): ?>
                <tr>
                    <td><?= $trajet['ville_depart'] ?></td>
                    <td><?= $trajet['ville_arrivee'] ?></td>
                    <td><?= $trajet['date_depart'] ?></td>
                    <td><?= $trajet['date_arrivee'] ?></td>

                    <td>
                        <?= $trajet['places_disponibles'] ?>
                        /
                        <?= $trajet['places_total'] ?>
                    </td>

                    <td><?= $trajet['auteur'] ?></td>

                    <td>
                        <form
                            action="/touche-pas-au-klaxon/public/admin/trajets/<?= $trajet['id_trajet'] ?>/supprimer"
                            method="post"
                            onsubmit="return confirm('Supprimer ce trajet ?');"
                        >
                            <button type="submit">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<p>
    <a href="/touche-pas-au-klaxon/public/admin">
        Retour à l’administration
    </a>
</p>