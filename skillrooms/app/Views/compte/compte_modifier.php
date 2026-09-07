<?php
$nom    = $profil['pfl_nom'];
$prenom = $profil['pfl_prenom'];
$email  = $profil['pfl_email'];


// Couleur selon rôle
$color = ($role === 'A') ? "danger" : "primary";

echo "
<div class='container mt-4'>
    <div class='card shadow'>
        <div class='card-header bg-$color text-white'>
            <h2>Modifier mon profil</h2>
        </div>
        <div class='card-body'>
";

if (session()->getFlashdata('error')) {
    echo "<div class='alert alert-danger'>" . session()->getFlashdata('error') . "</div>";
}

echo "
<form action='".base_url("index.php/compte/modifier_valider")."' method='post'>

    <div class='mb-3'>
        <label class='form-label'>Nom</label>
        <input type='text' name='nom' class='form-control' value='$nom'>
    </div>

    <div class='mb-3'>
        <label class='form-label'>Prénom</label>
        <input type='text' name='prenom' class='form-control' value='$prenom'>
    </div>

    <div class='mb-3'>
        <label class='form-label'>Email</label>
        <input type='email' name='email' class='form-control' value='$email'>
    </div>

    <hr>

    <div class='mb-3'>
        <label class='form-label'>Nouveau mot de passe (optionnel)</label>
        <input type='password' name='mdp' class='form-control'>
    </div>

    <div class='mb-3'>
        <label class='form-label'>Confirmation du mot de passe</label>
        <input type='password' name='confirm' class='form-control'>
    </div>

    <button type='submit' class='btn btn-$color'>Valider</button>
    <a href='".base_url("index.php/compte/afficher_profil")."' class='btn btn-secondary'>Annuler</a>

</form>
        </div>
    </div>
</div>
";
?>
