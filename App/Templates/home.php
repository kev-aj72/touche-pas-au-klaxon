<?php

/** @var array $trajetsAffiches */

?>

<h1>Trajets proposés</h1>

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
            </tr>
        </thead>

        <tbody>
            <?php foreach ($trajetsAffiches as $trajet): ?>
                <tr>
                    <td><?= $trajet['ville_depart'] ?></td>
                    <td><?= $trajet['ville_arrivee'] ?></td>
                    <td><?= $trajet['date_depart'] ?></td>
                    <td><?= $trajet['date_arrivee'] ?></td>
                    <td><?= $trajet['places_disponibles'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>