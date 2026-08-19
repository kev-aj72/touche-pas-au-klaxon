<?php

/** @var array $trajets */
/** @var array|null $utilisateurConnecte */

?>

<?php if ($utilisateurConnecte !== null): ?>

    <p>
        Connecté :
        <?= htmlspecialchars(
            (string) $utilisateurConnecte['prenom'],
            ENT_QUOTES,
            'UTF-8'
        ) ?>

        <?= htmlspecialchars(
            (string) $utilisateurConnecte['nom'],
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </p>

    <form
        action="/touche-pas-au-klaxon/public/logout"
        method="POST"
    >
        <button type="submit">
            Se déconnecter
        </button>
    </form>

<?php else: ?>

    <a href="/touche-pas-au-klaxon/public/login">
        Se connecter
    </a>

<?php endif; ?>

<h1>Trajets proposés</h1>

<?php if ($trajets === []): ?>

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
            <?php foreach ($trajets as $trajet): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars(
                            (string) $trajet['ville_depart'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            (string) $trajet['ville_arrivee'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </td>

                    <td>
                        <?= date(
                            'd/m/Y à H:i',
                            strtotime($trajet['date_heure_depart'])
                        ) ?>
                    </td>

                    <td>
                        <?= date(
                            'd/m/Y à H:i',
                            strtotime($trajet['date_heure_arrivee'])
                        ) ?>
                    </td>

                    <td>
                        <?= (int) $trajet['nombre_places_disponibles'] ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>