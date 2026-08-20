<?php

$utilisateurConnecte =
    $_SESSION['user'] ?? null;

$nomUtilisateur = null;

if ($utilisateurConnecte !== null) {
    $nomUtilisateur = $this->escape(
        $utilisateurConnecte['prenom']
        . ' '
        . $utilisateurConnecte['nom']
    );
}

?>

<header>
    <a href="<?= $this->url('/') ?>">
        Touche pas au klaxon
    </a>

    <?php if ($utilisateurConnecte !== null): ?>
        <p>
            Connecté : <?= $nomUtilisateur ?>
        </p>

        <?php if (
            $utilisateurConnecte['role'] === 'ADMIN'
        ): ?>
            <a href="<?= $this->url('/admin') ?>">
                Administration
            </a>
        <?php endif; ?>

        <form
            action="<?= $this->url('/logout') ?>"
            method="post"
        >
            <button type="submit">
                Se déconnecter
            </button>
        </form>
    <?php else: ?>
        <a href="<?= $this->url('/login') ?>">
            Se connecter
        </a>
    <?php endif; ?>
</header>