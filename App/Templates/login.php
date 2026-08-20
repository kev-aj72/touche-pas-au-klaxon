<?php

/** @var string|null $error */

?>

<h1>Connexion</h1>

<?= $this->component(
    'messages',
    [
        'error' => $error !== null
            ? $this->escape($error)
            : null,
    ]
) ?>

<form
    action="/touche-pas-au-klaxon/public/login"
    method="post"
>
    <div>
        <label for="email">
            Adresse email
        </label>

        <input
            type="email"
            id="email"
            name="email"
            autocomplete="email"
            required
        >
    </div>

    <div>
        <label for="password">
            Mot de passe
        </label>

        <input
            type="password"
            id="password"
            name="password"
            autocomplete="current-password"
            required
        >
    </div>

    <button type="submit">
        Se connecter
    </button>

    <a href="/touche-pas-au-klaxon/public/">
        Retour à l’accueil
    </a>
</form>