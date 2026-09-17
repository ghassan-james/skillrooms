<?php
namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Compte extends BaseController
{
    /* ============================================================
        CONSTRUCTEUR
    ============================================================ */
    public function __construct()
    {
        helper('form');
    }

    /* ============================================================
        LISTE DES COMPTES
    ============================================================ *
    public function lister()
    {
        $model = model(Db_model::class);

        $data['titre']   = "Liste de tous les comptes";
        $data['logins']  = $model->get_all_compte();
        $data['nb']      = $model->get_nb_comptes();

        return view('menu_visiteur')
            . view('templates/haut', $data)
            . view('affichage_comptes')
            . view('templates/bas');
    }

    /* ============================================================
        CREATION DE COMPTE
    ============================================================ */
    public function creer()
    {
        helper('form');
        $model = model(Db_model::class);

        if ($this->request->getMethod() == "POST")
        {
            if (! $this->validate([
                'pseudo' => 'required|max_length[255]|min_length[2]',
                'mdp'    => 'required|max_length[255]|min_length[8]'
            ],
            [
                'pseudo' => [
                    'required'   => 'Veuillez entrer un pseudo pour le compte !',
                    'min_length' => 'Le pseudo est trop court (2 caractères minimum).'
                ],
                'mdp' => [
                    'required'   => 'Veuillez entrer un mot de passe !',
                    'min_length' => 'Le mot de passe saisi est trop court (8 caractères minimum).'
                ],
            ]))
            {
                return view('templates/haut', ['titre' => 'Créer un compte'])
                    . view('compte/compte_creer')
                    . view('templates/bas');
            }

            // Ajout compte
            $recup = $this->validator->getValidated();
            $model->set_compte($recup);

            $data['le_compte'] = $recup['pseudo'];
            $data['le_message'] = "Nouveau nombre de comptes : ";
            $data['le_total'] = $model->get_nb_comptes();

            return view('templates/haut', $data)
                . view('compte/compte_succes')
                . view('templates/bas');
        }

        return view('templates/haut', ['titre' => 'Créer un compte'])
            . view('compte/compte_creer')
            . view('templates/bas');
    }

    /* ============================================================
        CONNEXION
    ============================================================ */
    public function connecter()
    {
        $model = model(Db_model::class);

        if ($this->request->getMethod() == "POST")
        {
            if (! $this->validate([
                'pseudo' => 'required',
                'mdp'    => 'required'
            ]))
            {
                return view('menu_visiteur')
                    . view('templates/haut', ['titre' => 'Se connecter'])
                    . view('connexion/compte_connecter')
                    . view('templates/bas');
            }

            $username = $this->request->getVar('pseudo');
            $password = $this->request->getVar('mdp');

            if ($model->connect_compte($username, $password))
            {
                $role = $model->get_info_profil($username);

                $session = session();
                $session->set('user', $username);
                $session->set('role', $role['pfl_role']);

                return redirect()->to('/compte/accueil');
            }
            else
            {
                session()->setFlashdata('error', 
                    '<div class="alert alert-danger">Pseudo ou mot de passe incorrect.</div>'
                );

                return view('menu_visiteur')
                    . view('templates/haut', ['titre' => 'Se connecter'])
                    . view('connexion/compte_connecter')
                    . view('templates/bas');
            }
        }

        return view('menu_visiteur')
            . view('templates/haut', ['titre' => 'Se connecter'])
            . view('connexion/compte_connecter')
            . view('templates/bas');
    }

    /* ============================================================
        PAGE D'ACCUEIL ADMIN / MEMBRE
    ============================================================ */
    public function accueil()
    {
        $session = session();

        if (! $session->has('user'))
            return redirect()->to('/compte/connecter');

        $role = $session->get('role');

        /* ==== AJOUT DES DONNÉES POUR LES CARTES STATISTIQUES ==== */
        $model = model(Db_model::class);

        $data = [
            'nb_actus'    => $model->count_actus(),
            'nb_comptes'  => $model->count_comptes(),
            'nb_messages' => $model->count_messages(),
            'nb_salles'   => $model->count_salles()
        ];

        if ($role === 'A')
        {
            return view('admin/menu_administrateur')
                . view('templates/haut_admin')
                . view('connexion/compte_accueil', $data)
                . view('templates/bas_admin');
        }

        if ($role === 'J')
        {
            return view('membre/menu_menbre')
                . view('templates/haut_admin')
                . view('connexion/compte_accueil', $data)
                . view('templates/bas_admin');
        }

        return redirect()->to('/');
    }

    /* ============================================================
        PROFIL
    ============================================================ */
    public function afficher_profil()
    {
        $session = session();

        if (! $session->has('user'))
            return redirect()->to('/compte/connecter');

        $model = model(Db_model::class);
        $profil = $model->get_info_profil($session->get('user'));

        $data = [
            'profil' => $profil,
            'role'   => $session->get('role')
        ];

        $menu = ($session->get('role') === 'A') 
            ? 'admin/menu_administrateur'
            : 'membre/menu_menbre';

        return view($menu)
            . view('templates/haut_admin')
            . view('connexion/compte_profil', $data)
            . view('templates/bas_admin');
    }

    /* ============================================================
        MODIFIER PROFIL
    ============================================================ */
    public function modifier()
    {
        $session = session();

        if (! $session->has('user'))
            return redirect()->to('/compte/connecter');

        $model = model(Db_model::class);
        $profil = $model->get_info_profil($session->get('user'));

        $data = [
            'profil' => $profil,
            'role'   => $session->get('role')
        ];

        $menu = ($session->get('role') === 'A')
            ? 'admin/menu_administrateur'
            : 'membre/menu_menbre';

        return view($menu)
            . view('templates/haut_admin')
            . view('compte/compte_modifier', $data)
            . view('templates/bas_admin');
    }

    public function modifier_valider()
    {
        $session = session();
        if (! $session->has('user'))
            return redirect()->to('/compte/connecter');

        $nom     = $this->request->getPost('nom');
        $prenom  = $this->request->getPost('prenom');
        $email   = $this->request->getPost('email');
        $mdp     = $this->request->getPost('mdp');
        $confirm = $this->request->getPost('confirm');

        if (empty($nom) || empty($prenom) || empty($email)) {
            session()->setFlashdata('error', 'Champs de saisie vides !');
            return redirect()->to('/compte/modifier');
        }

        if (!empty($mdp) && $mdp !== $confirm) {
            session()->setFlashdata('error', 'Confirmation du mot de passe erronée !');
            return redirect()->to('/compte/modifier');
        }

        $model = model(Db_model::class);
        $model->update_profil($session->get('user'), $nom, $prenom, $email, $mdp);

        session()->setFlashdata('success', 'Profil mis à jour avec succès !');

        return redirect()->to('/compte/afficher_profil');
    }

    /* ============================================================
        ADMIN : LISTE COMPTES
    ============================================================ */
    public function comptes_admin()
    {
        $session = session();
        if (!$session->has('user') || $session->get('role') !== 'A')
            return redirect()->to('/compte/connecter');

        $model = model(Db_model::class);

        $data['comptes'] = $model->get_all_comptes_profils();

        return view('admin/menu_administrateur')
            . view('templates/haut_admin')
            . view('admin/comptes_gestion', $data)
            . view('templates/bas_admin');
    }

/* ============================================================
   ADMIN : AJOUT COMPTE INVITÉ
============================================================ */
public function ajouter_invite()
{
    $session = session();

    if (!$session->has('user') || $session->get('role') !== 'A')
        return redirect()->to('/compte/connecter');

    return view('admin/menu_administrateur')
        . view('templates/haut_admin')
        . view('admin/comptes_ajout_invite')
        . view('templates/bas_admin');
}


public function ajouter_invite_action()
{
    $session = session();

    if (!$session->has('user') || $session->get('role') !== 'A')
        return redirect()->to('/compte/connecter');

    helper('form');
    $model = model(Db_model::class);

    //Validation 
    $rules = [
        'pseudo' => 'required',
        'mdp'    => 'required|min_length[8]'
    ];

    $messages = [
        'pseudo' => [
            'required' => 'Veuillez entrer un pseudo !'
        ],
        'mdp' => [
            'required'   => 'Veuillez entrer un mot de passe !',
            'min_length' => 'Le mot de passe est trop court (8 caractères minimum).'
        ]
    ];

    // Si validation échoue → retour formulaire + affichage erreurs
    if (! $this->validate($rules, $messages)) {
        return redirect()->back()->withInput();
    }

    // 2Récupération des valeurs validées
    $pseudo = $this->request->getPost('pseudo');
    $mdp    = $this->request->getPost('mdp');

    // Vérification si pseudo déjà existant
    foreach ($model->get_all_compte() as $c) {
        if ($c['cpt_pseudo'] === $pseudo) {
            return redirect()
                ->back()
                ->withInput()
                ->with('erreur', 'Ce compte existe déjà !');
        }
    }
    // Insertion via le modèle (requête préparée + password_hash)
    $model->set_compte([
        'pseudo' => $pseudo,
        'mdp'    => $mdp,
    ]);

    $session->setFlashdata('success', 'Compte invité créé avec succès !');
    return redirect()->to('/compte/comptes_admin');
}



    /* ============================================================
        DECONNEXION
    ============================================================ */
    public function deconnecter()
    {
        $session=session();
        $session->destroy();
        return redirect()->to('/compte/connecter');
    }
}
