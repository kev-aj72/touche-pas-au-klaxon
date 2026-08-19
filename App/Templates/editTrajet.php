<?php

/** @var array $trajet */
/** @var array $agences */

?>

<h1>Modifier le trajet</h1>

<form
    action="/touche-pas-au-klaxon/public/trajets/<?= (int) $trajet['id_trajet'] ?>/modifier"
    method="post"
>
    <div>
        <label for="agence_depart">Agence de départ</label>

        <select id="agence_depart" name="id_agence_depart" required>
            <?php foreach ($agences as $agence): ?>
                <option
                    value="<?= (int) $agence['id_agence'] ?>"
                    <?= (int) $agence['id_agence']
                        === (int) $trajet['id_agence_depart']
                        ? 'selected'
                        : '' ?>
                >
                    <?= htmlspecialchars(
                        $agence['ville'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="agence_arrivee">Agence d’arrivée</label>

        <select id="agence_arrivee" name="id_agence_arrivee" required>
            <?php foreach ($agences as $agence): ?>
                <option
                    value="<?= (int) $agence['id_agence'] ?>"
                    <?= (int) $agence['id_agence']
                        === (int) $trajet['id_agence_arrivee']
                        ? 'selected'
                        : '' ?>
                >
                    <?= htmlspecialchars(
                        $agence['ville'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="date_depart">Date et heure de départ</label>

        <input
            type="datetime-local"
            id="date_depart"
            name="date_heure_depart"
            value="<?= date(
                'Y-m-d\TH:i',
                strtotime($trajet['date_heure_depart'])
            ) ?>"
            required
        >
    </div>

    <div>
        <label for="date_arrivee">Date et heure d’arrivée</label>

        <input
            type="datetime-local"
            id="date_arrivee"
            name="date_heure_arrivee"
            value="<?= date(
                'Y-m-d\TH:i',
                strtotime($trajet['date_heure_arrivee'])
            ) ?>"
            required
        >
    </div>

    <div>
        <label for="nombre_places">Nombre de places</label>

        <input
            type="number"
            id="nombre_places"
            name="nombre_places_total"
            min="1"
            value="<?= (int) $trajet['nombre_places_total'] ?>"
            required
        >
    </div>

    <button type="submit">Enregistrer les modifications</button>

    <a href="/touche-pas-au-klaxon/public/">
        Annuler
    </a>
</form>