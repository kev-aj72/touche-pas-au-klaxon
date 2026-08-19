<h1>Connexion</h1>

<form
    action="/touche-pas-au-klaxon/public/login"
    method="POST"
>
    <div>
        <label for="email">Adresse email</label>

        <input
            type="email"
            id="email"
            name="email"
            autocomplete="email"
            required
        >
    </div>

    <div>
        <label for="password">Mot de passe</label>

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