<?php

/**
 * Formulaire commun utilisé pour créer
 * ou modifier une agence.
 */

/** @var string $action Adresse d’envoi du formulaire. */
/** @var string $submitLabel Texte du bouton de validation. */
/** @var array|null $agence Agence à modifier ou null. */

/*
 * Lors d’une modification, le nom actuel de la ville
 * est affiché dans le champ.
 */
$ville = $agence['ville'] ?? '';
?>

<!-- Formulaire de création ou de modification d’une agence -->
<form action="<?php echo $this->escape($action); ?>" method="post" class="card shadow-sm p-4">
    <!-- Protection du formulaire contre les attaques CSRF -->
    <?php echo $this->csrfField(); ?>

    <div class="row align-items-end g-3">
        <!-- Nom de la ville -->
        <div class="col-md-6">
            <label for="ville" class="form-label fw-semibold">Ville</label>
            <input type="text" id="ville" name="ville" class="form-control" value="<?php echo $this->escape($ville);?>" maxlength="100" required>
        </div>

        <!-- Actions du formulaire -->
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary"><?php echo $this->escape($submitLabel);?></button>
            <a href="<?php echo $this->url('/admin/agences');?>" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </div>
</form>