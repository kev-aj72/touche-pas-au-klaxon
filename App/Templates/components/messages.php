<?php
/**
 * Composant utilisé pour afficher les messages
 * de réussite et les messages d’erreur.
 */

/** @var string|null $success Message de réussite. */
/** @var string|null $error Message d’erreur. */

$success = $success ?? null;
$error = $error ?? null;
?>

<!-- Message affiché après une opération réussie -->
<?php if ($success !== null): ?>
    <div class="alert alert-success" role="alert">
        <?php echo $this->escape($success); ?>
    </div>
<?php endif; ?>

<!-- Message affiché lorsqu’une erreur se produit -->
<?php if ($error !== null): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $this->escape($error); ?>
    </div>
<?php endif; ?>