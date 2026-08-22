<?php

/** @var array $employesAffiches */

?>

<main class="pb-4">
    <h1 class="h2 mb-4">
        Liste des employés
    </h1>

    <?php if ($employesAffiches === []): ?>
        <p>Aucun employé trouvé.</p>
    <?php else: ?>
        <div
            class="table-responsive rounded-4
                overflow-hidden"
        >
            <table
                class="table table-striped table-hover
                    align-middle text-center mb-0"
            >
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
                    <?php foreach (
                        $employesAffiches as $employe
                    ): ?>
                        <tr>
                            <td>
                                <?= $employe['nom'] ?>
                            </td>

                            <td>
                                <?= $employe['prenom'] ?>
                            </td>

                            <td>
                                <?= $employe['telephone'] ?>
                            </td>

                            <td>
                                <?= $employe['email'] ?>
                            </td>

                            <td>
                                <span
                                    class="badge text-bg-secondary"
                                >
                                    <?= $employe['role'] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>