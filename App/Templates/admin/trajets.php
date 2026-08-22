<?php

/** @var array $trajetsAffiches */
/** @var string|null $messageSucces */
/** @var string|null $messageErreur */

?>

<main class="pb-4">
    <h1 class="h2 mb-4">
        Liste de tous les trajets
    </h1>

    <?= $this->component(
        'messages',
        [
            'success' => $messageSucces,
            'error' => $messageErreur,
        ]
    ) ?>

    <?php if ($trajetsAffiches === []): ?>
        <p>Aucun trajet trouvé.</p>
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
                        <th>Auteur</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach (
                        $trajetsAffiches as $trajet
                    ): ?>
                        <tr>
                            <td>
                                <?= $trajet[
                                    'ville_depart'
                                ] ?>
                            </td>

                            <td>
                                <?= $trajet[
                                    'ville_arrivee'
                                ] ?>
                            </td>

                            <td>
                                <?= $trajet[
                                    'date_depart'
                                ] ?>
                            </td>

                            <td>
                                <?= $trajet[
                                    'date_arrivee'
                                ] ?>
                            </td>

                            <td>
                                <?= $trajet[
                                    'places_disponibles'
                                ] ?>
                                /
                                <?= $trajet[
                                    'places_total'
                                ] ?>
                            </td>

                            <td>
                                <?= $trajet['auteur'] ?>
                            </td>

                            <td>
                                <form
                                    action="<?= $this->url(
                                        '/admin/trajets/'
                                        . $trajet[
                                            'id_trajet'
                                        ]
                                        . '/supprimer'
                                    ) ?>"
                                    method="post"
                                    class="d-inline"
                                    onsubmit="return confirm(
                                        'Supprimer ce trajet ?'
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
</main>