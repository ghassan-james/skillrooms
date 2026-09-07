<?php
$session = session();
$user  = $session->get("user");
$role  = $session->get("role");

// Couleurs et textes selon rôle
$color = ($role === "A") ? "danger" : "primary";
$title = ($role === "A") ? "Espace d'administration" : "Espace membre";
$desc  = ($role === "A")
            ? "Vous êtes connecté en tant qu'Administrateur."
            : "Vous êtes connecté en tant que Membre.";

// Début affichage
echo '
<div class="container-fluid">

    <!-- Titre général -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-'.$color.'">'.$title.'</h1>
    </div>

    <!-- Informations utilisateur -->
    <div class="card shadow mb-4">
        <div class="card-header bg-'.$color.' text-white">
            <h5 class="mb-0">Bienvenue '.$user.' 👋</h5>
        </div>
        <div class="card-body">
            <p>'.$desc.'</p>
        </div>
    </div>
';

// =====================
// AFFICHAGE ADMIN SEULEMENT
// =====================
if ($role === "A") {

echo '

    <!-- Cartes statistiques -->
    <div class="row">

        <!-- ACTUALITÉS -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Actualités
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">'.$nb_actus.'</div>
                </div>
            </div>
        </div>

        <!-- COMPTES MEMBRES -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Comptes membres
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">'.$nb_comptes.'</div>
                </div>
            </div>
        </div>

        <!-- MESSAGES REÇUS -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Messages reçus
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">'.$nb_messages.'</div>
                </div>
            </div>
        </div>

        <!-- SALLES ESPORT -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Salles esport
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">'.$nb_salles.'</div>
                </div>
            </div>
        </div>

    </div>

    <!-- Actions rapides -->
    <div class="card shadow mb-5">
        <div class="card-header">
            <h5 class="m-0 font-weight-bold text-danger">Actions rapides</h5>
        </div>

        <div class="card-body">

            <a href="'.base_url("index.php/admin/contact").'"
               class="btn btn-primary m-1">
               <i class="fas fa-envelope"></i> Gérer les messages
            </a>

            <a href="#" class="btn btn-success m-1">
               <i class="fas fa-newspaper"></i> Gérer les actualités
            </a>

            <a href="'.base_url("index.php/compte/comptes_admin").'"
               class="btn btn-warning m-1">
               <i class="fas fa-users-cog"></i> Gérer les comptes
            </a>

            <a href="'.base_url("index.php/salle/gestion").'"
               class="btn btn-info m-1">
               <i class="fas fa-door-open"></i> Gérer les salles
            </a>

        </div>
    </div>

';
} // FIN IF ADMIN

// Fin du container
echo '
</div>
';
?>
