<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow-sm border-bottom">

    <!-- Sidebar Toggle (Mobile) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- LEFT SIDE -->
    <div class="d-flex align-items-center">

        <!-- ACCUEIL -->
        <a class="nav-link fw-semibold text-dark mx-3" 
           href="<?= base_url('index.php/compte/accueil') ?>">
            <i class="fas fa-home me-1"></i> Accueil
        </a>

        <!-- LISTE ADHÉRENTS -->
        <a class="nav-link fw-semibold text-dark mx-3" 
           href="<?= base_url('index.php/membre/liste') ?>">
            <i class="fas fa-users me-1"></i> Liste adhérents
        </a>

        <!-- SÉANCES RÉSERVÉES -->
        <a class="nav-link fw-semibold text-dark mx-3" 
           href="<?= base_url('index.php/membre/reservations') ?>">
            <i class="fas fa-calendar-alt me-1"></i> Séances réservées
        </a>

    </div>

    <!-- RIGHT SIDE -->
    <ul class="navbar-nav ml-auto">

        <!-- PROFIL -->
        <li class="nav-item mx-3 d-flex align-items-center">
            <i class="fas fa-user-circle fa-lg text-secondary me-2"></i>
            <a class="nav-link fw-semibold text-dark p-0" 
               href="<?= base_url('index.php/compte/afficher_profil') ?>">
                Profil
            </a>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- DÉCONNEXION -->
        <li class="nav-item ms-3">
            <a class="nav-link fw-semibold text-danger" 
               href="<?= base_url('index.php/compte/deconnecter') ?>">
                <i class="fas fa-sign-out-alt me-1"></i> Déconnexion
            </a>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->
