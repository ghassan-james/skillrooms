<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Gestion des salles réservables</h2>

        <!-- Bouton AJOUTER -->
        <a href="<?= base_url('index.php/salle/ajouter') ?>" class="btn btn-success">
            + Ajouter une salle
        </a>
    </div>

    <hr>

    <?php if (empty($salle)) : ?>

        <div class="alert alert-info">Aucune salle réservable pour l'instant !</div>

    <?php else : ?>

        <table class="table table-striped table-bordered shadow">
            <thead class="table-light">
                <tr>
                    <th>Photo</th>
                    <th>Nom</th>
                    <th>Places</th>
                    <th>Jauge</th>
                    <th>PDF</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

            <?php foreach ($salle as $s) : ?>

                <tr>

                    <!-- PHOTO -->
                    <td>
                        <img src="<?= base_url('images/' . $s['sal_photo']) ?>"
                             alt="Photo salle"
                             style="width:80px; height:60px; object-fit:cover; border-radius:4px;">
                    </td>

                    <!-- NOM -->
                    <td><?= esc($s['sal_nom']) ?></td>

                    <!-- PLACES -->
                    <td><?= $s['sal_jauge_min'] ?> / <?= $s['sal_jauge_max'] ?></td>

                    <!-- BARRE DE JAUGE -->
                    <td>
                        <?php 
                            $percent = ($s['sal_jauge_min'] / $s['sal_jauge_max']) * 100;
                        ?>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar <?= ($percent < 30) ? 'bg-danger' : 'bg-success' ?>"
                                 role="progressbar"
                                 style="width: <?= $percent ?>%">
                            </div>
                        </div>
                    </td>

                    <!-- PDF -->
                    <td>
                        <?php if (!empty($s['sal_pdf'])) : ?>
                            <a href="<?= base_url('pdf/' . $s['sal_pdf']) ?>" target="_blank">
                                Ouvrir
                            </a>
                        <?php else : ?>
                            <span class="text-muted">Aucun</span>
                        <?php endif; ?>
                    </td>

                    <!-- ACTIONS -->
                    <td class="text-center">

                        <!-- Bouton VOIR (future page Sprint 3) -->
                        <a href="#" class="btn btn-sm btn-primary mb-1">
                            Voir détails
                        </a>

                        <!-- Bouton SUPPRIMER -->
                        <a href="<?= base_url('index.php/salle/supprimer/' . $s['sal_id']) ?>"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Supprimer cette salle ?')">
                           Supprimer
                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>
        </table>

    <?php endif; ?>

</div>







