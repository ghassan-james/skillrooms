<div class="container mt-4">

    <h3 class="mb-4">Ajouter un compte invité</h3>

    <!-- Erreur pseudo déjà existant -->
    <?php if (session()->getFlashdata('erreur')) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('erreur') ?></div>
    <?php endif; ?>

    <!-- Succès -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('index.php/compte/ajouter_invite_action') ?>" 
          method="post" 
          class="shadow p-4 rounded">

        <?= csrf_field() ?>

        <!-- PSEUDO -->
        <div class="mb-3">
            <label class="form-label fw-bold">Pseudo</label>

            <input type="text" 
                   name="pseudo" 
                   class="form-control"
                   value="<?= old('pseudo') ?>">

            <div class="text-danger small">
                <?= validation_show_error('pseudo') ?>
            </div>
        </div>

        <!-- MDP -->
        <div class="mb-3">
            <label class="form-label fw-bold">Mot de passe</label>

            <input type="password" 
                   name="mdp" 
                   class="form-control">

            <div class="text-danger small">
                <?= validation_show_error('mdp') ?>
            </div>
        </div>

        <button class="btn btn-success fw-bold">Créer le compte invité</button>
        <a href="<?= base_url('index.php/compte/comptes_admin') ?>" 
           class="btn btn-secondary ms-2">
            Annuler
        </a>

    </form>

</div>
