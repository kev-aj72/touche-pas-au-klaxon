<?php

/** @var array|null $utilisateurConnecte */
/** @var string|null $nomUtilisateur */

$utilisateurConnecte =
    $utilisateurConnecte ?? null;

$nomUtilisateur =
    $nomUtilisateur ?? null;

?>

<header>
    <?php if ($utilisateurConnecte !== null): ?>
        <p>Connecté : <?= $nomUtilisateur ?></p>

        <?php if (
            $utilisateurConnecte['role'] === 'ADMIN'
        ): ?>
            <p>
                <a href="/touche-pas-au-klaxon/public/admin">
                    Administration
                </a>
            </p>
        <?php endif; ?>

        <form
            action="/touche-pas-au-klaxon/public/logout"
            method="post"
        >
            <button type="submit">
                Se déconnecter
            </button>
        </form>
    <?php else: ?>
        <a href="/touche-pas-au-klaxon/public/login">
            Se connecter
        </a>
    <?php endif; ?>
</header>