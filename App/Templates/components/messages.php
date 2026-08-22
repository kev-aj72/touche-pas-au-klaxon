<?php

/** @var string|null $success */
/** @var string|null $error */

$success = $success ?? null;
$error = $error ?? null;

?>

<?php if ($success !== null): ?>
    <div
        class="alert alert-success"
        role="alert"
    >
        <?= $success ?>
    </div>
<?php endif; ?>

<?php if ($error !== null): ?>
    <div
        class="alert alert-danger"
        role="alert"
    >
        <?= $error ?>
    </div>
<?php endif; ?>