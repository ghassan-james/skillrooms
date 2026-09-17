<?php
echo '

<h2 class="text-center mb-4 text-uppercase"
    style="letter-spacing:3px; color:#00eaff;">
    '.$titre.'
</h2>

<div class="container" style="max-width:500px;">

    '.session()->getFlashdata("error").'

    '.form_open("/compte/connecter").'
    '.csrf_field().'

    <div class="mb-3">
        <label for="pseudo" class="form-label text-white fw-bold">Pseudo :</label>
        <input type="text" name="pseudo" 
               value="'.set_value("pseudo").'" 
               class="form-control"
               style="background:#0f1b24; border:1px solid #1f2a36; color:white;">
        <div class="text-danger">'.validation_show_error("pseudo").'</div>
    </div>

    <div class="mb-3">
        <label for="mdp" class="form-label text-white fw-bold">Mot de passe :</label>
        <input type="password" name="mdp" 
               class="form-control"
               style="background:#0f1b24; border:1px solid #1f2a36; color:white;">
        <div class="text-danger">'.validation_show_error("mdp").'</div>
    </div>

    <button type="submit" class="btn w-100"
            style="
                background:#00eaff;
                color:black;
                font-weight:700;
                border-radius:40px;
                text-transform:uppercase;
            ">
        Se connecter
    </button>

    </form>

</div>

';
?>
