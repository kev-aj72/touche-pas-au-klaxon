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
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Destination</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Places</th>
                    <th>Auteur</th>
                    <th><span class="visually-hidden"> Actions</span></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($trajetsAffiches as $trajet): ?>
                <?php $idTrajet = (int) $trajet['id_trajet']; $idModal = 'detailsTrajetAdmin' . $idTrajet;?>

                <tr>
                    <td><?php echo $this->escape($trajet['ville_depart']); ?></td>
                    <td><?php echo $this->escape($trajet['date_depart']); ?></td>
                    <td><?php echo $this->escape($trajet['heure_depart']); ?></td>
                    <td><?php echo $this->escape($trajet['ville_arrivee']); ?></td>
                    <td><?php echo $this->escape($trajet['date_arrivee']); ?></td>
                    <td><?php echo $this->escape($trajet['heure_arrivee']); ?></td>
                    <td><?php echo (int) $trajet['places_disponibles']; ?></td>
                    <td><?php echo $this->escape($trajet['contact']); ?></td>
                    <td><button type="button" class="btn btn-sm btn-link text-dark text-decoration-none p-1" data-bs-toggle="modal"
                                data-bs-target="#<?php echo $idModal; ?>" aria-label="Voir les détails du trajet" title="Voir">
                                <i class="bi bi-eye fs-5" aria-hidden="true"></i></button>
                    <?php echo $this->component('trajetModal',['trajet' => $trajet, 'idModal' => $idModal,]); ?>
                    <?php if ($trajet['est_auteur']): ?><a href="<?php echo $this->url('/trajets/'. $idTrajet. '/modifier'); ?>"
                          class="btn btn-sm btn-link text-primary text-decoration-none p-1" aria-label="Modifier le trajet" title="Modifier">
                         <i class="bi bi-pencil-square fs-5" aria-hidden="true"></i></a>
                <?php endif; ?>

                <form action="<?php echo $this->url('/admin/trajets/'. $idTrajet. '/supprimer'); ?>"
                      method="post" class="d-inline" onsubmit="return confirm('Supprimer ce trajet ?');">
                    <?php echo $this->csrfField(); ?>

                    <button type="submit" class="btn btn-sm btn-link text-danger text-decoration-none p-1" 
                            aria-label="Supprimer le trajet" title="Supprimer" >
                        <i class="bi bi-trash fs-5" aria-hidden="true"></i></button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
        </table>
    </div>
<?php endif; ?>