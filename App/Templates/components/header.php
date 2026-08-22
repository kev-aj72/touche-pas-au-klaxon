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

<header
    class="container d-flex justify-content-between
        align-items-center border border-2 border-dark
        rounded-4 bg-light px-3 py-2 mt-3 mb-4"
>
    <a
        href="<?= $this->url('/') ?>"
        class="fs-5 fw-bold text-dark text-decoration-none"
    >
        Touche pas au klaxon
    </a>

    <nav
        class="d-flex align-items-center gap-2"
        aria-label="Navigation principale"
    >
        <?php if ($utilisateurConnecte !== null): ?>
            <a
                href="<?= $this->url(
                    '/trajets/ajouter'
                ) ?>"
                class="btn btn-success text-white"
            >
                Créer un trajet
            </a>

            <?php if (
                $utilisateurConnecte['role'] === 'ADMIN'
            ): ?>
                <a
                    href="<?= $this->url(
                        '/admin/employes'
                    ) ?>"
                    class="btn btn-secondary"
                >
                    Utilisateurs
                </a>

                <a
                    href="<?= $this->url(
                        '/admin/agences'
                    ) ?>"
                    class="btn btn-secondary"
                >
                    Agences
                </a>

                <a
                    href="<?= $this->url(
                        '/admin/trajets'
                    ) ?>"
                    class="btn btn-secondary"
                >
                    Trajets
                </a>
            <?php endif; ?>

            <span class="ms-2">
                Bonjour <?= $nomUtilisateur ?>
            </span>

            <form
                action="<?= $this->url('/logout') ?>"
                method="post"
                class="mb-0"
            >
                <button
                    type="submit"
                    class="btn btn-dark"
                >
                    Déconnexion
                </button>
            </form>
        <?php else: ?>
            <a
                href="<?= $this->url('/login') ?>"
                class="btn btn-dark"
            >
                Connexion
            </a>
        <?php endif; ?>
    </nav>
</header>