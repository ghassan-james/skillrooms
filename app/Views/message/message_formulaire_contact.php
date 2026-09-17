<?php
echo '

<h2 class="text-center mb-4 text-uppercase" 
    style="letter-spacing:3px; color:#00eaff;">
    '.$titre.'
</h2>

<div class="container">

    '.session()->getFlashdata("error").'

    '.form_open("/message/contact").'
    '.csrf_field().'

    <div class="mb-3">
        <label for="sujet" class="form-label text-white fw-bold">Sujet :</label>
        <input type="text" class="form-control" id="sujet" name="sujet"
               value="'.set_value("sujet").'">
        <div class="text-danger">'.validation_show_error("sujet").'</div>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label text-white fw-bold">Adresse e-mail :</label>
        <input type="text" class="form-control" id="email" name="email"
               value="'.set_value("email").'">
        <div class="text-danger">'.validation_show_error("email").'</div>
    </div>

    <div class="mb-3">
        <label for="question" class="form-label text-white fw-bold">Votre question :</label>
        <textarea class="form-control" id="question" name="question" rows="5">'.set_value("question").'</textarea>
        <div class="text-danger">'.validation_show_error("question").'</div>
    </div>

    <button type="submit" class="btn w-10"
            style="
                background:#00eaff;
                font-weight:700;
                border-radius:40px;
                color:#000;
                text-transform:uppercase;
            ">
        Envoyer ma question
    </button>

    </form>

';

# --- AFFICHAGE CODE DE SUIVI
if (!empty($code)) {

    echo '
    <div class="alert alert-success mt-4 p-4" 
         style="background:#0f1b24; border:1px solid #1f2a36; color:#d9edf7;">

        <p class="mb-0">
            <b style="color:#00eaff;">Votre demande a bien été envoyée.</b><br>
            <span>Conservez votre code :</span><br>
            <span style="font-size:1.3rem; font-weight:700; color:#00eaff;">'.esc($code).'</span>
        </p>

    </div>
    ';
}

echo '
</div>
';
?>
