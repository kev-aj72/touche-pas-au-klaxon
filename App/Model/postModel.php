<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Core/DefaultModel.php';

function getTrajets(): array
{
    return findAll(
        "SELECT
            trajets.id_trajet,
            trajets.date_heure_depart,
            trajets.date_heure_arrivee,
            trajets.nombre_places_total,
            trajets.nombre_places_disponibles,
            agence_depart.ville AS ville_depart,
            agence_arrivee.ville AS ville_arrivee,
            employes.nom AS conducteur_nom,
            employes.prenom AS conducteur_prenom
        FROM trajets
        INNER JOIN agences AS agence_depart
            ON trajets.id_agence_depart = agence_depart.id_agence
        INNER JOIN agences AS agence_arrivee
            ON trajets.id_agence_arrivee = agence_arrivee.id_agence
        INNER JOIN employes
            ON trajets.id_employe = employes.id_employe
        WHERE trajets.nombre_places_disponibles > 0
        AND trajets.date_heure_depart >= NOW()
        ORDER BY trajets.date_heure_depart ASC"
    );
}
?>