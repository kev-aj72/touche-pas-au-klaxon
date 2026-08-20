<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\AgenceModel;
use App\Model\PostModel;
use Core\DefaultController;

class TrajetController extends DefaultController
{
    public function __construct(
        private AgenceModel $agenceModel =
            new AgenceModel(),

        private PostModel $postModel =
            new PostModel()
    ) {
    }

    public function create(): string
    {
        $this->requireLogin();

        return $this->renderForm();
    }

    public function store(): string
    {
        $this->requireLogin();

        $data = $this->getValidatedData();

        if (is_string($data)) {
            return $this->renderForm($data);
        }

        $this->saveTrajet($data);

        $this->flash(
            'success',
            'Le trajet a bien été créé.'
        );

        $this->redirect('/');
    }

    public function edit(int $id): string
    {
        $this->requireLogin();

        $trajet = $this->getUserTrajet($id);

        if ($trajet === false) {
            http_response_code(403);

            return 'Vous ne pouvez pas modifier ce trajet.';
        }

        return $this->render(
            'editTrajet',
            [
                'trajet' => $trajet,
                'agences' =>
                    $this->agenceModel->getAgences(),
            ]
        );
    }

    public function update(int $id): string
    {
        $this->requireLogin();

        if ($this->getUserTrajet($id) === false) {
            http_response_code(403);

            return 'Vous ne pouvez pas modifier ce trajet.';
        }

        $data = $this->getValidatedData();

        if (is_string($data)) {
            return $data;
        }

        $this->saveTrajet($data, $id);

        $this->flash(
            'success',
            'Le trajet a bien été modifié.'
        );

        $this->redirect('/');
    }

    public function delete(int $id): string
    {
        $this->requireLogin();

        if ($this->getUserTrajet($id) === false) {
            http_response_code(403);

            return 'Vous ne pouvez pas supprimer ce trajet.';
        }

        $this->postModel->deleteTrajet(
            $id,
            $this->getUserId()
        );

        $this->flash(
            'success',
            'Le trajet a bien été supprimé.'
        );

        $this->redirect('/');
    }

    /**
     * Récupère et valide les données du formulaire.
     *
     * @return array<string, int|string|false>|string
     */
    private function getValidatedData(): array|string
    {
        $dateDepart =
            trim($_POST['date_heure_depart'] ?? '');

        $dateArrivee =
            trim($_POST['date_heure_arrivee'] ?? '');

        $data = [
            'id_agence_depart' =>
                (int) ($_POST['id_agence_depart'] ?? 0),

            'id_agence_arrivee' =>
                (int) ($_POST['id_agence_arrivee'] ?? 0),

            'date_depart' =>
                $dateDepart,

            'date_arrivee' =>
                $dateArrivee,

            'depart_timestamp' =>
                strtotime($dateDepart),

            'arrivee_timestamp' =>
                strtotime($dateArrivee),

            'nombre_places' =>
                (int) (
                    $_POST['nombre_places_total'] ?? 0
                ),
        ];

        return $this->validateTrajet($data)
            ?? $data;
    }

    /**
     * Vérifie les données d’un trajet.
     */
    private function validateTrajet(
        array $data
    ): ?string {
        if (
            $data['id_agence_depart'] <= 0
            || $data['id_agence_arrivee'] <= 0
            || $data['date_depart'] === ''
            || $data['date_arrivee'] === ''
            || $data['nombre_places'] <= 0
            || $data['nombre_places'] > 255
        ) {
            return 'Veuillez remplir correctement tous les champs.';
        }

        if (
            $this->agenceModel->getAgenceById(
                $data['id_agence_depart']
            ) === false
            || $this->agenceModel->getAgenceById(
                $data['id_agence_arrivee']
            ) === false
        ) {
            return 'Une agence sélectionnée n’existe pas.';
        }

        if (
            $data['id_agence_depart']
            === $data['id_agence_arrivee']
        ) {
            return 'Les agences doivent être différentes.';
        }

        if (
            $data['depart_timestamp'] === false
            || $data['arrivee_timestamp'] === false
        ) {
            return 'Les dates saisies sont incorrectes.';
        }

        if ($data['depart_timestamp'] <= time()) {
            return 'Le départ doit être prévu dans le futur.';
        }

        if (
            $data['arrivee_timestamp']
            <= $data['depart_timestamp']
        ) {
            return 'L’arrivée doit être postérieure au départ.';
        }

        return null;
    }

    /**
     * Crée ou modifie un trajet.
     */
    private function saveTrajet(
        array $data,
        ?int $idTrajet = null
    ): void {
        $dateDepart = date(
            'Y-m-d H:i:s',
            $data['depart_timestamp']
        );

        $dateArrivee = date(
            'Y-m-d H:i:s',
            $data['arrivee_timestamp']
        );

        if ($idTrajet === null) {
            $this->postModel->createTrajet(
                $this->getUserId(),
                $data['id_agence_depart'],
                $data['id_agence_arrivee'],
                $dateDepart,
                $dateArrivee,
                $data['nombre_places']
            );

            return;
        }

        $this->postModel->updateTrajet(
            $idTrajet,
            $this->getUserId(),
            $data['id_agence_depart'],
            $data['id_agence_arrivee'],
            $dateDepart,
            $dateArrivee,
            $data['nombre_places']
        );
    }

    private function getUserTrajet(
        int $id
    ): array|false {
        return $this->postModel
            ->getTrajetByIdAndEmploye(
                $id,
                $this->getUserId()
            );
    }

    private function getUserId(): int
    {
        return (int) $_SESSION['user']['id_employe'];
    }

    private function renderForm(
        ?string $error = null
    ): string {
        return $this->render(
            'createTrajet',
            [
                'auteur' => $_SESSION['user'],

                'agences' =>
                    $this->agenceModel->getAgences(),

                'error' => $error,
            ]
        );
    }
}