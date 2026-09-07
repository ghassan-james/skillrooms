

<h2 class="mb-4">Réservations du <?= esc($date) ?></h2>

<?php if (empty($reservations) && empty($indispos)) : ?>
    <div class="alert alert-info">Aucune réservation ni indisponibilité pour cette date.</div>
<?php endif; ?>

<div class="row">

    <!-- ========== RÉSERVATIONS ========== -->
    <?php foreach ($reservations as $res) : ?>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm" style="border-radius:10px;">

                <?php if (!empty($res['sal_photo'])) : ?>
                    <img src="<?= base_url('images/' . $res['sal_photo']) ?>"
                         class="card-img-top"
                         style="height:160px; object-fit:cover; border-radius:10px 10px 0 0;">
                <?php endif; ?>

                <div class="card-body p-3"> 
                    <h6 class="card-title mb-2"><?= esc($res['sal_nom']) ?></h6>

                    <p class="card-text" style="font-size:0.9rem;">
                        <strong>Heure :</strong> <?= esc($res['crn_date']) ?><br>
                        <strong>Participants :</strong> <?= esc($res['participants']) ?>
                    </p>

                    <?php 
                        $indisposSalle = array_filter($indispos, fn($i) => $i['sal_nom'] === $res['sal_nom']);
                    ?>

                    <?php if (!empty($indisposSalle)) : ?>
                        <div class="alert alert-danger p-2 mb-0" style="font-size:0.8rem;">
                            <strong>Indispo :</strong><br>
                            <?php foreach ($indisposSalle as $ind) : ?>
                                - <?= esc($ind['ind_intitule']) ?>
                                  (<?= esc($ind['debut']) ?> → <?= esc($ind['fin']) ?>)
                                <br>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>

    <?php endforeach; ?>


    <!-- ========== INDISPOS SANS RÉSERVATION ========== -->
    <?php
        $sallesAvecResa = array_column($reservations, 'sal_nom');

        foreach ($indispos as $ind) :
            if (!in_array($ind['sal_nom'], $sallesAvecResa)) :
    ?>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-danger" style="border-radius:10px;">

                <?php if (!empty($ind['sal_photo'])) : ?>
                    <img src="<?= base_url('images/' . $ind['sal_photo']) ?>"
                         class="card-img-top"
                         style="height:160px; object-fit:cover; border-radius:10px 10px 0 0;">
                <?php endif; ?>

                <div class="card-body p-3">
                    <h6 class="card-title text-danger mb-2">
                        <?= esc($ind['sal_nom']) ?> (Indispo)
                    </h6>

                    <div class="alert alert-danger p-2 mb-0" style="font-size:0.8rem;">
                        <strong>Indisponibilité :</strong><br>
                        - <?= esc($ind['ind_intitule']) ?>
                          (<?= esc($ind['debut']) ?> → <?= esc($ind['fin']) ?>)
                    </div>
                </div>

            </div>
        </div>

    <?php
            endif;
        endforeach;
    ?>

</div>
