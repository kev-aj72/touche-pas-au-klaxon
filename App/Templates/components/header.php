<?php

/**
 * Composant d’en-tête commun à toutes les pages.
 *
 * Son contenu change selon que le visiteur est
 * déconnecté, utilisateur ou administrateur.
 */

/** @var array|null $utilisateurConnecte Utilisateur connecté. */
$utilisateurConnecte = $_SESSION['user'] ?? null;
$nomUtilisateur = null;

/*
 * Préparation du nom complet qui sera
 * affiché dans le menu.
 */
if ($utilisateurConnecte !== null) {
        $nomUtilisateur = $this->escape($utilisateurConnecte['prenom']. ' ' . $utilisateurConnecte['nom']);
}

/*
 * Pour un administrateur, le nom de l’application
 * renvoie vers le tableau de bord.
 */
$lienApplication = $utilisateurConnecte !== null && $utilisateurConnecte['role'] === 'ADMIN' ? '/admin': '/';
?>

<header class="container d-flex justify-content-between align-items-center border border-2 border-dark rounded-4 bg-light px-3 py-2 mt-3 mb-4">
    <!-- Nom et lien principal de l’application -->
    <a href="<?php echo $this->url($lienApplication);?>" class="fs-5 fw-bold text-dark text-decoration-none">Touche pas au klaxon</a>
    
    <nav class="d-flex align-items-center gap-2" aria-label="Navigation principale">
        <?php if ($utilisateurConnecte !== null): ?>
            <!-- Action disponible pour tous les employés connectés -->
            <a href="<?php echo $this->url('/trajets/ajouter');?>" class="btn btn-success text-white">Créer un trajet</a>

            <!-- Menu réservé à l’administrateur -->
            <?php if ($utilisateurConnecte['role'] === 'ADMIN'):?>
                <a href="<?php echo $this->url('/admin/employes');?>" class="btn btn-secondary">Utilisateurs</a>
                <a href="<?php echo $this->url('/admin/agences');?>" class="btn btn-secondary">Agences</a>
                <a href="<?php echo $this->url('/admin/trajets');?>" class="btn btn-secondary">Trajets</a>
            <?php endif; ?>

            <!-- Identité de l’utilisateur connecté -->
            <span class="ms-2">Bonjour <?php echo $nomUtilisateur; ?></span>

            <!-- Déconnexion protégée par un jeton CSRF -->
            <form action="<?php echo $this->url('/logout');?>" method="post" class="mb-0">
                <?php echo $this->csrfField();?>
                <button type="submit" class="btn btn-dark">Déconnexion</button>
            </form>
        <?php else: ?>

            <!-- Menu affiché à un visiteur non connecté -->
            <a href="<?php echo $this->url('/login');?>" class="btn btn-dark">Connexion</a>
        <?php endif; ?>
    </nav>
</header>