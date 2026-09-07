<div class="container mt-5">

    <div class="text-center mb-4">
        <h1 class="h3 text-primary text-uppercase" style="letter-spacing:2px;">
            Réservations
        </h1>
        <p class="text-muted">
            Sélectionnez un jour pour consulter vos réservations.
        </p>
    </div>

    <!-- Affichage global des erreurs -->
    <?= validation_list_errors() ?>

    <div class="card shadow-lg border-left-primary">

        <div class="card-header py-3" style="background:#006ce0;">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-calendar-alt"></i> Choisir une date
            </h6>
        </div>

        <div class="card-body">

            <form method="post" action="<?= base_url('index.php/membre/reservations') ?>">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="date" class="form-label fw-bold">Date du planning :</label>
                    <input id="date"
                           type="date"
                           name="date"
                           class="form-control border-primary"
                           value="<?= old('date') ?>"
                    >

                    <!-- erreur uniquement pour ce champ -->
                    <div class="text-danger small">
                        <?= validation_show_error('date') ?>
                    </div>
                </div>

                <button type="submit"
                        class="btn w-100 text-white fw-bold py-2"
                        style="background:#003c8f; border-radius:7px;">
                    <i class="fas fa-search"></i> Consulter
                </button>

            </form>

        </div>
    </div>

    <div class="text-center mt-4">
        <small class="text-muted">💡 Seules les dates ayant des créneaux afficheront un planning.</small>
    </div>

</div>
