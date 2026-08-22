<?php

/** @var string $action */
/** @var string $submitLabel */
/** @var array $agences */
/** @var array|null $trajet */

$idAgenceDepart =
    (int) ($trajet['id_agence_depart'] ?? 0);

$idAgenceArrivee =
    (int) ($trajet['id_agence_arrivee'] ?? 0);

$dateDepart = isset($trajet['date_heure_depart'])
    ? date(
        'Y-m-d\TH:i',
        strtotime($trajet['date_heure_depart'])
    )
    : '';

$dateArrivee = isset($trajet['date_heure_arrivee'])
    ? date(
        'Y-m-d\TH:i',
        strtotime($trajet['date_heure_arrivee'])
    )
    : '';

$nombrePlaces =
    (int) ($trajet['nombre_places_total'] ?? 1);

?>

<form
    action="<?= $this->escape($action) ?>"
    method="post"
    class="card shadow-sm p-4"
>
    <div class="row g-3">
        <div class="col-md-6">
            <label
                for="agence_depart"
                class="form-label fw-semibold"
            >
                Agence de départ
            </label>

            <select
                id="agence_depart"
                name="id_agence_depart"
                class="form-select"
                required
            >
                <option value="">
                    Choisir une agence
                </option>

                <?php foreach ($agences as $agence): ?>
                    <option
                        value="<?= (int) $agence[
                            'id_agence'
                        ] ?>"
                        <?= (int) $agence['id_agence']
                            === $idAgenceDepart
                            ? 'selected'
                            : '' ?>
                    >
                        <?= $this->escape(
                            $agence['ville']
                        ) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label
                for="agence_arrivee"
                class="form-label fw-semibold"
            >
                Agence d’arrivée
            </label>

            <select
                id="agence_arrivee"
                name="id_agence_arrivee"
                class="form-select"
                required
            >
                <option value="">
                    Choisir une agence
                </option>

                <?php foreach ($agences as $agence): ?>
                    <option
                        value="<?= (int) $agence[
                            'id_agence'
                        ] ?>"
                        <?= (int) $agence['id_agence']
                            === $idAgenceArrivee
                            ? 'selected'
                            : '' ?>
                    >
                        <?= $this->escape(
                            $agence['ville']
                        ) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label
                for="date_depart"
                class="form-label fw-semibold"
            >
                Date et heure de départ
            </label>

            <input
                type="datetime-local"
                id="date_depart"
                name="date_heure_depart"
                class="form-control"
                value="<?= $dateDepart ?>"
                required
            >
        </div>

        <div class="col-md-6">
            <label
                for="date_arrivee"
                class="form-label fw-semibold"
            >
                Date et heure d’arrivée
            </label>

            <input
                type="datetime-local"
                id="date_arrivee"
                name="date_heure_arrivee"
                class="form-control"
                value="<?= $dateArrivee ?>"
                required
            >
        </div>

        <div class="col-md-4">
            <label
                for="nombre_places"
                class="form-label fw-semibold"
            >
                Nombre de places
            </label>

            <input
                type="number"
                id="nombre_places"
                name="nombre_places_total"
                class="form-control"
                min="1"
                max="255"
                value="<?= $nombrePlaces ?>"
                required
            >
        </div>
    </div>

    <div class="d-flex gap-2 mt-4">
        <button
            type="submit"
            class="btn btn-primary"
        >
            <?= $this->escape($submitLabel) ?>
        </button>

        <a
            href="<?= $this->url('/') ?>"
            class="btn btn-outline-secondary"
        >
            Annuler
        </a>
    </div>
</form>