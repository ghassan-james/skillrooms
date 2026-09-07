<div class="container mt-5">

    <!-- Titre principal -->
    <div class="text-center mb-4">
        <h1 class="h3 text-danger text-uppercase" style="letter-spacing:2px;">
            Réservations (Administration)
        </h1>
        <p class="text-muted">
            Sélectionnez un jour afin de consulter le planning complet des salles eSport.
        </p>
    </div>

    <!-- Affichage global des erreurs -->
    <?= validation_list_errors() ?>

    <!-- Carte principale -->
    <div class="card shadow-lg border-left-danger">

        <!-- Header rouge -->
        <div class="card-header py-3" style="background:#b30000;">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-calendar-alt"></i> Choisir une date
            </h6>
        </div>

        <!-- Corps -->
        <div class="card-body">

            <form method="post" action="<?= base_url('index.php/admin/reservations') ?>">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="date" class="form-label fw-bold">Date du planning :</label>

                    <input id="date"
                           type="date"
                           name="date"
                           class="form-control border-danger"
                           value="<?= old('date') ?>"
                    >

                    <!-- Erreur spécifique au champ date -->
                    <div class="text-danger small">
                        <?= validation_show_error('date') ?>
                    </div>
                </div>

                <button type="submit" 
                        class="btn w-100 text-white fw-bold py-2"
                        style="background:#cc0000; border-radius:7px;">
                    <i class="fas fa-search"></i> Consulter les réservations
                </button>

            </form>

        </div>
    </div>

    <!-- Info -->
    <div class="text-center mt-4">
        <small class="text-muted">
            💡 Seules les dates possédant des créneaux afficheront un planning.
        </small>
    </div>

</div>
