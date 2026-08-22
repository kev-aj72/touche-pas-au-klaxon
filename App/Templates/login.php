<?php

/** @var string|null $error */

?>

<main class="pb-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <section class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h2 mb-4">
                        Connexion
                    </h1>

                    <?= $this->component(
                        'messages',
                        [
                            'error' => $error,
                        ]
                    ) ?>

                    <form
                        action="<?= $this->url(
                            '/login'
                        ) ?>"
                        method="post"
                    >
                        <div class="mb-3">
                            <label
                                for="email"
                                class="form-label"
                            >
                                Adresse email
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                autocomplete="email"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label
                                for="password"
                                class="form-label"
                            >
                                Mot de passe
                            </label>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                autocomplete="current-password"
                                required
                            >
                        </div>

                        <div class="d-flex gap-2">
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Se connecter
                            </button>

                            <a
                                href="<?= $this->url('/') ?>"
                                class="btn btn-outline-secondary"
                            >
                                Retour à l’accueil
                            </a>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</main>