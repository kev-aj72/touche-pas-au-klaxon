<?php

/** @var array $agences */
/** @var string|null $error */
/** @var array $auteur */
?>

<h1>Proposer un trajet</h1>

<section>
    <h2>Contact du trajet</h2>

    <p>
        Nom :
        <?= htmlspecialchars(
            $auteur['prenom'] . ' ' . $auteur['nom'],
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </p>

    <p>
        Téléphone :
        <?= htmlspecialchars(
            $auteur['telephone'],
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </p>

    <p>
        Email :
        <?= htmlspecialchars(
            $auteur['email'],
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </p>
</section>

<?php if ($error !== null): ?>
    <p>
        <?= htmlspecialchars(
            $error,
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </p>
<?php endif; ?>

<form
    action="/touche-pas-au-klaxon/public/trajets/ajouter"
    method="post"
>
    <div>
        <label for="agence_depart">Agence de départ</label>

        <select id="agence_depart" name="id_agence_depart" required>
            <option value="">Choisir une agence</option>

            <?php foreach ($agences as $agence): ?>
                <option value="<?= (int) $agence['id_agence'] ?>">
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
            <option value="">Choisir une agence</option>

            <?php foreach ($agences as $agence): ?>
                <option value="<?= (int) $agence['id_agence'] ?>">
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
            required
        >
    </div>

    <div>
        <label for="date_arrivee">Date et heure d’arrivée</label>

        <input
            type="datetime-local"
            id="date_arrivee"
            name="date_heure_arrivee"
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
            required
        >
    </div>

    <button type="submit">Créer le trajet</button>

    <a href="/touche-pas-au-klaxon/public/">
        Annuler
    </a>
</form>