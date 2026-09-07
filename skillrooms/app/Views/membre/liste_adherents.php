<?php

echo '
<div class="container mt-4">
    <h2>Liste des adhérents</h2>
    <hr>
';

if (empty($adherents)) {

    echo '
        <div class="alert alert-info">
            Aucun adhérent pour le moment !
        </div>
    ';

} else {

    echo '
        <table class="table table-striped table-bordered shadow">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                </tr>
            </thead>
            <tbody>
    ';

    foreach ($adherents as $a) {

        echo '
            <tr>
                <td>' . htmlspecialchars($a["pfl_nom"]) . '</td>
                <td>' . htmlspecialchars($a["pfl_prenom"]) . '</td>
                <td>' . htmlspecialchars($a["pfl_email"]) . '</td>
                <td>' . htmlspecialchars($a["pfl_telephone"]) . '</td>
            </tr>
        ';
    }

    echo '
            </tbody>
        </table>
    ';
}

echo '</div>';
