<div class="container mt-4">

    <h2 class="mb-4">Gestion des comptes / profils</h2>
    <hr>

    <!-- Boutons d'ajout -->
    <div class="mb-3 d-flex gap-2">
        <a href="<?= base_url('index.php/compte/ajouter_invite') ?>" class="btn btn-success">
            + Ajouter un compte invité
        </a>

        <!-- Bouton futur Sprint 3 -->
        <button class="btn btn-secondary" disabled>+ Ajouter un compte/profil</button>
    </div>

    <!-- Messages flash -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('erreur')) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('erreur') ?></div>
    <?php endif; ?>

    <!-- Cas : aucun compte sauf l'admin -->
    <?php if (empty($comptes) || count($comptes) <= 1) : ?>
        <div class="alert alert-info">
            Aucun compte/profil pour le moment !
        </div>
    <?php else : ?>

        <table class="table table-striped table-bordered shadow">
            <thead class="table-light">
                <tr>
                    <th>Pseudo</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>État</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($comptes as $c) : ?>

                <?php if ($c['cpt_pseudo'] === session()->get('user')) continue; ?>

                <tr>
                    <td><?= esc($c['cpt_pseudo']) ?></td>
                    <td><?= esc($c['pfl_nom']) ?></td>
                    <td><?= esc($c['pfl_prenom']) ?></td>
                    <td><?= esc($c['pfl_email']) ?></td>

                    <!-- Badge rôle -->
                    <td>
                        <?php if ($c['pfl_role'] === 'A') : ?>
                            <span class="badge bg-danger">Admin</span>
                        <?php elseif ($c['pfl_role'] === 'J') : ?>
                            <span class="badge bg-primary">Membre</span>
                        <?php else : ?>
                            <span class="badge bg-secondary">Invité</span>
                        <?php endif; ?>
                    </td>

                    <!-- Badge état -->
                    <td>
                        <?php if ($c['cpt_etat'] === 'A') : ?>
                            <span class="badge bg-success">Activé</span>
                        <?php else : ?>
                            <span class="badge bg-danger">Désactivé</span>
                        <?php endif; ?>
                    </td>

                    <!-- Icônes (Sprint 3) -->
                    <td class="text-center">

                        <i class="bi bi-eye text-secondary mx-1" title="Voir"></i>
                        <i class="bi bi-pencil text-warning mx-1" title="Modifier"></i>

                        <?php if ($c['cpt_etat'] === 'A') : ?>
                            <i class="bi bi-slash-circle text-danger mx-1" title="Désactiver"></i>
                        <?php else : ?>
                            <i class="bi bi-check-circle text-success mx-1" title="Activer"></i>
                        <?php endif; ?>

                        <i class="bi bi-trash text-danger mx-1" title="Supprimer"></i>

                    </td>
                </tr>

            <?php endforeach; ?>

            </tbody>
        </table>

    <?php endif; ?>

</div>
