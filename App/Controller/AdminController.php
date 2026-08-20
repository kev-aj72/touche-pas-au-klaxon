<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\AgenceModel;
use App\Model\PostModel;
use App\Model\UserModel;
use Core\DefaultController;
use Core\Traits\TrajetFormatterTrait;

class AdminController extends DefaultController
{
    use TrajetFormatterTrait;

    public function __construct(
        private AgenceModel $agenceModel =
            new AgenceModel(),

        private PostModel $postModel =
            new PostModel(),

        private UserModel $userModel =
            new UserModel()
    ) {
    }

    public function index(): string
    {
        $this->requireAdmin();

        return $this->render('admin/dashboard');
    }

    public function employes(): string
    {
        $this->requireAdmin();

        $employesAffiches = [];

        foreach ($this->userModel->getEmployes() as $employe) {
            $employesAffiches[] = [
                'nom' => $this->escape($employe['nom']),
                'prenom' => $this->escape($employe['prenom']),
                'telephone' =>
                    $this->escape($employe['telephone']),
                'email' => $this->escape($employe['email']),
                'role' => $this->escape($employe['role']),
            ];
        }

        return $this->render(
            'admin/employes',
            ['employesAffiches' => $employesAffiches]
        );
    }

    public function agences(): string
    {
        $this->requireAdmin();

        $agencesAffichees = [];

        foreach ($this->agenceModel->getAgences() as $agence) {
            $agencesAffichees[] = [
                'id_agence' => (int) $agence['id_agence'],
                'ville' => $this->escape($agence['ville']),
            ];
        }

        [$messageSucces, $messageErreur] =
            $this->pullFlashMessages();

        return $this->render(
            'admin/agences',
            [
                'agencesAffichees' => $agencesAffichees,
                'messageSucces' => $messageSucces,
                'messageErreur' => $messageErreur,
            ]
        );
    }

    public function storeAgence(): void
    {
        $this->requireAdmin();

        $this->saveAgence();
    }

    public function editAgence(int $id): string
    {
        $this->requireAdmin();

        $agence = $this->agenceModel->getAgenceById($id);

        if ($agence === false) {
            http_response_code(404);

            return 'Agence introuvable.';
        }

        return $this->render(
            'admin/editAgence',
            [
                'agenceAffichee' => [
                    'id_agence' =>
                        (int) $agence['id_agence'],

                    'ville' =>
                        $this->escape($agence['ville']),
                ],
            ]
        );
    }

    public function updateAgence(int $id): void
    {
        $this->requireAdmin();

        if (
            $this->agenceModel->getAgenceById($id)
            === false
        ) {
            http_response_code(404);

            exit('Agence introuvable.');
        }

        $this->saveAgence($id);
    }

    public function deleteAgence(int $id): void
    {
        $this->requireAdmin();

        $agence = $this->agenceModel->getAgenceById($id);

        if ($agence === false) {
            $this->flash(
                'error',
                'Agence introuvable.'
            );
        } elseif ($this->agenceModel->isAgenceUsed($id)) {
            $this->flash(
                'error',
                'Cette agence ne peut pas être supprimée '
                    . 'car elle est utilisée par un trajet.'
            );
        } else {
            $this->agenceModel->deleteAgence($id);

            $this->flash(
                'success',
                'L’agence a bien été supprimée.'
            );
        }

        $this->redirect('/admin/agences');
    }

    public function trajets(): string
    {
        $this->requireAdmin();

        $trajetsAffiches = $this->formatTrajets(
            $this->postModel->getAllTrajets()
        );

        [$messageSucces, $messageErreur] =
            $this->pullFlashMessages();

        return $this->render(
            'admin/trajets',
            [
                'trajetsAffiches' => $trajetsAffiches,
                'messageSucces' => $messageSucces,
                'messageErreur' => $messageErreur,
            ]
        );
    }

    public function deleteTrajet(int $id): void
    {
        $this->requireAdmin();

        if ($this->postModel->getTrajetById($id) === false) {
            $this->flash(
                'error',
                'Trajet introuvable.'
            );
        } else {
            $this->postModel->deleteTrajetAdmin($id);

            $this->flash(
                'success',
                'Le trajet a bien été supprimé.'
            );
        }

        $this->redirect('/admin/trajets');
    }

    /**
     * Crée ou modifie une agence.
     */
    private function saveAgence(
        ?int $idAgence = null
    ): never {
        $ville = trim($_POST['ville'] ?? '');

        $error = $this->validateVille(
            $ville,
            $idAgence
        );

        if ($error !== null) {
            $this->flash('error', $error);
        } elseif ($idAgence === null) {
            $this->agenceModel->createAgence($ville);

            $this->flash(
                'success',
                'L’agence a bien été créée.'
            );
        } else {
            $this->agenceModel->updateAgence(
                $idAgence,
                $ville
            );

            $this->flash(
                'success',
                'L’agence a bien été modifiée.'
            );
        }

        $this->redirect('/admin/agences');
    }

    private function validateVille(
        string $ville,
        ?int $idAgence = null
    ): ?string {
        if ($ville === '') {
            return 'Le nom de la ville est obligatoire.';
        }

        if (mb_strlen($ville) > 100) {
            return 'Le nom de la ville ne peut pas dépasser '
                . '100 caractères.';
        }

        $agence =
            $this->agenceModel->getAgenceByVille($ville);

        if (
            $agence !== false
            && (int) $agence['id_agence'] !== $idAgence
        ) {
            return 'Une agence utilise déjà ce nom.';
        }

        return null;
    }
}