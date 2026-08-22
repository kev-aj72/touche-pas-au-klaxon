<?php

/** @var array $trajet */
/** @var array|null $utilisateurConnecte */

$idTrajet = (int) $trajet['id_trajet'];
$idModal = 'detailsTrajet' . $idTrajet;

?>

<tr>
    <td><?= $trajet['ville_depart'] ?></td>
    <td><?= $trajet['ville_arrivee'] ?></td>
    <td><?= $trajet['date_depart'] ?></td>
    <td><?= $trajet['date_arrivee'] ?></td>
    <td><?= $trajet['places_disponibles'] ?></td>

    <?php if ($utilisateurConnecte !== null): ?>
        <td>
            <button
                type="button"
                class="btn btn-sm btn-outline-primary"
                data-bs-toggle="modal"
                data-bs-target="#<?= $idModal ?>"
            >
                Voir
            </button>

            <?= $this->component(
                'trajetModal',
                [
                    'trajet' => $trajet,
                    'idModal' => $idModal,
                ]
            ) ?>
        </td>

        <td>
            <?php if ($trajet['est_auteur']): ?>
                <a
                    href="<?= $this->url(
                        '/trajets/'
                        . $idTrajet
                        . '/modifier'
                    ) ?>"
                    class="btn btn-sm btn-outline-primary"
                >
                    Modifier
                </a>

                <form
                    action="<?= $this->url(
                        '/trajets/'
                        . $idTrajet
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
                        class="btn btn-sm btn-outline-danger"
                    >
                        Supprimer
                    </button>
                </form>
            <?php else: ?>
                <span class="text-muted">—</span>
            <?php endif; ?>
        </td>
    <?php endif; ?>
</tr>