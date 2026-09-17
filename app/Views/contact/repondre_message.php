<div class="container mt-4">

    <h2>Répondre au message d’un visiteur</h2>
    <hr>

    <!-- Informations du message -->
    <div class="card shadow mb-4">
        <div class="card-body">

            <p><strong>Email :</strong> <?= esc($msg['msg_email']) ?></p>
            <p><strong>Sujet :</strong> <?= esc($msg['msg_titre']) ?></p>
            <p><strong>Date :</strong> <?= esc($msg['msg_date']) ?></p>

            <p class="mt-3"><strong>Message du visiteur :</strong><br>
                <?= esc($msg['msg_contenu']) ?>
            </p>

        </div>
    </div>

    <!-- Formulaire avec validation -->
    <div class="card shadow">
        <div class="card-body">

            <!-- Succès -->
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form method="post" 
                  action="<?= base_url('index.php/admin/contact/repondre/'.$msg['msg_id']) ?>">

                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label"><strong>Votre réponse :</strong></label>

                    <textarea name="reponse"
                              class="form-control border-danger"
                              rows="5"><?= old('reponse') ?></textarea>

                    <!-- Erreur spécifique au champ -->
                    <div class="text-danger small">
                        <?= service('validation')->showError('reponse') ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-danger fw-bold">
                    Envoyer la réponse
                </button>

                <a href="<?= base_url('index.php/admin/contact') ?>" 
                   class="btn btn-secondary">
                    Retour
                </a>

            </form>

        </div>
    </div>

</div>
