<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\AgenceModel;
use App\Model\PostModel;
use Core\DefaultController;

/**
 * Gère la création, la modification
 * et la suppression des trajets.
 */

class TrajetController extends DefaultController {
    /**
     * Modèle permettant d’accéder aux agences.
     */

    private AgenceModel $agenceModel;

    /**
     * Modèle permettant d’accéder aux trajets.
     */

    private PostModel $postModel;

    /**
     * Initialise les modèles.
     */

    public function __construct() {
        $this->agenceModel = new AgenceModel();
        $this->postModel = new PostModel();
    }

    /**
     * Affiche le formulaire de création d’un trajet.
     *
     * @return string Contenu HTML du formulaire.
     */

    public function create(): string {
        $this->requireLogin();
        return $this->renderForm();
    }

    /**
     * Enregistre un nouveau trajet.
     *
     * @return string Contenu HTML en cas d’erreur.
     */
    public function store(): string {

        $this->requireLogin();
        $this->requireValidCsrfToken();
        $data = $this->getValidatedData();

        if (is_string($data)) {
            return $this->renderForm($data);
        }
        $this->saveTrajet($data);
        $this->flash('success','Le trajet a bien été créé.');
        $this->redirect('/');
    }

    /**
     * Affiche le formulaire de modification
     * d’un trajet appartenant à l’utilisateur.
     *
     * @param int $id Identifiant du trajet.
     * @return string Contenu HTML du formulaire.
     */

    public function edit(int $id): string {

        $this->requireLogin();
        $trajet = $this->getUserTrajet($id);
        if ($trajet === false) {
            http_response_code(403);
            return 'Vous ne pouvez pas modifier ce trajet.';
        }

        return $this->render('editTrajet',['trajet' =>$trajet,
                                           'agences' =>$this->agenceModel->getAgences(),]);
    }

    /**
     * Enregistre les modifications d’un trajet.
     *
     * @param int $id Identifiant du trajet.
     * @return string Message en cas d’erreur.
     */

    public function update(int $id): string {

        $this->requireLogin();
        $this->requireValidCsrfToken();

        if ($this->getUserTrajet($id) === false) {
            http_response_code(403);
            return 'Vous ne pouvez pas modifier ce trajet.';
        }

        $data = $this->getValidatedData();

        if (is_string($data)) {
            return $data;
        }

        $this->saveTrajet($data, $id);
        $this->flash('success','Le trajet a bien été modifié.');
        $this->redirect('/');
    }

    /**
     * Supprime un trajet appartenant
     * à l’utilisateur connecté.
     *
     * @param int $id Identifiant du trajet.
     * @return string Message en cas d’erreur.
     */

    public function delete(int $id): string {

        $this->requireLogin();
        $this->requireValidCsrfToken();

        if ($this->getUserTrajet($id) === false) {
            http_response_code(403);
            return 'Vous ne pouvez pas supprimer ce trajet.';
        }

        $this->postModel->deleteTrajet($id, $this->getUserId());
        $this->flash('success','Le trajet a bien été supprimé.');
        $this->redirect('/');
    }

    /**
     * Récupère et valide les données envoyées
     * par le formulaire d’un trajet.
     *
     * @return array<string, int|string|false>|string
     * Données validées ou message d’erreur.
     */

    private function getValidatedData(): array|string {

        $dateDepart = trim($_POST['date_heure_depart'] ?? '' );
        $dateArrivee = trim($_POST['date_heure_arrivee'] ?? '' );
        $data = ['id_agence_depart' => (int) ($_POST['id_agence_depart'] ?? 0),
                 'id_agence_arrivee' => (int) ($_POST['id_agence_arrivee'] ?? 0),
                 'date_depart' => $dateDepart,
                 'date_arrivee' =>$dateArrivee,
                 'depart_timestamp' =>strtotime($dateDepart),
                 'arrivee_timestamp' =>strtotime($dateArrivee),
                 'nombre_places_total' => (int) ($_POST['nombre_places_total'] ?? 0),
                 'nombre_places_disponibles' => (int) ($_POST['nombre_places_disponibles'] ?? -1)];

            return $this->validateTrajet($data) ?? $data;
    }

    /**
     * Vérifie la cohérence des données
     * saisies pour un trajet.
     *
     * @param array<string, int|string|false> $data
     * Données du trajet.
     *
     * @return string|null Message d’erreur ou null.
     */

    private function validateTrajet(
        array $data): ?string {
        if (
            $data['id_agence_depart'] <= 0
            || $data['id_agence_arrivee'] <= 0
            || $data['date_depart'] === ''
            || $data['date_arrivee'] === ''
            || $data['nombre_places_total'] <= 0
            || $data['nombre_places_total'] > 255
            || $data['nombre_places_disponibles'] < 0
            || $data['nombre_places_disponibles'] > 255) {

            return 'Veuillez remplir correctement tous les champs.';
        }

        if ($data['nombre_places_disponibles'] > $data['nombre_places_total']) {
            return 'Le nombre de places disponibles ne peut pas dépasser le nombre total de places.';
        }

        if ($this->agenceModel->getAgenceById($data['id_agence_depart']) === false || $this->agenceModel->getAgenceById($data['id_agence_arrivee']) === false) {
            return 'Une agence sélectionnée n’existe pas.';
        }

        if ($data['id_agence_depart'] === $data['id_agence_arrivee']) {
            return 'Les agences doivent être différentes.';
        }

        if ($data['depart_timestamp'] === false || $data['arrivee_timestamp'] === false) {    
            return 'Les dates saisies sont incorrectes.';
        }

        if ($data['depart_timestamp'] <= time()) {
            return 'Le départ doit être prévu dans le futur.';
        }

        if ($data['arrivee_timestamp'] <= $data['depart_timestamp']) {
            return 'L’arrivée doit être aprés le départ.';
        }

        return null;
    }

    /**
     * Crée ou modifie un trajet validé.
     *
     * @param array<string, int|string|false> $data
     * Données validées du trajet.
     *
     * @param int|null $idTrajet Identifiant du trajet
     * en cas de modification.
     *
     * @return void
     */
    private function saveTrajet(array $data,?int $idTrajet = null): void {
        $dateDepart = date('Y-m-d H:i:s', $data['depart_timestamp']);
        $dateArrivee = date('Y-m-d H:i:s',$data['arrivee_timestamp']);

        if ($idTrajet === null) {
            $this->postModel->createTrajet(
                $this->getUserId(),
                $data['id_agence_depart'],
                $data['id_agence_arrivee'],
                $dateDepart,
                $dateArrivee,
                $data['nombre_places_total'],
                $data['nombre_places_disponibles']);
            return;
        }
        $this->postModel->updateTrajet(
            $idTrajet,
            $this->getUserId(),
            $data['id_agence_depart'],
            $data['id_agence_arrivee'],
            $dateDepart,
            $dateArrivee,
            $data['nombre_places_total'],
            $data['nombre_places_disponibles']);
    }

    /**
     * Recherche un trajet appartenant
     * à l’utilisateur connecté.
     *
     * @param int $id Identifiant du trajet.
     * @return array|false Trajet trouvé ou false.
     */
    private function getUserTrajet(int $id): array|false {
        return $this->postModel->getTrajetByIdAndEmploye($id,$this->getUserId());
    }

    /**
     * Récupère l’identifiant de l’utilisateur
     * connecté.
     *
     * @return int Identifiant de l’utilisateur.
     */
    private function getUserId(): int {
        return (int) $_SESSION['user']['id_employe'];
    }

    /**
     * Affiche le formulaire de création.
     *
     * @param string|null $error Message d’erreur.
     * @return string Contenu HTML du formulaire.
     */
    private function renderForm(?string $error = null): string {
        return $this->render('createTrajet',['auteur' => $_SESSION['user'],
                                             'agences' => $this->agenceModel->getAgences(),
                                             'error' => $error,]);
    }
}