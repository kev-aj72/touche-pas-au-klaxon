<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\PostModel;
use Core\DefaultController;
use Core\Traits\TrajetFormatterTrait;

class HomeController extends DefaultController
{
    use TrajetFormatterTrait;

    public function __construct(
        private PostModel $postModel =
            new PostModel()
    ) {
    }

    public function index(): string
    {
        $utilisateur = $_SESSION['user'] ?? null;
        $trajetsAffiches = [];

        foreach ($this->postModel->getTrajets() as $trajet) {
            $trajetAffiche =
                $this->formatTrajet(
                    $trajet,
                    'contact'
                );

            $trajetAffiche['telephone'] =
                $this->escape(
                    $trajet['auteur_telephone']
                );

            $trajetAffiche['email'] =
                $this->escape(
                    $trajet['auteur_email']
                );

            $trajetAffiche['est_auteur'] =
                $utilisateur !== null
                && (int) $trajet['id_employe']
                    === (int) $utilisateur['id_employe'];

            $trajetsAffiches[] = $trajetAffiche;
        }

        $nomUtilisateur = $utilisateur !== null
            ? $this->escape(
                $utilisateur['prenom']
                    . ' '
                    . $utilisateur['nom']
            )
            : null;

        return $this->render(
            'home',
            [
                'trajetsAffiches' => $trajetsAffiches,
                'utilisateurConnecte' => $utilisateur,
                'nomUtilisateur' => $nomUtilisateur,
                'messageSucces' =>
                    $this->pullFlash('success'),
            ]
        );
    }
}