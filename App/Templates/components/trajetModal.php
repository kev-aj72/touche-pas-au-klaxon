<?php

/**
 * Fenêtre modale affichant les informations
 * complémentaires d’un trajet.
 */

/** @var array $trajet Informations du trajet. */
/** @var string $idModal Identifiant unique de la fenêtre modale. */

?>

<div class="modal fade text-start" id="<?php echo $this->escape($idModal); ?>" tabindex="-1" aria-labelledby="<?php echo $this->escape($idModal . 'Titre');?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- En-tête de la fenêtre modale -->
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="<?php echo $this->escape($idModal . 'Titre');?>"> Détails du trajet</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <!-- Coordonnées de la personne à contacter -->
            <div class="modal-body">
                <p>Auteur :<strong><?php echo $this->escape($trajet['contact']);?></strong></p>
                <p>Téléphone :<strong><?php echo $this->escape($trajet['telephone']);?></strong></p>
                <p>Email :<strong><?php echo $this->escape($trajet['email']);?></strong></p>
                <p class="mb-0">Nombre total de places :<?php echo (int) $trajet['places_total'];?></p>
            </div>

            <!-- Bouton de fermeture de la fenêtre -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>