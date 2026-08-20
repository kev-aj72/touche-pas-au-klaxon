<?php

/** @var array $agencesAffichees */
/** @var string|null $messageSucces */
/** @var string|null $messageErreur */

?>

<h1>Gestion des agences</h1>

<?php if ($messageSucces !== null): ?>
    <p><?= $messageSucces ?></p>
<?php endif; ?>
<?php if ($messageErreur !== null): ?>
    <p><?= $messageErreur ?></p>
<?php endif; ?>

<section>
    <h2>Ajouter une agence</h2>

    <form
        action="/touche-pas-au-klaxon/public/admin/agences/ajouter"
        method="post"
    >
        <div>
            <label for="ville">Ville</label>

            <input
                type="text"
                id="ville"
                name="ville"
                required
            >
        </div>

        <button type="submit">
            Ajouter l’agence
        </button>
    </form>
</section>

<section>
    <h2>Liste des agences</h2>

    <?php if ($agencesAffichees === []): ?>
        <p>Aucune agence trouvée.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Ville</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($agencesAffichees as $agence): ?>
                    <tr>
                        <td><?= $agence['ville'] ?></td>

                        <td>
                            <a
                                href="/touche-pas-au-klaxon/public/admin/agences/<?= $agence['id_agence'] ?>/modifier"
                            >
                                Modifier
                            </a>

                            <form
                                action="/touche-pas-au-klaxon/public/admin/agences/<?= $agence['id_agence'] ?>/supprimer"
                                method="post"
                                onsubmit="return confirm('Supprimer cette agence ?');"
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
</section>

<p>
    <a href="/touche-pas-au-klaxon/public/admin">
        Retour à l’administration
    </a>
</p>