<?php

/** @var array $trajet */
/** @var array|null $utilisateurConnecte */

?>

<tr>
    <td><?= $trajet['ville_depart'] ?></td>
    <td><?= $trajet['ville_arrivee'] ?></td>
    <td><?= $trajet['date_depart'] ?></td>
    <td><?= $trajet['date_arrivee'] ?></td>
    <td><?= $trajet['places_disponibles'] ?></td>

    <?php if ($utilisateurConnecte !== null): ?>
        <td>
            <details>
                <summary>Voir</summary>

                <p>
                    Contact :
                    <?= $trajet['contact'] ?>
                </p>

                <p>
                    Téléphone :
                    <?= $trajet['telephone'] ?>
                </p>

                <p>
                    Email :
                    <?= $trajet['email'] ?>
                </p>

                <p>
                    Nombre total de places :
                    <?= $trajet['places_total'] ?>
                </p>
            </details>
        </td>

        <td>
            <?php if ($trajet['est_auteur']): ?>
                <a
                    href="/touche-pas-au-klaxon/public/trajets/<?= $trajet['id_trajet'] ?>/modifier"
                >
                    Modifier
                </a>

                <form
                    action="/touche-pas-au-klaxon/public/trajets/<?= $trajet['id_trajet'] ?>/supprimer"
                    method="post"
                    onsubmit="return confirm('Supprimer ce trajet ?');"
                >
                    <button type="submit">
                        Supprimer
                    </button>
                </form>
            <?php endif; ?>
        </td>
    <?php endif; ?>
</tr>