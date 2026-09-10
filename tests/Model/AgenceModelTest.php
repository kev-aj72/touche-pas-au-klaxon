<?php

declare(strict_types=1);

namespace Tests\Model;

use App\Model\AgenceModel;
use PHPUnit\Framework\TestCase;

/**
 * Vérifie les opérations d’écriture
 * concernant les agences.
 */
class AgenceModelTest extends TestCase {
    private AgenceModel $agenceModel;

    /**
     * Prépare le modèle avant chaque test.
     */
    protected function setUp(): void{
        $this->agenceModel = new AgenceModel();
        $this->removeTestAgences();
    }

    /**
     * Nettoie les données après chaque test.
     */
    protected function tearDown(): void{
        $this->removeTestAgences();
    }

    /**
     * Vérifie la création d’une agence.
     */
    public function testCreateAgence(): void{
        $result = $this->agenceModel->createAgence('Ville PHPUnit création');
        $agence = $this->agenceModel->getAgenceByVille('Ville PHPUnit création');
        $this->assertTrue($result);
        $this->assertIsArray($agence);
        $this->assertSame('Ville PHPUnit création',$agence['ville']);
    }

    /**
     * Vérifie la modification d’une agence.
     */
    public function testUpdateAgence(): void {
        $this->agenceModel->createAgence('Ville PHPUnit ancienne');
        $agence = $this->agenceModel->getAgenceByVille('Ville PHPUnit ancienne');
        $this->assertIsArray($agence);
        $idAgence = (int) $agence['id_agence'];
        $result = $this->agenceModel->updateAgence($idAgence,'Ville PHPUnit nouvelle');
        $agenceModifiee = $this->agenceModel->getAgenceById($idAgence);

        $this->assertTrue($result);
        $this->assertIsArray($agenceModifiee);
        $this->assertSame('Ville PHPUnit nouvelle', $agenceModifiee['ville']);
    }

    /**
     * Vérifie la suppression d’une agence.
     */
    public function testDeleteAgence(): void {
        $this->agenceModel->createAgence('Ville PHPUnit suppression');
        $agence = $this->agenceModel->getAgenceByVille('Ville PHPUnit suppression');
        $this->assertIsArray($agence);

        $idAgence = (int) $agence['id_agence'];
        $result = $this->agenceModel->deleteAgence($idAgence);
        $agenceSupprimee = $this->agenceModel->getAgenceById($idAgence);

        $this->assertTrue($result);
        $this->assertFalse($agenceSupprimee);
    }

    /**
     * Supprime uniquement les agences créées
     * par PHPUnit.
     */
    private function removeTestAgences(): void {
        $bdd = \connection();
        $query = $bdd->prepare('DELETE FROM agences WHERE ville LIKE :ville');
        $query->execute(['ville' => 'Ville PHPUnit%',]);
    }
}