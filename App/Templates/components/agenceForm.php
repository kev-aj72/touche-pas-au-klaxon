<?php

/** @var string $action */
/** @var string $submitLabel */
/** @var string $ville */
/** @var string|null $cancelUrl */

$ville = $ville ?? '';
$cancelUrl = $cancelUrl ?? null;

?>

<form
    action="<?= $action ?>"
    method="post"
>
    <div>
        <label for="ville">Ville</label>

        <input
            type="text"
            id="ville"
            name="ville"
            value="<?= $ville ?>"
            required
        >
    </div>

    <button type="submit">
        <?= $submitLabel ?>
    </button>

    <?php if ($cancelUrl !== null): ?>
        <a href="<?= $cancelUrl ?>">
            Annuler
        </a>
    <?php endif; ?>
</form>