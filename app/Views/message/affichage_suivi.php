<?php
echo '

<!-- Section d’en-tête -->
<section class="about-section text-center py-5" id="about">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8">
                <h2 class="text-uppercase mb-4"
                    style="letter-spacing:3px; color:#00eaff;">
                    Suivi de votre message
                </h2>
                <p class="text-white-50 fs-5">
                    Consultez ci-dessous les informations liées à votre demande.
                </p>
            </div>
        </div>
    </div>
</section>

<div class="container py-4">
    <h2 class="text-white mb-4">'.$titre.'</h2>
    <hr class="border-secondary">

';

if ($message) {

    echo '
    <div class="p-4 mt-3"
         style="background:#0f1b24; border:1px solid #1f2a36; border-radius:10px;">

        <p><b style="color:#00eaff;">Date :</b> '.$message->msg_date.'</p>

        <p><b style="color:#00eaff;">Sujet :</b> '.$message->msg_titre.'</p>

        <p><b style="color:#00eaff;">Question :</b><br>'.$message->msg_contenu.'</p>

        <p><b style="color:#00eaff;">Réponse :</b><br>';

        if (!empty($message->msg_reponse)) {
            echo $message->msg_reponse;
        } else {
            echo "<span style=\"color:gray;\">Aucune réponse n’a encore été apportée à votre question.</span>";
        }

    echo '</p>

        <p><b style="color:#00eaff;">Email :</b> '.$message->msg_email.'</p>

    </div>
    ';

} else {

    echo '
    <div class="text-center mt-4">
        <p style="color:red; font-size:1.2rem;">
            <b>Aucun message trouvé pour ce code.</b>
        </p>
    </div>
    ';
}

echo '
</div>
';
?>
