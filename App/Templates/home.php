<?php

/** @var array $trajetsAffiches Liste des trajets à afficher. */
/** @var array|null $utilisateurConnecte Utilisateur connecté. */
/** @var string|null $messageSucces Message flash de réussite. */

?>

<main class="pb-4">
    <!-- Affichage du message après une opération réussie -->
    <?php echo $this->component('messages',['success' => $messageSucces,]); ?>

    <!-- Le titre change selon l’état de connexion -->
    <?php if ($utilisateurConnecte !== null): ?>
        <h1 class="h2 mb-3">Trajets proposés</h1>
    <?php else: ?>
        <h2 class="h3 mb-3">Pour obtenir plus d’informations sur un trajet, veuillez vous connecter</h2>
    <?php endif; ?>

    <!-- Message affiché lorsque la liste est vide -->
    <?php if ($trajetsAffiches === []): ?>
        <p>Aucun trajet disponible pour le moment.</p>
    <?php else: ?>
        <!-- Tableau contenant les trajets disponibles -->
        <div class="table-responsive rounded-4 overflow-hidden">
            <table class="table table-striped table-hover align-middle text-center mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Départ</th>
                        <th>Arrivée</th>
                        <th>Date de départ</th>
                        <th>Date d’arrivée</th>
                        <th>Places</th>

                        <!-- Actions réservées aux utilisateurs connectés -->
                        <?php if ($utilisateurConnecte !== null): ?>
                            <th>Détails</th>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>

                <tbody>
                    <!-- Création d’une ligne pour chaque trajet -->
                    <?php foreach ($trajetsAffiches as $trajet): ?>
                        <?php echo $this->component('trajetRow',['trajet' => $trajet, 'utilisateurConnecte' => $utilisateurConnecte,]); ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>