<?php
namespace App\Controllers;

use App\Models\Db_model;

class AdminReservation extends BaseController
{
    // Formulaire + traitement POST
    public function choisir_jour()
    {
        $session = session();

        // Sécurité : doit être ADMIN
        if (! $session->has('user') || $session->get('role') !== 'A') {
            return redirect()->to(base_url('compte/connecter'));
        }

        helper('form');

        //  FORMULAIRE SUBMIT
        if (strtolower($this->request->getMethod()) === 'post') {

            // Validation CodeIgniter
            if (! $this->validate([
                'date' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Veuillez choisir une date.',
                    ]
                ]
            ])) {
                // Retour au formulaire avec erreurs
                return view('admin/menu_administrateur')
                    . view('templates/haut_admin')
                    . view('reservations/choisir_jour_admin')
                    . view('templates/bas_admin');
            }

            // Si aucune erreur → redirection
            $date = $this->request->getPost('date');
            return redirect()->to('admin/reservations/jour/' . $date);
        }

        // AFFICHAGE INITIAL
        return view('admin/menu_administrateur')
            . view('templates/haut_admin')
            . view('reservations/choisir_jour_admin')
            . view('templates/bas_admin');
    }


    // Affichage des réservations du jour choisi
    public function voir_jour($date)
    {
        $session = session();

        if (! $session->has('user') || $session->get('role') !== 'A') {
            return redirect()->to('/compte/connecter');
        }

        $model = model(Db_model::class);

        $data = [
            'date'         => $date,
            'reservations' => $model->get_reservations_admin($date),
            'indispos'     => $model->get_indispos_admin($date),
        ];

        return view('admin/menu_administrateur')
            . view('templates/haut_admin')
            . view('reservations/liste_jour_admin', $data)
            . view('templates/bas_admin');
    }

}
