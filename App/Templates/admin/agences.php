<?php

/** @var array $agencesAffichees */
/** @var string|null $messageSucces */
/** @var string|null $messageErreur */

?>

<main class="pb-4">
    <h1 class="h2 mb-4">
        Gestion des agences
    </h1>

    <?= $this->component(
        'messages',
        [
            'success' => $messageSucces,
            'error' => $messageErreur,
        ]
    ) ?>

    <section class="mb-5">
        <h2 class="h4 mb-3">
            Ajouter une agence
        </h2>

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
        <h2 class="h4 mb-3">
            Liste des agences
        </h2>

        <?php if ($agencesAffichees === []): ?>
            <p>Aucune agence trouvée.</p>
        <?php else: ?>
            <div
                class="table-responsive rounded-4
                    overflow-hidden"
            >
                <table
                    class="table table-striped table-hover
                        align-middle mb-0"
                >
                    <thead class="table-dark">
                        <tr>
                            <th>Ville</th>
                            <th class="text-end">
                                Actions
                            </th>
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

                                <td class="text-end">
                                    <a
                                        href="<?= $this->url(
                                            '/admin/agences/'
                                            . $agence[
                                                'id_agence'
                                            ]
                                            . '/modifier'
                                        ) ?>"
                                        class="btn btn-sm
                                            btn-outline-primary"
                                    >
                                        Modifier
                                    </a>

                                    <form
                                        action="<?= $this->url(
                                            '/admin/agences/'
                                            . $agence[
                                                'id_agence'
                                            ]
                                            . '/supprimer'
                                        ) ?>"
                                        method="post"
                                        class="d-inline"
                                        onsubmit="return confirm(
                                            'Supprimer cette agence ?'
                                        );"
                                    >
                                        <button
                                            type="submit"
                                            class="btn btn-sm
                                                btn-outline-danger"
                                        >
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</main>