<?php

/**
 * Tableau réutilisable affichant
 * tous les trajets administrateur.
 */

/** @var array $trajetsAffiches Liste complète des trajets. */

?>

<?php if ($trajetsAffiches === []): ?>
    <p>Aucun trajet trouvé.</p>
<?php else: ?>
    <div class="table-responsive rounded-4 overflow-hidden">
        <table class="table table-striped table-hover align-middle text-center mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Départ</th>
                    <th>Arrivée</th>
                    <th>Date de départ</th>
                    <th>Date d’arrivée</th>
                    <th>Places</th>
                    <th>Auteur</th>
                    <th>Détails</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($trajetsAffiches as $trajet): ?>
                <?php
                    $idTrajet =(int) $trajet['id_trajet'];
                    $idModal ='detailsTrajetAdmin' . $idTrajet;?>
                    <tr>
                        <td><?php echo $this->escape($trajet['ville_depart']); ?></td>
                        <td><?php echo $this->escape($trajet['ville_arrivee']); ?></td>
                        <td><?php echo $this->escape($trajet['date_depart']); ?></td>
                        <td><?php echo $this->escape($trajet['date_arrivee']); ?></td>
                        <td><?php echo (int) $trajet['places_disponibles']; ?>/<?php echo (int) $trajet['places_total']; ?></td>
                        <td><?php echo $this->escape($trajet['contact']); ?></td>
                        <td><button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#<?php echo $idModal;?>">Voir</button>
                            <?php echo $this->component('trajetModal',['trajet' => $trajet, 'idModal' => $idModal,]); ?></td>
                        <td><?php if ($trajet['est_auteur']): ?>
                            <a href="<?php echo $this->url('/trajets/' . $idTrajet . '/modifier'); ?>" class="btn btn-sm btn-outline-secondary">Modifier</a>
                <?php endif; ?>

                        <form action="<?php echo $this->url('/admin/trajets/' . $idTrajet . '/supprimer'); ?>" method="post" class="d-inline" onsubmit="return confirm( 'Supprimer ce trajet ?');">
                        <?php echo $this->csrfField(); ?>
                        <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>  
                        </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>