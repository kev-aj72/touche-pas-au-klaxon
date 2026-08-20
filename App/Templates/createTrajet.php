<?php

/** @var array $agences */
/** @var string|null $error */
/** @var array $auteur */

?>

<h1>Proposer un trajet</h1>

<section>
    <h2>Contact du trajet</h2>

    <p>
        Nom :
        <?= $this->escape(
            $auteur['prenom']
                . ' '
                . $auteur['nom']
        ) ?>
    </p>

    <p>
        Téléphone :
        <?= $this->escape($auteur['telephone']) ?>
    </p>

    <p>
        Email :
        <?= $this->escape($auteur['email']) ?>
    </p>
</section>

<?= $this->component(
    'messages',
    [
        'error' => $error !== null
            ? $this->escape($error)
            : null,
    ]
) ?>

<?= $this->component(
    'trajetForm',
    [
        'action' =>
            '/touche-pas-au-klaxon/public/trajets/ajouter',

        'submitLabel' =>
            'Créer le trajet',

        'agences' =>
            $agences,

        'trajet' =>
            [],
    ]
) ?>