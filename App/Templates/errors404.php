<?php

/**
 * Template de la page d’erreur 404.
 *
 * Cette page est affichée lorsque
 * l’adresse demandée n’existe pas.
 */

?>
<main class="d-flex justify-content-center align-items-center text-center py-5">
    <!-- Message affiché lorsque la page demandée n’existe pas -->
    <section class="card shadow-sm">
        <div class="card-body p-5">
            <h1 class="display-1 fw-bold text-primary mb-0">404 Page introuvable</h1>
            <p class="text-secondary mb-4">La page que vous recherchez n’existe pas.</p>
            <!-- Retour vers la page d’accueil -->
            <a href="<?php echo $this->url('/'); ?>" class="btn btn-primary">Retour à l’accueil</a>
        </div>
    </section>
</main>