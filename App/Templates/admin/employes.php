<?php

/**
 * Template affichant la liste des employés.
 *
 * L’administrateur peut consulter les employés,
 * mais ne peut pas les créer, les modifier ou les supprimer.
 */

/** @var array $employesAffiches Liste des employés à afficher. */

?>

<main class="pb-4">
    <h1 class="h2 mb-4">Liste des employés</h1>

    <!-- Message affiché lorsque la liste est vide -->
    <?php if ($employesAffiches === []): ?>
        <p>Aucun employé trouvé.</p>
    <?php else: ?>
        <!-- Tableau de consultation des employés -->
        <div class="table-responsive rounded-4 overflow-hidden">
            <table class="table table-striped table-hover align-middle text-center mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Rôle</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Création d’une ligne pour chaque employé -->
                    <?php foreach ($employesAffiches as $employe): ?>
                        <tr>
                            <td><?php echo $this->escape($employe['nom']);?></td>
                            <td><?php echo $this->escape($employe['prenom']);?></td>
                            <td><?php echo $this->escape($employe['telephone']);?></td>
                            <td><?php echo $this->escape($employe['email']);?></td>
                            <td><span class="badge text-bg-secondary"><?php echo $this->escape($employe['role']);?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>