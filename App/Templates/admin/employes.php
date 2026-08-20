<?php

/** @var array $employesAffiches */

?>

<h1>Liste des employés</h1>

<?php if ($employesAffiches === []): ?>
    <p>Aucun employé trouvé.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Rôle</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($employesAffiches as $employe): ?>
                <tr>
                    <td><?= $employe['nom'] ?></td>
                    <td><?= $employe['prenom'] ?></td>
                    <td><?= $employe['telephone'] ?></td>
                    <td><?= $employe['email'] ?></td>
                    <td><?= $employe['role'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<p>
    <a href="/touche-pas-au-klaxon/public/admin">
        Retour à l’administration
    </a>
</p>