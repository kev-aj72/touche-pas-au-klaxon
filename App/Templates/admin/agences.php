<?php

/**
 * Template permettant à l’administrateur
 * de gérer la liste des agences.
 */

/** @var array $agencesAffichees Liste des agences. */
/** @var string|null $messageSucces Message de réussite. */
/** @var string|null $messageErreur Message d’erreur. */
?>

<main class="pb-4">
    <h1 class="h2 mb-4">Gestion des agences</h1>
    <!-- Affichage des messages de réussite ou d’erreur -->
    <?php echo $this->component('messages',['success' => $messageSucces, 'error' => $messageErreur,]);?>

    <!-- Formulaire permettant de créer une agence -->
    <section class="mb-5">
        <h2 class="h4 mb-3">Ajouter une agence</h2>
        <?php echo $this->component('agenceForm',['action' => $this->url('/admin/agences/ajouter'),
                                    'submitLabel' => 'Ajouter l’agence', 'agence' => null,]);?>
    </section>

    <!-- Liste des agences existantes -->
    <section>
        <h2 class="h4 mb-3">Liste des agences</h2>
        <?php if ($agencesAffichees === []): ?>
            <p>Aucune agence trouvée.</p>
        <?php else: ?>
            <div class="table-responsive rounded-4 overflow-hidden">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Ville</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Création d’une ligne pour chaque agence -->
                        <?php foreach ($agencesAffichees as $agence): ?>
                            <tr>
                                <td><?php echo $this->escape($agence['ville']);?></td>
                                <td class="text-end">
                                    <!-- Accès au formulaire de modification -->
                                    <a href="<?php echo $this->url('/admin/agences/'. (int) $agence['id_agence']. '/modifier');?>"
                                     class="btn btn-sm btn-outline-primary"> Modifier</a>

                                    <!-- Suppression protégée par un jeton CSRF -->
                                    <form action="<?php echo $this->url('/admin/agences/'. (int) $agence['id_agence']. '/supprimer');?>" 
                                          method="post" class="d-inline" onsubmit="return confirm('Supprimer cette agence ?');">
                                        <?php echo $this->csrfField();?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</main>