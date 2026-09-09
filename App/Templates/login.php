<?php

/** @var string|null $error Message d’erreur de connexion. */

?>

<main class="pb-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <section class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h2 mb-4">Connexion</h1>

                    <!-- Affichage d’une possible erreur de connexion -->
                    <?php echo $this->component('messages',['error' => $error,]); ?>
                    <!-- Formulaire envoyé au contrôleur de connexion -->
                    <form action="<?php echo $this->url('/login'); ?>" method="post">
                        <!-- Protection du formulaire contre les attaques CSRF -->
                        <?php echo $this->csrfField(); ?>

                        <!-- Identifiant de l’utilisateur -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" id="email" name="email" class="form-control" autocomplete="email" required>
                        </div>
                        <!-- Mot de passe de l’utilisateur -->
                        <div class="mb-4">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" id="password" name="password" class="form-control" autocomplete="current-password" required>
                        </div>
                        <!-- bouton du formulaire -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Se connecter</button>
                            <a href="<?php echo $this->url('/'); ?>" class="btn btn-outline-secondary">Retour à l’accueil</a>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</main>