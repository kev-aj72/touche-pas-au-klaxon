<?php

/** @var array $trajet */
/** @var string $idModal */

?>

<div
    class="modal fade text-start"
    id="<?= $idModal ?>"
    tabindex="-1"
    aria-labelledby="<?= $idModal ?>Titre"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2
                    class="modal-title fs-5"
                    id="<?= $idModal ?>Titre"
                >
                    Détails du trajet
                </h2>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Fermer"
                ></button>
            </div>

            <div class="modal-body">
                <p>
                    Auteur :
                    <strong>
                        <?= $trajet['contact'] ?>
                    </strong>
                </p>

                <p>
                    Téléphone :
                    <strong>
                        <?= $trajet['telephone'] ?>
                    </strong>
                </p>

                <p>
                    Email :
                    <strong>
                        <?= $trajet['email'] ?>
                    </strong>
                </p>

                <p class="mb-0">
                    Nombre total de places :
                    <?= $trajet['places_total'] ?>
                </p>
            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>