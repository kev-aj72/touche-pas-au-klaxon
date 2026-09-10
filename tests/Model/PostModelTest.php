<?php

declare(strict_types=1);

namespace Tests\Model;

use App\Model\AgenceModel;
use App\Model\PostModel;
use PDO;
use PHPUnit\Framework\TestCase;

/**
 * Vérifie les opérations d’écriture
 * concernant les trajets.
 */
class PostModelTest extends TestCase {
    private PostModel $postModel;
    private AgenceModel $agenceModel;
    private int $idEmploye;
    private int $idAgenceDepart;
    private int $idAgenceArrivee;

    /**
     * Crée les données nécessaires avant chaque test.
     */
    protected function setUp(): void {
        $this->postModel = new PostModel();
        $this->agenceModel = new AgenceModel();
        $this->removeTestData();
        $this->createTestData();
    }

    /**
     * Supprime les données créées après chaque test.
     */
    protected function tearDown(): void{
        $this->removeTestData();
    }

    /**
     * Vérifie la création d’un trajet.
     */
    public function testCreateTrajet(): void {
        $result = $this->createTrajet();
        $trajet = $this->getTestTrajet();
        $this->assertTrue($result);
        $this->assertIsArray($trajet);
        $this->assertSame(4,(int) $trajet['nombre_places_total']);
        $this->assertSame(3,(int) $trajet['nombre_places_disponibles']);
    }

    /**
     * Vérifie la modification d’un trajet.
     */
    public function testUpdateTrajet(): void{
        $this->createTrajet();
        $trajet = $this->getTestTrajet();
        $this->assertIsArray($trajet);
        $idTrajet = (int) $trajet['id_trajet'];
        $dateDepart = date('Y-m-d H:i:s',strtotime('+2 days'));
        $dateArrivee = date('Y-m-d H:i:s',strtotime('+2 days +3 hours'));
        $result = $this->postModel->updateTrajet($idTrajet, $this->idEmploye, $this->idAgenceArrivee,
                  $this->idAgenceDepart, $dateDepart, $dateArrivee, 5, 2);
        $trajetModifie = $this->postModel->getTrajetByIdAndEmploye($idTrajet, $this->idEmploye);
        $this->assertTrue($result);
        $this->assertIsArray($trajetModifie);
        $this->assertSame(5, (int) $trajetModifie['nombre_places_total']);
        $this->assertSame(2, (int) $trajetModifie['nombre_places_disponibles']);
    }

    /**
     * Vérifie la suppression d’un trajet.
     */
    public function testDeleteTrajet(): void {
        $this->createTrajet();
        $trajet = $this->getTestTrajet();
        $this->assertIsArray($trajet);
        $idTrajet = (int) $trajet['id_trajet'];
        $result = $this->postModel->deleteTrajet($idTrajet, $this->idEmploye);
        $trajetSupprime = $this->postModel->getTrajetByIdAndEmploye($idTrajet, $this->idEmploye);
        $this->assertTrue($result);
        $this->assertFalse($trajetSupprime);
    }

    /**
     * Crée un trajet de démonstration.
     */
    private function createTrajet(): bool {
        $dateDepart = date('Y-m-d H:i:s', strtotime('+1 day'));
        $dateArrivee = date('Y-m-d H:i:s', strtotime('+1 day +2 hours'));
        return $this->postModel->createTrajet($this-> idEmploye, $this->idAgenceDepart, 
               $this->idAgenceArrivee, $dateDepart, $dateArrivee, 4, 3);
    }

    /**
     * Crée l’employé et les agences de test.
     */
    private function createTestData(): void {
        $bdd = \connection();
        $query = $bdd->prepare('INSERT INTO employes (nom, prenom, telephone, email, mot_de_passe, role)
                                VALUES (:nom, :prenom, :telephone, :email, :mot_de_passe, :role)');
        $query->execute(['nom' => 'PHPUnit','prenom' => 'Test','telephone' => '0600000000','email' => 'phpunit.test@email.fr',
                         'mot_de_passe' => password_hash('Test-password',PASSWORD_DEFAULT), 'role' => 'USER',]);
        $this->idEmploye = (int) $bdd->lastInsertId();
        $this->agenceModel-> createAgence('Agence PHPUnit départ');
        $this->agenceModel-> createAgence('Agence PHPUnit arrivée');
        $agenceDepart = $this->agenceModel->getAgenceByVille('Agence PHPUnit départ');
        $agenceArrivee = $this->agenceModel->getAgenceByVille('Agence PHPUnit arrivée');
        $this->assertIsArray($agenceDepart);
        $this->assertIsArray($agenceArrivee);
        $this->idAgenceDepart = (int) $agenceDepart['id_agence'];
        $this->idAgenceArrivee = (int) $agenceArrivee['id_agence'];
    }

    /**
     * Récupère le trajet créé par PHPUnit.
     *
     * @return array<string, mixed>|false
     */
    private function getTestTrajet(): array|false {
        $bdd = \connection();
        $query = $bdd->prepare('SELECT * FROM trajets WHERE id_employe = :id_employe LIMIT 1');
        $query->execute(['id_employe' => $this->idEmploye,]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Supprime uniquement les données PHPUnit.
     */
    private function removeTestData(): void {
        $bdd = \connection();
        $query = $bdd->prepare('DELETE FROM trajets WHERE id_employe IN ( SELECT id_employe FROM employes WHERE email = :email)' );
        $query->execute(['email' => 'phpunit.test@email.fr',]);
        $query = $bdd->prepare('DELETE FROM employes WHERE email = :email');
        $query->execute(['email' => 'phpunit.test@email.fr',]);
        $query = $bdd->prepare('DELETE FROM agences WHERE ville LIKE :ville');
        $query->execute(['ville' => 'Agence PHPUnit%',]);
    }
}