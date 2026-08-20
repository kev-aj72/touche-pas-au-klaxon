<?php

/** @var string $action */
/** @var string $submitLabel */
/** @var array|null $agence */

$ville = $agence['ville'] ?? '';

?>

<form
    action="<?= $this->escape($action) ?>"
    method="post"
>
    <div>
        <label for="ville">
            Ville
        </label>

        <input
            type="text"
            id="ville"
            name="ville"
            value="<?= $ville ?>"
            maxlength="100"
            required
        >
    </div>

    <button type="submit">
        <?= $this->escape($submitLabel) ?>
    </button>

    <a href="<?= $this->url('/admin/agences') ?>">
        Annuler
    </a>
</form>