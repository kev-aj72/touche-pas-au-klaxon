<?php

/** @var string|null $error */

?>

<main>
    <h1>Connexion</h1>

    <?= $this->component(
        'messages',
        [
            'error' => $error,
        ]
    ) ?>

    <form
        action="<?= $this->url('/login') ?>"
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
    </form>

    <p>
        <a href="<?= $this->url('/') ?>">
            Retour à l’accueil
        </a>
    </p>
</main>

