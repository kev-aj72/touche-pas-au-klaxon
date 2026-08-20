<?php

declare(strict_types=1);

namespace App\Controller;

use DateTimeImmutable;

require_once __DIR__ . '/../Model/userModel.php';
require_once __DIR__ . '/../Model/agenceModel.php';
require_once __DIR__ . '/../Model/postModel.php';

class AdminController
{
    /**
     * Affiche le tableau de bord administrateur.
     */
    public function index(): string
    {
        $this->requireAdmin();

        ob_start();

        require dirname(__DIR__)
            . '/Templates/admin/dashboard.php';

        return (string) ob_get_clean();
    }

    /**
     * Affiche la liste des employés.
     */
    public function employes(): string
    {
        $this->requireAdmin();

        $employes = \getEmployes();
        $employesAffiches = [];

        foreach ($employes as $employe) {
            $employesAffiches[] = [
                'nom' => htmlspecialchars(
                    $employe['nom'],
                    ENT_QUOTES,
                    'UTF-8'
                ),

                'prenom' => htmlspecialchars(
                    $employe['prenom'],
                    ENT_QUOTES,
                    'UTF-8'
                ),

                'telephone' => htmlspecialchars(
                    $employe['telephone'],
                    ENT_QUOTES,
                    'UTF-8'
                ),

                'email' => htmlspecialchars(
                    $employe['email'],
                    ENT_QUOTES,
                    'UTF-8'
                ),

                'role' => htmlspecialchars(
                    $employe['role'],
                    ENT_QUOTES,
                    'UTF-8'
                ),
            ];
        }

        ob_start();

        require dirname(__DIR__)
            . '/Templates/admin/employes.php';

        return (string) ob_get_clean();
    }
    /**
 * Affiche la liste des agences.
 */
public function agences(): string
{
    $this->requireAdmin();

    $agences = \getAgences();
    $agencesAffichees = [];

    foreach ($agences as $agence) {
        $agencesAffichees[] = [
            'id_agence' => (int) $agence['id_agence'],

            'ville' => htmlspecialchars(
                $agence['ville'],
                ENT_QUOTES,
                'UTF-8'
            ),
        ];
    }

$messageSucces = $_SESSION['success'] ?? null;
$messageErreur = $_SESSION['error'] ?? null;

if ($messageSucces !== null) {
    $messageSucces = htmlspecialchars(
        $messageSucces,
        ENT_QUOTES,
        'UTF-8'
    );
}

if ($messageErreur !== null) {
    $messageErreur = htmlspecialchars(
        $messageErreur,
        ENT_QUOTES,
        'UTF-8'
    );
}

unset(
    $_SESSION['success'],
    $_SESSION['error']
);

    ob_start();

    require dirname(__DIR__)
        . '/Templates/admin/agences.php';

    return (string) ob_get_clean();
}

/**
 * Enregistre une nouvelle agence.
 */
public function storeAgence(): void
{
    $this->requireAdmin();

    $ville = trim($_POST['ville'] ?? '');

    if ($ville === '') {
        $_SESSION['error'] = 'Le nom de la ville est obligatoire.';
    } elseif (mb_strlen($ville) > 100) {
        $_SESSION['error'] =
            'Le nom de la ville ne peut pas dépasser 100 caractères.';
    } elseif (\getAgenceByVille($ville) !== false) {
        $_SESSION['error'] = 'Cette agence existe déjà.';
    } else {
        \createAgence($ville);

        $_SESSION['success'] = 'L’agence a bien été créée.';
    }

    header(
        'Location: /touche-pas-au-klaxon/public/admin/agences'
    );

    exit;
}

/**
 * Affiche le formulaire de modification d’une agence.
 */
public function editAgence(int $id): string
{
    $this->requireAdmin();

    $agence = \getAgenceById($id);

    if ($agence === false) {
        http_response_code(404);

        return 'Agence introuvable.';
    }

    $agenceAffichee = [
        'id_agence' => (int) $agence['id_agence'],

        'ville' => htmlspecialchars(
            $agence['ville'],
            ENT_QUOTES,
            'UTF-8'
        ),
    ];

    ob_start();

    require dirname(__DIR__)
        . '/Templates/admin/editAgence.php';

    return (string) ob_get_clean();
}

/**
 * Enregistre la modification d’une agence.
 */
public function updateAgence(int $id): void
{
    $this->requireAdmin();

    $agence = \getAgenceById($id);

    if ($agence === false) {
        http_response_code(404);

        exit('Agence introuvable.');
    }

    $ville = trim($_POST['ville'] ?? '');
    $agenceExistante = \getAgenceByVille($ville);

    if ($ville === '') {
        $_SESSION['error'] =
            'Le nom de la ville est obligatoire.';
    } elseif (mb_strlen($ville) > 100) {
        $_SESSION['error'] =
            'Le nom de la ville ne peut pas dépasser 100 caractères.';
    } elseif (
        $agenceExistante !== false
        && (int) $agenceExistante['id_agence'] !== $id
    ) {
        $_SESSION['error'] =
            'Une autre agence utilise déjà ce nom.';
    } else {
        \updateAgence($id, $ville);

        $_SESSION['success'] =
            'L’agence a bien été modifiée.';
    }

    header(
        'Location: /touche-pas-au-klaxon/public/admin/agences'
    );

    exit;
}

/**
 * Supprime une agence si elle n’est utilisée par aucun trajet.
 */
public function deleteAgence(int $id): void
{
    $this->requireAdmin();

    $agence = \getAgenceById($id);

    if ($agence === false) {
        $_SESSION['error'] = 'Agence introuvable.';
    } elseif (\isAgenceUsed($id)) {
        $_SESSION['error'] =
            'Cette agence ne peut pas être supprimée car elle est utilisée par un trajet.';
    } else {
        \deleteAgence($id);

        $_SESSION['success'] =
            'L’agence a bien été supprimée.';
    }

    header(
        'Location: /touche-pas-au-klaxon/public/admin/agences'
    );

    exit;
}

/**
 * Affiche tous les trajets.
 */
public function trajets(): string
{
    $this->requireAdmin();

    $trajets = \getAllTrajets();
    $trajetsAffiches = [];

    foreach ($trajets as $trajet) {
        $trajetsAffiches[] = [
            'id_trajet' => (int) $trajet['id_trajet'],

            'ville_depart' => htmlspecialchars(
                $trajet['ville_depart'],
                ENT_QUOTES,
                'UTF-8'
            ),

            'ville_arrivee' => htmlspecialchars(
                $trajet['ville_arrivee'],
                ENT_QUOTES,
                'UTF-8'
            ),

            'date_depart' => (
                new DateTimeImmutable(
                    $trajet['date_heure_depart']
                )
            )->format('d/m/Y à H:i'),

            'date_arrivee' => (
                new DateTimeImmutable(
                    $trajet['date_heure_arrivee']
                )
            )->format('d/m/Y à H:i'),

            'places_total' =>
                (int) $trajet['nombre_places_total'],

            'places_disponibles' =>
                (int) $trajet['nombre_places_disponibles'],

            'auteur' => htmlspecialchars(
                $trajet['auteur_prenom']
                    . ' '
                    . $trajet['auteur_nom'],
                ENT_QUOTES,
                'UTF-8'
            ),
        ];
    }

    $messageSucces = $_SESSION['success'] ?? null;
    $messageErreur = $_SESSION['error'] ?? null;

    unset(
        $_SESSION['success'],
        $_SESSION['error']
    );

    ob_start();

    require dirname(__DIR__)
        . '/Templates/admin/trajets.php';

    return (string) ob_get_clean();
}

/**
 * Permet à l’administrateur de supprimer n’importe quel trajet.
 */
public function deleteTrajet(int $id): void
{
    $this->requireAdmin();

    $trajet = \getTrajetById($id);

    if ($trajet === false) {
        $_SESSION['error'] = 'Trajet introuvable.';
    } else {
        \deleteTrajetAdmin($id);

        $_SESSION['success'] =
            'Le trajet a bien été supprimé.';
    }

    header(
        'Location: /touche-pas-au-klaxon/public/admin/trajets'
    );

    exit;
}
    /**
     * Vérifie que l’utilisateur est administrateur.
     */
    private function requireAdmin(): void
    {
        if (
            !isset($_SESSION['user'])
            || $_SESSION['user']['role'] !== 'ADMIN'
        ) {
            http_response_code(403);

            exit('Accès interdit.');
        }
    }
}