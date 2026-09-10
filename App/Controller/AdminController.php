<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\AgenceModel;
use App\Model\PostModel;
use App\Model\UserModel;
use Core\DefaultController;
use Core\Traits\TrajetFormatterTrait;

/**
 * Gère les fonctionnalités réservées
 * aux administrateurs.
 */
class AdminController extends DefaultController {
    
    use TrajetFormatterTrait;

    /**
     * Modèle des agences.
     */
    private AgenceModel $agenceModel;

    /**
     * Modèle des trajets.
     */
    private PostModel $postModel;

    /**
     * Modèle des utilisateurs.
     */
    private UserModel $userModel;

    /**
     * Initialise les modèles nécessaires.
     */
    public function __construct() {

        $this->agenceModel = new AgenceModel();
        $this->postModel = new PostModel();
        $this->userModel = new UserModel();
    }

    /**
     * Affiche le tableau de bord administrateur.
     *
     * @return string Contenu HTML du tableau de bord.
     */
    public function index(): string {
    $this->requireAdmin();
    return $this->renderTrajetsPage('admin/dashboard');
}
    /**
     * Affiche la liste des employés.
     *
     * @return string Contenu HTML de la liste.
     */
    public function employes(): string {

        $this->requireAdmin();
        $employesAffiches = [];

        foreach ($this->userModel->getEmployes()as $employe) {

            $employesAffiches[] = ['nom' =>$this->escape($employe['nom']),
                                   'prenom' =>$this->escape($employe['prenom']),
                                   'telephone' =>$this->escape($employe['telephone']),
                                   'email' =>$this->escape($employe['email']),
                                   'role' =>$this->escape($employe['role']),];
        }
        return $this->render('admin/employes',['employesAffiches' =>$employesAffiches,]);
    }

    /**
     * Affiche la liste et le formulaire
     * de création des agences.
     *
     * @return string Contenu HTML de la page.
     */
    public function agences(): string {

        $this->requireAdmin();
        $agencesAffichees = [];

        foreach ($this->agenceModel->getAgences()as $agence) {
            $agencesAffichees[] = ['id_agence' =>(int) $agence['id_agence'],
                                   'ville' =>$this->escape($agence['ville']),];
        }
        [$messageSucces, $messageErreur] = $this->pullFlashMessages();

        return $this->render('admin/agences',['agencesAffichees' =>$agencesAffichees,
                                              'messageSucces' =>$messageSucces,
                                              'messageErreur' =>$messageErreur,]);
    }

    /**
     * Enregistre une nouvelle agence.
     *
     * @return void
     */
    public function storeAgence(): void {

        $this->requireAdmin();
        $this->requireValidCsrfToken();
        $this->saveAgence();
    }

    /**
     * Affiche le formulaire de modification
     * d’une agence.
     *
     * @param int $id Identifiant de l’agence.
     * @return string Contenu HTML du formulaire.
     */
    public function editAgence(int $id): string {

        $this->requireAdmin();
        $agence =$this->agenceModel->getAgenceById($id);

        if ($agence === false) {
            http_response_code(404);
            return 'Agence introuvable.';
        }
        return $this->render('admin/editAgence',['agenceAffichee' => ['id_agence' =>(int) $agence['id_agence'],
                                                 'ville' => $this->escape($agence['ville']),],]);
    }

    /**
     * Enregistre la modification d’une agence.
     *
     * @param int $id Identifiant de l’agence.
     * @return void
     */
    public function updateAgence(int $id): void {

        $this->requireAdmin();
        $this->requireValidCsrfToken();
        if ($this->agenceModel->getAgenceById($id) === false) {
            http_response_code(404);
            exit('Agence introuvable.');
        }
        $this->saveAgence($id);
    }

    /**
     * Supprime une agence si elle n’est utilisée
     * par aucun trajet.
     *
     * @param int $id Identifiant de l’agence.
     * @return void
     */
    public function deleteAgence(int $id): void {

        $this->requireAdmin();
        $this->requireValidCsrfToken();
        $agence = $this->agenceModel->getAgenceById($id);

        if ($agence === false) {
            $this->flash('error','Agence introuvable.');
        } elseif ($this->agenceModel->isAgenceUsed($id)) {
            $this->flash('error','Cette agence ne peut pas être supprimée car elle est utilisée par un trajet.');
        } else {
            $this->agenceModel->deleteAgence($id);
            $this->flash('success','L’agence a bien été supprimée.');
        }
        $this->redirect('/admin/agences');
    }

    /**
     * Affiche la liste de tous les trajets.
     *
     * @return string Contenu HTML de la liste.
     */
    public function trajets(): string {
    $this->requireAdmin();
    return $this->renderTrajetsPage('admin/trajets');
}

    /**
     * Supprime un trajet depuis l’administration.
     *
     * @param int $id Identifiant du trajet.
     * @return void
     */
    public function deleteTrajet(int $id): void {

        $this->requireAdmin();
        $this->requireValidCsrfToken();

        if ($this->postModel->getTrajetById($id) === false) {
                $this->flash('error','Trajet introuvable.');
        } else {
            $this->postModel->deleteTrajetAdmin($id);
            $this->flash('success','Le trajet a bien été supprimé.');
        }
        $this->redirect('/admin/trajets');
    }

    /**
     * Crée ou modifie une agence,
     * puis redirige vers la liste.
     *
     * @param int|null $idAgence Identifiant
     * de l’agence à modifier.
     *
     * @return never
     */
    private function saveAgence(?int $idAgence = null): never {
       
        $ville = trim($_POST['ville'] ?? '');
        $error = $this->validateVille($ville,$idAgence );
        if ($error !== null) {
            $this->flash('error',$error);
        } elseif ($idAgence === null) {
            $this->agenceModel->createAgence($ville);
            $this->flash('success','L’agence a bien été créée.');
        } else {
            $this->agenceModel->updateAgence($idAgence,$ville);
            $this->flash('success','L’agence a bien été modifier.');
        }
        $this->redirect('/admin/agences');
    }

    /**
     * Vérifie le nom saisi pour une agence.
     *
     * @param string $ville Nom de la ville.
     * @param int|null $idAgence Identifiant
     * de l’agence actuellement modifiée.
     *
     * @return string|null Message d’erreur ou null.
     */
    private function validateVille(string $ville,?int $idAgence = null): ?string {
        if ($ville === '') {
             return 'Le nom de la ville est obligatoire.';
        }

        if (mb_strlen($ville) > 100) {
            return 'Le nom de la ville ne peut pas dépasser 100 caractères.';
        }
        $agence = $this->agenceModel->getAgenceByVille($ville);

        if ($agence !== false && (int) $agence['id_agence'] !== $idAgence) {
            return 'Une agence utilise déjà ce nom.';
        }
        return null;
    }

    /**
 * Prépare les trajets et affiche la page demandée.
 *
 * @param string $template Template à afficher.
 * @return string Contenu HTML de la page.
 */
private function renderTrajetsPage(string $template): string {
    $trajetsAffiches = [];
    foreach ($this->postModel->getAllTrajets() as $trajet) {
        $trajetAffiche = $this->formatTrajet($trajet,'contact');
        $trajetAffiche['telephone'] = $this->escape($trajet['auteur_telephone']);
        $trajetAffiche['email'] = $this->escape($trajet['auteur_email']);
        $trajetAffiche['est_auteur'] = (int) $trajet['id_employe'] === (int) $_SESSION['user']['id_employe'];
        $trajetsAffiches[] = $trajetAffiche;
    }
    [$messageSucces, $messageErreur,] = $this->pullFlashMessages();

    return $this->render($template,['trajetsAffiches' => $trajetsAffiches,'messageSucces' => $messageSucces,'messageErreur' => $messageErreur,]);
    }
}
?>