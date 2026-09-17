<?php
namespace App\Controllers;

use App\Models\Db_model;

class Contact extends BaseController
{
    /* ===================================================================
       LISTE DES MESSAGES
    ====================================================================*/
    public function liste()
    {
        $session = session();

        // Admin ONLY
        if (!$session->has('user') || $session->get('role') !== 'A') {
            return redirect()->to('/compte/connecter');
        }

        $model = model(Db_model::class);
        $data['messages'] = $model->get_all_messages();

        return view('admin/menu_administrateur')
             . view('templates/haut_admin')
             . view('contact/liste_messages', $data)
             . view('templates/bas_admin');
    }

    /* ===================================================================
       AFFICHAGE DU MESSAGE CHOISI
    ====================================================================*/
    public function voir($id)
    {
        $session = session();

        if (!$session->has('user') || $session->get('role') !== 'A') {
            return redirect()->to('/compte/connecter');
        }

        $model = model(Db_model::class);
        $msg = $model->get_message($id);

        if (!$msg) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/menu_administrateur')
             . view('templates/haut_admin')
             . view('contact/repondre_message', ['msg' => $msg])
             . view('templates/bas_admin');
    }

    /* ===================================================================
       TRAITEMENT DU FORMULAIRE DE RÉPONSE
    ====================================================================*/
public function repondre($id)
{
    $session = session();

    if (!$session->has('user') || $session->get('role') !== 'A') {
        return redirect()->to('/compte/connecter');
    }

    helper('form');

    // Validation CodeIgniter
    if (! $this->validate([
        'reponse' => [
            'rules' => 'required|min_length[3]',
            'errors' => [
                'required' => 'Veuillez écrire une réponse.',
                'min_length' => 'La réponse doit contenir au moins 3 caractères.',
            ]
        ]
    ])) {
        // On recharge la vue avec les erreurs
        $model = model(Db_model::class);
        $msg = $model->get_message($id);

        return view('admin/menu_administrateur')
             . view('templates/haut_admin')
             . view('contact/repondre_message', ['msg' => $msg])
             . view('templates/bas_admin');
    }

    // Si tout est OK
    $model = model(Db_model::class);
    $model->update_message_response($id, $session->get('user'), $this->request->getPost('reponse'));

    $session->setFlashdata('success', "Réponse enregistrée !");
    return redirect()->to('/admin/contact');
}

}
