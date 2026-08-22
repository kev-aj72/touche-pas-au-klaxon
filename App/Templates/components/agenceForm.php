<?php

/** @var string $action */
/** @var string $submitLabel */
/** @var array|null $agence */

$ville = $agence['ville'] ?? '';

?>

<form
    action="<?= $this->escape($action) ?>"
    method="post"
    class="card shadow-sm p-4"
>
    <div class="row align-items-end g-3">
        <div class="col-md-6">
            <label
                for="ville"
                class="form-label fw-semibold"
            >
                Ville
            </label>

            <input
                type="text"
                id="ville"
                name="ville"
                class="form-control"
                value="<?= $ville ?>"
                maxlength="100"
                required
            >
        </div>

        <div class="col-md-6">
            <button
                type="submit"
                class="btn btn-primary"
            >
                <?= $this->escape(
                    $submitLabel
                ) ?>
            </button>

            <a
                href="<?= $this->url(
                    '/admin/agences'
                ) ?>"
                class="btn btn-outline-secondary"
            >
                Annuler
            </a>
        </div>
    </div>
</form>