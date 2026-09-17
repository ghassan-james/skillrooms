<?php
namespace App\Controllers;

use App\Models\Db_model;

class Membre extends BaseController
{
    public function liste()
    {
        $session = session();

        // Vérification : doit être un membre connecté (Rôle = J)
        if (!$session->has('user') || $session->get('role') !== 'J') {
            return redirect()->to('/compte/connecter');
        }

        $model = model(Db_model::class);

        // On exclut le membre connecté de la liste
        $data['adherents'] = $model->get_all_adherents($session->get('user'));

        // Choix du menu membre
        return view('membre/menu_menbre')
             . view('templates/haut_admin')
             . view('membre/liste_adherents', $data)
             . view('templates/bas_admin');
    }
}
