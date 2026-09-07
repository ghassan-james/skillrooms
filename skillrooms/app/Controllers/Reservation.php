<?php
namespace App\Controllers;

use App\Models\Db_model;

class Reservation extends BaseController
{
    // Formulaire + traitement POST
public function choisir_jour()
{
    $session = session();

    if (! $session->has('user') || $session->get('role') !== 'J') {
        return redirect()->to('/compte/connecter');
    }

    helper('form');

    // Si le formulaire est soumis
   if (strtolower($this->request->getMethod()) === 'post') {

        if (! $this->validate([
            'date' => ['rules' => 'required', 'errors' => [
                'required' => 'Veuillez choisir une date.',
            ]],
        ])) {
            // Retour formulaire avec erreurs
            return view('membre/menu_menbre')
                . view('templates/haut_admin', ['titre' => 'Réservations'])
                . view('reservations/choisir_jour')
                . view('templates/bas_admin');
        }

        // Si OK
        $date = $this->request->getPost('date');
        return redirect()->to('/membre/reservations/jour/' . $date);
    }

    // Affichage initial
    return view('membre/menu_menbre')
        . view('templates/haut_admin', ['titre' => 'Réservations'])
        . view('reservations/choisir_jour')
        . view('templates/bas_admin');
}


    // Affichage des réservations du jour choisi
    public function voir_jour($date)
    {
        $session = session();

        if (! $session->has('user') || $session->get('role') !== 'J') {
            return redirect()->to('/compte/connecter');
        }

        $model = model(Db_model::class);

        $data = [
            'date'         => $date,
            'reservations' => $model->get_reservations_admin($date),
            'indispos'     => $model->get_indispos_admin($date),
        ];

        return view('membre/menu_menbre')
            . view('templates/haut_admin')
            . view('reservations/liste_jour', $data)
            . view('templates/bas_admin');
    }

}
