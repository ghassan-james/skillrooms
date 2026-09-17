<?php
echo '
<div class="container py-5">
    <div class="card bg-dark text-white shadow-lg p-5 border border-secondary">

        <h2 class="text-center mb-4 text-uppercase"
            style="letter-spacing:3px; color:#00eaff;">
            '.$titre.'
        </h2>

        <p class="text-center text-white-50 fs-5">
            Que souhaitez-vous faire&nbsp;?
        </p>

        <div class="d-flex justify-content-center flex-wrap gap-4 mt-4">

            <a href="'.base_url('index.php/message/contact').'" 
               class="btn btn-lg px-4"
               style="
                    background:#00eaff;
                    color:#000;
                    font-weight:700;
                    border-radius:40px;
                    text-transform:uppercase;
               ">
                <i class="fa-solid fa-comment-dots me-2"></i>
                Poser une question
            </a>

            <a href="'.base_url('index.php/message/formulaire').'" 
               class="btn btn-lg px-4"
               style="
                    background:#1f6feb;
                    color:white;
                    font-weight:700;
                    border-radius:40px;
                    text-transform:uppercase;
               ">
                <i class="fa-solid fa-magnifying-glass me-2"></i>
                Suivre une demande
            </a>

        </div>

    </div>
</div>
';
?>
