<?php
namespace App\Controllers;
use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;
class  Salle extends BaseController{
    public function __construct(){
        //...
        helper('form');
        $model = model(Db_model::class);
    }

    /* ============================================================
        GESTION : LISTE DES SALLES
    ============================================================*/
     public function gestion(){
        $session = session();

        // Sécurité : accessible uniquement aux admins
        if (! $session->has('user') || $session->get('role') !== 'A') {
            return redirect()->to('/compte/connecter');
        }

        $model = model(Db_model::class);
        $data['salle'] = $model->get_all_salles();

        return view('admin/menu_administrateur')
             . view('templates/haut_admin')
             . view('salle/salle_gestion', $data)
             . view('templates/bas_admin');
    }
    /* ============================================================
        AJOUTER UNE SALLE
    ============================================================*/
   public function ajouter()
{
    $session = session();

    // Sécurité : admin seulement
    if (!$session->has('user') || $session->get('role') !== 'A') {
        return redirect()->to('/compte/connecter');
    }

    helper('form');

    // Formulaire posté
    if ($this->request->getMethod() === 'POST') {

        // Validation 
        $rules = [
            'nom'  => 'required',
            'min'  => 'required|integer',
            'max'  => 'required|integer',
            'photo' => 'permit_empty',
            'pdf'   => 'permit_empty'
        ];

        $messages = [
            'nom' => [
                'required' => 'Veuillez entrer un nom de salle.'
            ],
            'min' => [
                'required' => 'Veuillez entrer une jauge minimum.',
                'integer'  => 'La jauge minimum doit être un nombre entier.'
            ],
            'max' => [
                'required' => 'Veuillez entrer une jauge maximum.',
                'integer'  => 'La jauge maximum doit être un nombre entier.'
            ]
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput();  
        }

        //Récupération des valeurs validées
        $nom   = $this->request->getPost('nom');
        $min   = $this->request->getPost('min');
        $max   = $this->request->getPost('max');
        $photo = $this->request->getPost('photo'); 
        $pdf   = $this->request->getPost('pdf');

        //Insertion
        $model = model(Db_model::class);
        $model->insert_salle($nom, $photo, $min, $max, $pdf);

        $session->setFlashdata('success', 'Salle ajoutée avec succès !');
        return redirect()->to('/salle/gestion');
    }

    // Affichage du formulaire vide
    return view('admin/menu_administrateur')
        . view('templates/haut_admin')
        . view('salle/salle_ajouter')
        . view('templates/bas_admin');
}


    /* ============================================================
        SUPPRIMER UNE SALLE
    ============================================================*/
    public function supprimer($id)
    {
        $session = session();
        if (!$session->has('user') || $session->get('role') !== 'A') {
            return redirect()->to('/compte/connecter');
        }

        $model = model(Db_model::class);
        $model->delete_salle($id);
        session()->setFlashdata('success', 'Salle supprimée !');
        return redirect()->to('salle/gestion');
    }

}