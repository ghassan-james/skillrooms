<?php
$session = session();
$user = $session->get('user');
$role = $session->get('role');

// Profil envoyé par le contrôleur
$nom    = $profil['pfl_nom'];
$prenom = $profil['pfl_prenom'];
$email  = $profil['pfl_email'];

// Couleur selon rôle
$color = ($role === 'A') ? "danger" : "primary";
$roleText = ($role === 'A') ? "Administrateur" : "Membre";

// Début du container + carte
echo "
<div class='container mt-4'>
    <div class='card shadow'>
        <div class='card-header bg-$color text-white'>
            <h2 class='mb-0'>Mon Profil</h2>
        </div>
        <div class='card-body'>

            <h4 class='mb-3 text-$color'>Informations personnelles</h4>

            <p><strong>Pseudo :</strong> $user</p>
            <p><strong>Nom :</strong> $nom</p>
            <p><strong>Prénom :</strong> $prenom</p>
            <p><strong>Email :</strong> $email</p>

            <hr>

            <h4 class='text-$color'>Espace $roleText</h4>
";

// Contenu selon rôle
if ($role === 'A') {
    echo "
            <p>Vous êtes connecté en tant qu'Administrateur.</p>
            <ul>
                <li>Gérer les utilisateurs</li>
                <li>Gérer les actualités</li>
                <li>Gérer les catégories</li>
            </ul>
            <a href='".base_url('index.php/compte/modifier')."' class='btn btn-$color'>Modifier mon profil</a>
        ";
}

if ($role === 'J') {
    echo "
            <p>Vous êtes connecté en tant que membre.</p>
            <a href='".base_url('index.php/compte/modifier')."' class='btn btn-$color'>Modifier mon profil</a>
        ";
}

// Fin de la carte + container
echo "
        </div>
    </div>
</div>
";
?>
