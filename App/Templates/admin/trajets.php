<?php

/**
 * Template affichant tous les trajets
 * dans l’espace administrateur.
 */

/** @var array $trajetsAffiches Liste complète des trajets. */
/** @var string|null $messageSucces Message de réussite. */
/** @var string|null $messageErreur Message d’erreur. */
?>

<main class="pb-4">
    <h1 class="h2 mb-4">Liste de tous les trajets</h1>
    <!-- Affichage des messages de réussite ou d’erreur -->
    <?php echo $this->component('messages',['success' => $messageSucces, 'error' => $messageErreur,]);?>

    <!-- Message affiché lorsque la liste est vide -->
    <?php if ($trajetsAffiches === []): ?>
        <p>Aucun trajet trouvé.</p>
    <?php else: ?>
        <!-- Tableau de tous les trajets -->
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
                    <!-- Création d’une ligne pour chaque trajet -->
                    <?php foreach ($trajetsAffiches as $trajet): ?>
                        <?php
                        /*
                         * Création d’un identifiant unique
                         * pour la fenêtre modale du trajet.
                         */
                        $idTrajet = (int) $trajet['id_trajet'];
                        $idModal = 'detailsTrajetAdmin'. $idTrajet;
                        ?>

                        <tr>
                            <td><?php echo $this->escape($trajet['ville_depart']);?></td>
                            <td><?php echo $this->escape($trajet['ville_arrivee']);?></td>
                            <td><?php echo $this->escape($trajet['date_depart']);?></td>
                            <td><?php echo $this->escape($trajet['date_arrivee']);?></td>
                            <td><?php echo (int) $trajet['places_disponibles'];?>/<?php echo (int) $trajet['places_total'];?></td>
                            <td><?php echo $this->escape($trajet['contact']);?></td>

                            <!-- Ouverture des détails du trajet -->
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#<?php echo $idModal;?>">Voir</button>
                                <?php echo $this->component('trajetModal',['trajet' => $trajet, 'idModal' => $idModal,]);?>
                            </td>

                            <!-- Suppression autorisée à l’administrateur -->
                            <td>
                                <form action="<?php echo $this->url('/admin/trajets/'. $idTrajet. '/supprimer');?>" 
                                      method="post" class="d-inline" onsubmit="return confirm('Supprimer ce trajet ?');">
                                    <!-- Protection contre les attaques CSRF -->
                                    <?php echo $this->csrfField();?>

                                    <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>