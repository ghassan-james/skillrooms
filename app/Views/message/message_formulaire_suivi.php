<?php
echo '

<h2 class="text-center mb-4 text-uppercase" 
    style="letter-spacing:3px; color:#00eaff;">'.$titre.'</h2>

<div class="container">

    '.session()->getFlashdata("error").'
    '.validation_list_errors().'

    ';

    // Si $erreur est rempli → affiche une alerte
    if (!empty($erreur)) {
        echo '<div class="alert alert-danger">'.esc($erreur).'</div>';
    }

echo '

    <!-- FORMULAIRE -->
    '.form_open("/message/formulaire").'
    '.csrf_field().'

    <div class="mb-3">
        <label for="code" class="form-label text-white fw-bold">
            Entrez votre code de suivi (20 caractères)
        </label>

        <input type="text" class="form-control" 
               id="code" name="code"
               placeholder="Exemple : ABCDE12345FGHIJ67890"
               value="'.set_value("code").'">

        <div class="text-danger">'.validation_show_error("code").'</div>
    </div>

    <button type="submit" class="btn w-10"
            style="
                background:#00eaff;
                font-weight:700;
                border-radius:40px;
                color:#000;
                text-transform:uppercase;
            ">
        Valider
    </button>

    </form>

    <div class="mt-4">
';

    // AFFICHAGE DU MESSAGE SI CODE VALIDE
    if (isset($message) && $message) {

        echo '
        <div class="alert alert-success p-4" 
             style="background:#0f1b24; border:1px solid #1f2a36; color:#d9edf7;">

            <p><b style="color:#00eaff;">Date :</b> '.$message->msg_date.'</p>

            <p><b style="color:#00eaff;">Sujet :</b> '.$message->msg_titre.'</p>

            <p><b style="color:#00eaff;">Question :</b><br>'.$message->msg_contenu.'</p>

            <p><b style="color:#00eaff;">Réponse :</b><br>';

            if (!empty($message->msg_reponse)) {
                echo $message->msg_reponse;
            } else {
                echo '<span style="color:gray;">Aucune réponse n’a encore été apportée à votre question.</span>';
            }

        echo '
            </p>

            <p><b style="color:#00eaff;">Email :</b> '.$message->msg_email.'</p>

        </div>
        ';
    }

echo '
    </div>
</div>
';
?>
