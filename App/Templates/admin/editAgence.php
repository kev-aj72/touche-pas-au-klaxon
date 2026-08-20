<?php

/** @var array $agenceAffichee */

?>

<h1>Modifier une agence</h1>

<form
    action="/touche-pas-au-klaxon/public/admin/agences/<?= $agenceAffichee['id_agence'] ?>/modifier"
    method="post"
>
    <div>
        <label for="ville">Ville</label>

        <input
            type="text"
            id="ville"
            name="ville"
            value="<?= $agenceAffichee['ville'] ?>"
            required
        >
    </div>

    <button type="submit">
        Enregistrer les modifications
    </button>

    <a href="/touche-pas-au-klaxon/public/admin/agences">
        Annuler
    </a>
</form>