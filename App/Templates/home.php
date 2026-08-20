<?php

/** @var array $trajetsAffiches */
/** @var array|null $utilisateurConnecte */
/** @var string|null $nomUtilisateur */
/** @var string|null $messageSucces */

?>

<header>
    <?php if ($utilisateurConnecte !== null): ?>
        <p>Connecté : <?= $nomUtilisateur ?></p>

        <?php if ($utilisateurConnecte['role'] === 'ADMIN'): ?>
    <p>
        <a href="/touche-pas-au-klaxon/public/admin">
            Administration
        </a>
    </p>
<?php endif; ?>

        <form
            action="/touche-pas-au-klaxon/public/logout"
            method="post"
        >
            <button type="submit">Se déconnecter</button>
        </form>
    <?php else: ?>
        <a href="/touche-pas-au-klaxon/public/login">
            Se connecter
        </a>
    <?php endif; ?>
</header>

<main>
    <?php if ($messageSucces !== null): ?>
        <p><?= $messageSucces ?></p>
    <?php endif; ?>

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

                    <?php if ($utilisateurConnecte !== null): ?>
                        <th>Détails</th>
                        <th>Actions</th>
                    <?php endif; ?>
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
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>