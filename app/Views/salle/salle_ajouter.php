<div class="container mt-4">

    <h2 class="mb-3">Ajouter une salle</h2>
    <hr>

    <!-- Succès -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('index.php/salle/ajouter') ?>" class="card p-4 shadow">

        <?= csrf_field() ?>

        <!-- NOM -->
        <div class="mb-3">
            <label class="form-label fw-bold">Nom de la salle</label>
            <input type="text" name="nom" class="form-control"
                   value="<?= old('nom') ?>">

            <div class="text-danger small">
                <?= validation_show_error('nom') ?>
            </div>
        </div>

        <!-- JAUGE MIN -->
        <div class="mb-3">
            <label class="form-label fw-bold">Jauge minimum</label>
            <input type="number" name="min" class="form-control"
                   value="<?= old('min') ?>">

            <div class="text-danger small">
                <?= validation_show_error('min') ?>
            </div>
        </div>

        <!-- JAUGE MAX -->
        <div class="mb-3">
            <label class="form-label fw-bold">Jauge maximum</label>
            <input type="number" name="max" class="form-control"
                   value="<?= old('max') ?>">

            <div class="text-danger small">
                <?= validation_show_error('max') ?>
            </div>
        </div>

        <!-- PHOTO -->
        <div class="mb-3">
            <label class="form-label fw-bold">Nom de la photo (ex : salle1.png)</label>
            <input type="text" name="photo" class="form-control"
                   value="<?= old('photo') ?>">

            <div class="text-danger small">
                <?= validation_show_error('photo') ?>
            </div>
        </div>

        <!-- PDF -->
        <div class="mb-3">
            <label class="form-label fw-bold">PDF descriptif (optionnel)</label>
            <input type="text" name="pdf" class="form-control"
                   value="<?= old('pdf') ?>">

            <div class="text-danger small">
                <?= validation_show_error('pdf') ?>
            </div>
        </div>

       <div class="d-flex justify-content-end mt-3">

            <button class="btn btn-primary fw-bold me-2 px-4">
                <i class="fas fa-plus-circle me-1"></i> Ajouter
            </button>

            <a href="<?= base_url('index.php/salle/gestion') ?>" 
            class="btn btn-secondary px-4">
                Annuler
            </a>

        </div>


    </form>

</div>
