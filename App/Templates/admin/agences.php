<?php

/** @var array $agencesAffichees */
/** @var string|null $messageSucces */
/** @var string|null $messageErreur */

?>

<main>
    <h1>Gestion des agences</h1>

    <?= $this->component(
        'adminNavigation'
    ) ?>

    <?= $this->component(
        'messages',
        [
            'success' => $messageSucces,
            'error' => $messageErreur,
        ]
    ) ?>

    <section>
        <h2>Ajouter une agence</h2>

        <?= $this->component(
            'agenceForm',
            [
                'action' =>
                    $this->url(
                        '/admin/agences/ajouter'
                    ),

                'submitLabel' =>
                    'Ajouter l’agence',

                'agence' =>
                    null,
            ]
        ) ?>
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
                    <?php foreach (
                        $agencesAffichees as $agence
                    ): ?>
                        <tr>
                            <td>
                                <?= $agence['ville'] ?>
                            </td>

                            <td>
                                <a
                                    href="<?= $this->url(
                                        '/admin/agences/'
                                        . $agence['id_agence']
                                        . '/modifier'
                                    ) ?>"
                                >
                                    Modifier
                                </a>

                                <form
                                    action="<?= $this->url(
                                        '/admin/agences/'
                                        . $agence['id_agence']
                                        . '/supprimer'
                                    ) ?>"
                                    method="post"
                                    onsubmit="return confirm(
                                        'Supprimer cette agence ?'
                                    );"
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
</main>