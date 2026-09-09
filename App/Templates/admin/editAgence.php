<?php

/**
 * Template permettant à l’administrateur
 * de modifier une agence existante.
 */

/** @var array $agenceAffichee Agence à modifier. */

?>

<main class="pb-4">
    <h1 class="h2 mb-4">Modifier une agence</h1>
    <!--
        Réutilisation du formulaire des agences.
        La ville actuelle sera automatiquement affichée.
    -->
    <?php echo $this->component('agenceForm',['action' => $this->url('/admin/agences/'. (int) $agenceAffichee['id_agence']. '/modifier'),
                'submitLabel' => 'Enregistrer les modifications', 'agence' => $agenceAffichee,]);?>
</main>