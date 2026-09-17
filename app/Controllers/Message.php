<?php
namespace App\Controllers;
use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Message extends BaseController{

/****************************************************FORMULAIRE DE SUIVI*****************************************************/
public function formulaire(){
    helper('form');
    $model = model(Db_model::class);
    $data['titre'] = "Suivi de message";

    if ($this->request->getMethod() == 'POST') {
        if (! $this->validate([
            'code' => 'required'
        ],
        [
            'code' => [
                'required' => 'Veuillez saisir votre code de suivi.'
            ]
        ]))
        {
            return view('menu_visiteur')
                 . view('templates/haut', $data)
                 . view('message/message_formulaire_suivi', $data)
                 . view('templates/bas');
        }

        // Récupération du code
        $code = $this->request->getPost('code');
        $message = $model->get_suivie($code);
        // Vérification du résultat
        if ($message) {
            $data['message'] = $message;
        } else {
            $data['message'] = null;
            $data['erreur'] = "Aucun message trouvé pour ce code.";
        }

        $data['code'] = $code;
    }

    return view('menu_visiteur')
         . view('templates/haut', $data)
         . view('message/message_formulaire_suivi', $data)
         . view('templates/bas');
}

    /****************************************************FORMULAIRE DE CONTACT*****************************************************/
    public function contact(){
        helper('form');
        $model = model(Db_model::class);

        $data['titre']  = "Formulaire de contact";
        $data['code']   = null;

        if ($this->request->getMethod() == 'POST') {
            if (! $this->validate([
                'sujet' => 'required',
                'email' => 'required|valid_email',
                'question' => 'required',
            ],
            [ // messages personnalisés
                'sujet' => [
                    'required'   => 'Veuillez entrer un sujet pour votre demande.',
                ],
                'email' => [
                    'required'    => 'Veuillez renseigner votre adresse e-mail.',
                    'valid_email' => 'L’adresse e-mail saisie n’est pas valide.'
                ],
                'question' => [
                    'required'   => 'Veuillez formuler votre question.',
                ],
            ]))
            {
                // Formulaire non valide → retour au formulaire
                return view('menu_visiteur')
                     . view('templates/haut', ['titre' => $data['titre']])
                     . view('message/message_formulaire_contact', $data)
                     . view('templates/bas');
            }

            // Si valide insertion et génération du code
            $recuperation = $this->validator->getValidated();
            $data['code'] = $model->insert_message($recuperation);
        }

         return view('menu_visiteur')
              . view('templates/haut', ['titre' => $data['titre']])
              . view('message/message_formulaire_contact', $data)
              . view('templates/bas');
    }


    public function gestion()
    {
        $data['titre'] = "Gestion des demandes d'information";

        return view('menu_visiteur')
             . view('templates/haut', $data)
             . view('message/message_gestion', $data)
             . view('templates/bas');
    }

public function voir($id)
{
    $session = session();

    if (! $session->has('user') || $session->get('role') !== 'A') {
        return redirect()->to('/compte/connecter');
    }

    $model = model(Db_model::class);
    $message = $model->get_message($id);

    if (!$message) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Message introuvable");
    }

    return view('admin/menu_administrateur')
        . view('templates/haut_admin')
        . view('message/voir_message', ['message' => $message])
        . view('templates/bas_admin');
}









}

//A7K9D2F3G6H1J8L0Q5XZ


//UPDATE t_actualite_act SET act_etat = 'E' WHERE act_id = 11;



?>




