<?php

declare(strict_types=1);

namespace App\Controller;

require_once __DIR__ . '/../Model/agenceModel.php';
require_once __DIR__ . '/../Model/postModel.php';

class TrajetController
{
    /**
     * Affiche le formulaire de création.
     */
    public function create(): string
    {
        $this->requireLogin();

        return $this->renderForm();
    }

    /**
     * Enregistre un nouveau trajet.
     */
    public function store(): string
    {
        $this->requireLogin();

        $idAgenceDepart =
            (int) ($_POST['id_agence_depart'] ?? 0);

        $idAgenceArrivee =
            (int) ($_POST['id_agence_arrivee'] ?? 0);

        $dateDepart =
            trim($_POST['date_heure_depart'] ?? '');

        $dateArrivee =
            trim($_POST['date_heure_arrivee'] ?? '');

        $nombrePlaces =
            (int) ($_POST['nombre_places_total'] ?? 0);

        $agenceDepart = $idAgenceDepart > 0
            ? \getAgenceById($idAgenceDepart)
            : false;

        $agenceArrivee = $idAgenceArrivee > 0
            ? \getAgenceById($idAgenceArrivee)
            : false;

        $departTimestamp = strtotime($dateDepart);
        $arriveeTimestamp = strtotime($dateArrivee);

        if (
            $idAgenceDepart <= 0
            || $idAgenceArrivee <= 0
            || $agenceDepart === false
            || $agenceArrivee === false
            || $dateDepart === ''
            || $dateArrivee === ''
            || $nombrePlaces <= 0
            || $nombrePlaces > 255
        ) {
            return $this->renderForm(
                'Veuillez remplir correctement tous les champs.'
            );
        }

        if ($idAgenceDepart === $idAgenceArrivee) {
            return $this->renderForm(
                'Les agences de départ et d’arrivée doivent être différentes.'
            );
        }

        if (
            $departTimestamp === false
            || $arriveeTimestamp === false
        ) {
            return $this->renderForm(
                'Les dates saisies sont incorrectes.'
            );
        }

        if ($departTimestamp <= time()) {
            return $this->renderForm(
                'Le départ doit être prévu dans le futur.'
            );
        }

        if ($arriveeTimestamp <= $departTimestamp) {
            return $this->renderForm(
                'L’arrivée doit être postérieure au départ.'
            );
        }

        \createTrajet(
            (int) $_SESSION['user']['id_employe'],
            $idAgenceDepart,
            $idAgenceArrivee,
            date('Y-m-d H:i:s', $departTimestamp),
            date('Y-m-d H:i:s', $arriveeTimestamp),
            $nombrePlaces
        );

        $_SESSION['success'] =
            'Le trajet a bien été créé.';

        header(
            'Location: /touche-pas-au-klaxon/public/'
        );

        exit;
    }

    /**
     * Affiche le formulaire de modification.
     */
    public function edit(int $id): string
    {
        $this->requireLogin();

        $trajet = \getTrajetByIdAndEmploye(
            $id,
            (int) $_SESSION['user']['id_employe']
        );

        if ($trajet === false) {
            http_response_code(403);

            return 'Vous ne pouvez pas modifier ce trajet.';
        }

        $agences = \getAgences();

        ob_start();

        require dirname(__DIR__)
            . '/Templates/editTrajet.php';

        return (string) ob_get_clean();
    }

    /**
     * Enregistre la modification d’un trajet.
     */
    public function update(int $id): string
    {
        $this->requireLogin();

        $idEmploye =
            (int) $_SESSION['user']['id_employe'];

        $trajet = \getTrajetByIdAndEmploye(
            $id,
            $idEmploye
        );

        if ($trajet === false) {
            http_response_code(403);

            return 'Vous ne pouvez pas modifier ce trajet.';
        }

        $idAgenceDepart =
            (int) ($_POST['id_agence_depart'] ?? 0);

        $idAgenceArrivee =
            (int) ($_POST['id_agence_arrivee'] ?? 0);

        $dateDepart =
            trim($_POST['date_heure_depart'] ?? '');

        $dateArrivee =
            trim($_POST['date_heure_arrivee'] ?? '');

        $nombrePlaces =
            (int) ($_POST['nombre_places_total'] ?? 0);

        $agenceDepart = $idAgenceDepart > 0
            ? \getAgenceById($idAgenceDepart)
            : false;

        $agenceArrivee = $idAgenceArrivee > 0
            ? \getAgenceById($idAgenceArrivee)
            : false;

        $departTimestamp = strtotime($dateDepart);
        $arriveeTimestamp = strtotime($dateArrivee);

        if (
            $idAgenceDepart <= 0
            || $idAgenceArrivee <= 0
            || $agenceDepart === false
            || $agenceArrivee === false
            || $dateDepart === ''
            || $dateArrivee === ''
            || $nombrePlaces <= 0
            || $nombrePlaces > 255
            || $departTimestamp === false
            || $arriveeTimestamp === false
        ) {
            return 'Les informations du trajet sont incorrectes.';
        }

        if ($idAgenceDepart === $idAgenceArrivee) {
            return 'Les agences doivent être différentes.';
        }

        if ($departTimestamp <= time()) {
            return 'Le départ doit être prévu dans le futur.';
        }

        if ($arriveeTimestamp <= $departTimestamp) {
            return 'L’arrivée doit être postérieure au départ.';
        }

        \updateTrajet(
            $id,
            $idEmploye,
            $idAgenceDepart,
            $idAgenceArrivee,
            date('Y-m-d H:i:s', $departTimestamp),
            date('Y-m-d H:i:s', $arriveeTimestamp),
            $nombrePlaces
        );

        $_SESSION['success'] =
            'Le trajet a bien été modifié.';

        header(
            'Location: /touche-pas-au-klaxon/public/'
        );

        exit;
    }

    /**
     * Supprime un trajet appartenant à l’utilisateur.
     */
    public function delete(int $id): string
    {
        $this->requireLogin();

        $idEmploye =
            (int) $_SESSION['user']['id_employe'];

        $trajet = \getTrajetByIdAndEmploye(
            $id,
            $idEmploye
        );

        if ($trajet === false) {
            http_response_code(403);

            return 'Vous ne pouvez pas supprimer ce trajet.';
        }

        \deleteTrajet(
            $id,
            $idEmploye
        );

        $_SESSION['success'] =
            'Le trajet a bien été supprimé.';

        header(
            'Location: /touche-pas-au-klaxon/public/'
        );

        exit;
    }

    /**
     * Charge le formulaire de création.
     */
    private function renderForm(
        ?string $error = null
    ): string {
        $auteur = $_SESSION['user'];
        $agences = \getAgences();

        ob_start();

        require dirname(__DIR__)
            . '/Templates/createTrajet.php';

        return (string) ob_get_clean();
    }

    /**
     * Refuse l’accès aux visiteurs non connectés.
     */
    private function requireLogin(): void
    {
        if (!isset($_SESSION['user'])) {
            header(
                'Location: /touche-pas-au-klaxon/public/login'
            );

            exit;
        }
    }
}