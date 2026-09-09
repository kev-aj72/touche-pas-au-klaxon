<?php

/** @var array $agences Liste des agences disponibles. */
/** @var string|null $error Message d’erreur du formulaire. */
/** @var array $auteur Informations de l’utilisateur connecté. */

?>

<main class="pb-4">
    <h1 class="h2 mb-4">Proposer un trajet</h1>
    <!--
        Coordonnées préremplies de l’utilisateur connecté.
        Ces informations ne peuvent pas être modifiées ici.
    -->
    <section class="card shadow-sm mb-4">
        <div class="card-body">
            <h2 class="h5 card-title mb-3">Contact du trajet</h2>
            <div class="row">
                <div class="col-md-4">
                    <strong>Nom :</strong>
                        <?php echo $this->escape($auteur['prenom'] . ' ' . $auteur['nom']); ?>
                </div>

                <div class="col-md-4">
                    <strong>Téléphone :</strong>
                        <?php echo $this->escape($auteur['telephone']); ?>
                </div>

                <div class="col-md-4">
                    <strong>Email :</strong>
                        <?php echo $this->escape($auteur['email']); ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Affichage d’une possible erreur de validation -->
    <?php echo $this->component('messages',['error' => $error,]); ?>

    <!-- Formulaire commun utilisé pour créer un trajet -->
    <?php echo $this->component('trajetForm',['action' => $this->url('/trajets/ajouter'),'submitLabel' => 'Créer le trajet','agences' => $agences,
                                'trajet' => null,]); ?>
</main>