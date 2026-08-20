<?php

/** @var string|null $success */
/** @var string|null $error */

$success = $success ?? null;
$error = $error ?? null;

?>

<?php if ($success !== null): ?>
    <p><?= $success ?></p>
<?php endif; ?>

<?php if ($error !== null): ?>
    <p><?= $error ?></p>
<?php endif; ?>