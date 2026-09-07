<?php
echo '

<!-- HERO SECTION EXCLUSIVE ACCUEIL -->
<header class="masthead d-flex justify-content-center align-items-center" 
        style="
            background: url('.base_url(). 'bootstrap/assets/img/home_esport.png) no-repeat center center;
            background-size: cover;
            height: 100vh;
            position: relative;
        ">
    <div style="
        position:absolute;
        top:0;left:0;
        width:100%;height:100%;
        background:rgba(0,0,0,0.65);
    "></div>

    <div class="container text-center" style="position:relative; z-index:2;">
        <h1 style="
            font-family: Orbitron, sans-serif;
            font-size: 4rem;
            text-transform: uppercase;
            letter-spacing: 6px;
            color:#00eaff;
            font-weight:700;
        ">SkillRooms</h1>

        <a href="#about" class="btn" style="
            margin-top:25px;
            padding:12px 30px;
            background:#00eaff;
            border-radius:40px;
            color:#000;
            font-weight:700;
            text-transform:uppercase;
        ">Découvrir</a>
    </div>
</header>


<!-- ABOUT SECTION -->
<section class="about-section text-center py-5" id="about">
    <div class="container px-4 px-lg-5">
        <h2 class="text-uppercase mb-4" style="letter-spacing: 3px; color:#00eaff;">
            Bienvenue sur SkillRooms
        </h2>

        <p class="text-white-50 fs-5">
            SkillRooms est la plateforme dédiée à la gestion et à la réservation 
            de salles d\'entraînement esport.
        </p>
    </div>
</section>

<hr class="border-secondary mx-auto" style="width: 60%;">

<!-- ACTUS SECTION -->
<section class="container py-4">
    <h2 class="text-center mb-4 text-uppercase" style="color:#00eaff; letter-spacing:3px;">
        Actualités
    </h2>

    <div class="row g-4">
';


if (!empty($actus) && is_array($actus))
{
    foreach ($actus as $actu)
    {
        echo '
        <div class="col-md-6 col-lg-4">
            <div class="card bg-dark text-white h-100 border border-secondary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-info fw-bold">'.$actu["act_titre"].'</h5>
                    <p class="card-text text-white-50">'.$actu["act_contenu"].'</p>
                </div>
                <div class="card-footer border-secondary">
                    <small class="text-white-50">
                        Publié le '.$actu["act_date_publication"].' par
                        <span class="text-info">'.$actu["cpt_pseudo"].'</span>
                    </small>
                </div>
            </div>
        </div>
        ';
    }
}
else
{
    echo '
        <div class="col-12 text-center">
            <h4 class="text-white">Aucune actualité pour le moment</h4>
        </div>
    ';
}

echo '
    </div>
</section>
';
?>
