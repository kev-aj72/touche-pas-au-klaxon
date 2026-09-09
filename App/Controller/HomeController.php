<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\PostModel;
use Core\DefaultController;
use Core\Traits\TrajetFormatterTrait;

/**
 * Gère l’affichage de la page d’accueil.
 */
class HomeController extends DefaultController {
    use TrajetFormatterTrait;

    /**
     * Initialise le contrôleur.
     *
     * @param PostModel $postModel Modèle des trajets.
     */

    public function __construct(private PostModel $postModel = new PostModel()) {
    }

    /**
     * Affiche les trajets futurs qui possèdent
     * encore des places disponibles.
     *
     * @return string Contenu HTML de la page d’accueil.
     */
    
    public function index(): string {

        $utilisateur = $_SESSION['user'] ?? null;
        $trajetsAffiches = [];

        foreach ($this->postModel->getTrajets() as $trajet) {
            
            $trajetAffiche = $this->formatTrajet($trajet,'contact');
            $trajetAffiche['telephone'] = $this->escape($trajet['auteur_telephone']);
            $trajetAffiche['email'] = $this->escape($trajet['auteur_email']);
            $trajetAffiche['est_auteur'] = $utilisateur !== null && (int) $trajet['id_employe'] === (int) $utilisateur['id_employe'];
            $trajetsAffiches[] = $trajetAffiche;
        }

        $nomUtilisateur = $utilisateur !== null ? $this->escape($utilisateur['prenom'] . ' ' . $utilisateur['nom']): null;

        return $this->render('home',['trajetsAffiches' =>$trajetsAffiches,
                                     'utilisateurConnecte' =>$utilisateur,
                                     'nomUtilisateur' =>$nomUtilisateur,
                                     'messageSucces' =>$this->pullFlash('success'),]
        );
    }
}