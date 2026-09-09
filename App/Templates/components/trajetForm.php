<?php

/**
 * Formulaire commun utilisé pour créer
 * ou modifier un trajet.
 */

/** @var string $action Adresse d’envoi du formulaire. */
/** @var string $submitLabel Texte du bouton de validation. */
/** @var array $agences Liste des agences disponibles. */
/** @var array|null $trajet Trajet à modifier ou null pour une création. */

/*
 * Préparation des valeurs affichées dans les champs.
 * Pour une création, les valeurs par défaut sont utilisées.
 */
$idAgenceDepart = (int) ($trajet['id_agence_depart'] ?? 0);
$idAgenceArrivee = (int) ($trajet['id_agence_arrivee'] ?? 0);
$dateDepart = isset($trajet['date_heure_depart']) ? date('Y-m-d\TH:i', strtotime($trajet['date_heure_depart'])): '';
$dateArrivee = isset($trajet['date_heure_arrivee']) ? date('Y-m-d\TH:i', strtotime($trajet['date_heure_arrivee'])): '';
$nombrePlacesTotal = (int) ($trajet['nombre_places_total'] ?? 1);
$nombrePlacesDisponibles = (int) ($trajet['nombre_places_disponibles'] ?? $nombrePlacesTotal);
?>

<!-- Formulaire de création ou de modification d’un trajet -->
<form action="<?php echo $this->escape($action);?>" method="post" class="card shadow-sm p-4">
    <!-- Protection du formulaire contre les attaques CSRF -->
    <?php echo $this->csrfField();?>

    <div class="row g-3">
        <!-- Sélection de l’agence de départ -->
        <div class="col-md-6">
            <label for="agence_depart" class="form-label fw-semibold">Agence de départ</label>
            <select id="agence_depart" name="id_agence_depart" class="form-select" required>
                <option value="">Choisir une agence</option>

                <?php foreach ($agences as $agence): ?>
                    <option value="<?php echo (int) $agence['id_agence'];?>"
                        <?php echo (int) $agence['id_agence'] === $idAgenceDepart ? 'selected' : '';?>>
                        <?php echo $this->escape($agence['ville'] );?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Sélection de l’agence d’arrivée -->
        <div class="col-md-6">
            <label for="agence_arrivee" class="form-label fw-semibold">Agence d’arrivée</label>

            <select id="agence_arrivee" name="id_agence_arrivee" class="form-select" required>
                <option value="">Choisir une agence</option>

                <?php foreach ($agences as $agence): ?>
                    <option value="<?php echo (int) $agence['id_agence'];?>"
                        <?php echo (int) $agence['id_agence'] === $idAgenceArrivee ? 'selected': '';?>>
                        <?php echo $this->escape($agence['ville']);?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Date et heure de départ -->
        <div class="col-md-6">
            <label for="date_depart" class="form-label fw-semibold">Date et heure de départ</label>
            <input type="datetime-local" id="date_depart" name="date_heure_depart" class="form-control" value="<?php echo $dateDepart; ?>" required>
        </div>

        <!-- Date et heure d’arrivée -->
        <div class="col-md-6">
            <label for="date_arrivee" class="form-label fw-semibold">Date et heure d’arrivée</label>
            <input type="datetime-local" id="date_arrivee" name="date_heure_arrivee" class="form-control" value="<?php echo $dateArrivee; ?>" required>
        </div>

        <!-- Nombre total de places dans le véhicule -->
        <div class="col-md-6">
            <label for="nombre_places_total" class="form-label fw-semibold">Nombre total de places</label>
            <input type="number" id="nombre_places_total" name="nombre_places_total" class="form-control" min="1" max="255" value="<?php echo $nombrePlacesTotal;?>" required>
        </div>

        <!-- Nombre de places encore disponibles -->
        <div class="col-md-6">
            <label for="nombre_places_disponibles" class="form-label fw-semibold">Nombre de places disponibles</label>
            <input type="number" id="nombre_places_disponibles" name="nombre_places_disponibles" class="form-control" min="0" max="255" value="<?php echo $nombrePlacesDisponibles;?>" required>
        </div>
    </div>

    <!-- Actions du formulaire -->
    <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-primary"><?php echo $this->escape($submitLabel);?></button>
        <a href="<?php echo $this->url('/'); ?>" class="btn btn-outline-secondary">Annuler</a>
    </div>
</form>