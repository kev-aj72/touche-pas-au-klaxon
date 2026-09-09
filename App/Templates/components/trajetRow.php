<?php

/**
 * Composant représentant une ligne
 * dans le tableau des trajets.
 */

/** @var array $trajet Informations du trajet. */
/** @var array|null $utilisateurConnecte Utilisateur connecté. */

$idTrajet = (int) $trajet['id_trajet'];
$idModal = 'detailsTrajet' . $idTrajet;
?>

<tr>
    <!-- Informations principales du trajet -->
    <td><?php echo $this->escape($trajet['ville_depart']);?></td>
    <td><?php echo $this->escape($trajet['ville_arrivee']);?></td>
    <td><?php echo $this->escape($trajet['date_depart']);?></td>
    <td><?php echo $this->escape($trajet['date_arrivee']);?></td>
    <td><?php echo (int) $trajet['places_disponibles'];?></td>

    <!-- Colonnes visibles uniquement après connexion -->
    <?php if ($utilisateurConnecte !== null): ?>
        <td>
            <!-- Ouverture de la fenêtre modale du trajet -->
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#<?php echo $idModal; ?>">Voir</button>
            <?php echo $this->component('trajetModal',['trajet' => $trajet,'idModal' => $idModal,]);?>
        </td>

        <td>
            <!--
                La modification et la suppression sont
                réservées à l’auteur du trajet.
            -->
            <?php if ($trajet['est_auteur']): ?>
                <a href="<?php echo $this->url('/trajets/'. $idTrajet. '/modifier');?>" class="btn btn-sm btn-outline-primary">Modifier</a>

                <form action="<?php echo $this->url('/trajets/'. $idTrajet. '/supprimer');?>" method="post" class="d-inline" onsubmit="return confirm('Supprimer ce trajet ?');">
                    <!-- Protection de la suppression contre les attaques CSRF -->
                    <?php echo $this->csrfField(); ?>

                    <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                </form>
            <?php else: ?>
                <span class="text-muted">—</span>
            <?php endif; ?>
        </td>
    <?php endif; ?>
</tr>