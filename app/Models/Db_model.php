<?php
/**
 * --------------------------------------------------------------------
 * Modèle principal de gestion de la base de données (Db_model)
 * --------------------------------------------------------------------
 * Fichier : app/Models/Db_model.php
 * Auteur  : MZE Ghassan James
 * Créé le : Novembre 2025
 * Cours   : Développement Web côté Serveur (L3 Informatique - UBO)
 * 
 * --------------------------------------------------------------------
 * Dernière mise à jour : 18 Novembre 2025
 * --------------------------------------------------------------------
 * Rôle :
 *  - Contient toutes les requêtes SQL utilisées dans le projet
 *  - Organise les accès BDD : comptes, profils, actualités, messages,
 *    salles, réservations, indisponibilités et dashboard.
 *  - Utilise db_connect() fourni par CodeIgniter.
 * --------------------------------------------------------------------
 */

namespace App\Models;
use CodeIgniter\Model;

class Db_model extends Model {

    protected $db; // Instance de connexion MySQL/MariaDB

    /**
     * Constructeur
     * Initialise la connexion BDD via CodeIgniter.
     */
    public function __construct() {
        $this->db = db_connect();
    }



    /************************************************************
     *                       GET - COMPTES
     ************************************************************/

    /**
     * Récupère tous les comptes (uniquement pseudos)
     */
    public function get_all_compte() {
        $resultat = $this->db->query("SELECT cpt_pseudo FROM t_compte_cpt;");
        return $resultat->getResultArray();
    }

    /**
     * Liste les membres (sauf l’utilisateur connecté)
     */
    public function get_all_adherents($pseudo) {
        $sql = "
            SELECT 
                cpt_pseudo,
                pfl_email,
                pfl_nom,
                pfl_prenom,
                pfl_telephone
            FROM t_compte_cpt
            JOIN t_profil_pfl USING (cpt_pseudo)
            WHERE cpt_pseudo != ?
            ORDER BY pfl_nom ASC;
        ";
        return $this->db->query($sql, [$pseudo])->getResultArray();
    }

    /**
     * Récupère comptes + profils (admin)
     */
    public function get_all_comptes_profils() {
        $sql = "
            SELECT 
                c.cpt_pseudo,
                c.cpt_etat,
                p.pfl_nom,
                p.pfl_prenom,
                p.pfl_email,
                p.pfl_role
            FROM t_compte_cpt c
            LEFT JOIN t_profil_pfl p ON c.cpt_pseudo = p.cpt_pseudo
            ORDER BY 
                c.cpt_etat DESC,
                c.cpt_pseudo ASC
        ";
        return $this->db->query($sql)->getResultArray();
    }

    /**
     * Nombre de comptes total
     */
    public function get_nb_comptes() {
        $res = $this->db->query("SELECT COUNT(*) AS nb FROM t_compte_cpt;");
        return $res->getRow();
    }

    /**
     * Infos du profil d’un utilisateur
     */
    public function get_info_profil($pseudo) {
        $sql = "SELECT * FROM t_profil_pfl WHERE cpt_pseudo = ?";
        return $this->db->query($sql, [$pseudo])->getRowArray();
    }



    /************************************************************
     *                       GET - ACTUALITÉS
     ************************************************************/

    /**
     * Actualité unique (id)
     */
    public function get_actualite($numero) {
        $sql = "SELECT * FROM t_actualite_act WHERE act_id = ?";
        return $this->db->query($sql, [$numero])->getRow();
    }

    /**
     * Actualités publiées (home)
     */
    public function get_all_actualites() {
        $sql = "
            SELECT act_id, act_titre, act_contenu, act_date_publication, cpt_pseudo
            FROM t_actualite_act 
            WHERE act_etat = 'E'  
            ORDER BY act_date_publication DESC 
            LIMIT 5;
        ";
        return $this->db->query($sql)->getResultArray();
    }



    /************************************************************
     *                 GET / SET - MESSAGES VISITEURS
     ************************************************************/

    /**
     * Récupère un message par code de suivi
     */
    public function get_suivie($code) {
        return $this->db->query("SELECT * FROM t_message_msg WHERE msg_code = ?;", [$code])->getRow();
    }

    /**
     * Insère un message (contact public)
     * Génère un code unique de suivi
     */
    public function insert_message($saisie) {

        $code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 20);

        $sql = "
            INSERT INTO t_message_msg (msg_email, msg_titre, msg_contenu, msg_code, msg_date)
            VALUES (?, ?, ?, ?, NOW());
        ";

        $this->db->query($sql, [
            $saisie['email'],
            $saisie['sujet'],
            $saisie['question'],
            $code
        ]);

        return $code;
    }

    /**
     * Liste tous les messages visiteurs (admin)
     */
    public function get_all_messages() {
        return $this->db->query("SELECT * FROM t_message_msg ORDER BY msg_date DESC;")->getResultArray();
    }

    /**
     * Message unique (admin)
     */
    public function get_message($id) {
        return $this->db->query("SELECT * FROM t_message_msg WHERE msg_id = ?;", [$id])->getRowArray();
    }

    /**
     * Ajout de la réponse d’un admin
     */
    public function update_message_response($id, $admin, $reponse) {
        $sql = "
            UPDATE t_message_msg
            SET msg_reponse = ?, 
                cpt_pseudo = ?
            WHERE msg_id = ?;
        ";
        return $this->db->query($sql, [$reponse, $admin, $id]);
    }



    /************************************************************
     *                      SET - COMPTES
     ************************************************************/

    /**
     * Création d’un compte.
     * Le mot de passe est haché avec l'API native de PHP.
     */
    public function set_compte($saisie) {
        $hash = password_hash($saisie['mdp'], PASSWORD_DEFAULT);

        $sql = "
            INSERT INTO t_compte_cpt (cpt_pseudo, cpt_mdp, cpt_etat)
            VALUES (?, ?, 'A');
        ";

        return $this->db->query($sql, [$saisie['pseudo'], $hash]);
    }

    /**
     * Vérifie une connexion utilisateur.
     */
    public function connect_compte($u, $p) {
        $sql = "
            SELECT cpt_mdp
            FROM t_compte_cpt
            WHERE cpt_pseudo = ? AND cpt_etat = 'A'
            LIMIT 1
        ";

        $row = $this->db->query($sql, [$u])->getRowArray();

        return $row !== null && password_verify($p, $row['cpt_mdp']);
    }



    /************************************************************
     *                      PROFIL - UPDATE
     ************************************************************/

    /**
     * Mise à jour du profil utilisateur
     * Le mot de passe est haché avec l'API native de PHP.
     */
    public function update_profil($pseudo, $nom, $prenom, $email, $mdp = "") {

        // Mise à jour du profil
        $sql = "
            UPDATE t_profil_pfl 
            SET pfl_nom = ?, pfl_prenom = ?, pfl_email = ?
            WHERE cpt_pseudo = ?
        ";
        $this->db->query($sql, [$nom, $prenom, $email, $pseudo]);

        // Mise à jour du mot de passe si fourni
        if ($mdp != "") {
            $hash = password_hash($mdp, PASSWORD_DEFAULT);
            $sql2 = "UPDATE t_compte_cpt SET cpt_mdp = ? WHERE cpt_pseudo = ?";
            $this->db->query($sql2, [$hash, $pseudo]);
        }
    }



    /************************************************************
     *                      SALLES & CRÉNEAUX
     ************************************************************/

    /**
     * Récupère toutes les salles
     */
    public function get_all_salles() {
        return $this->db->query("
            SELECT sal_id, sal_nom, sal_photo, sal_jauge_max, sal_jauge_min, sal_pdf
            FROM t_salle_sal
            ORDER BY sal_nom ASC
        ")->getResultArray();
    }

    /**
     * Création salle (admin)
     */
    public function insert_salle($nom, $photo, $min, $max, $pdf) {
        $sql = "
            INSERT INTO t_salle_sal (sal_nom, sal_photo, sal_jauge_min, sal_jauge_max, sal_pdf)
            VALUES (?, ?, ?, ?, ?)
        ";
        return $this->db->query($sql, [$nom, $photo, $min, $max, $pdf]);
    }

    /**
     * Suppression salle
     */
    public function delete_salle($id) {
        return $this->db->query("DELETE FROM t_salle_sal WHERE sal_id = ?", [$id]);
    }



    /************************************************************
     *                 RÉSERVATIONS & INDISPONIBILITÉS
     ************************************************************/

    /**
     * Réservations futures d’un membre
     */
    public function get_reservations_avenir($pseudo) {
        $sql = "
            SELECT 
                crn.crn_id,
                crn.crn_date,
                crn.crn_lieu,
                sal.sal_nom,
                sal.sal_photo
            FROM t_inscription_ins ins
            JOIN t_creneau_crn crn ON ins.crn_id = crn.crn_id
            JOIN t_salle_sal sal ON crn.sal_id = sal.sal_id
            WHERE ins.cpt_pseudo = ?
            AND crn.crn_date > NOW()
            ORDER BY crn.crn_date ASC
        ";
        return $this->db->query($sql, [$pseudo])->getResultArray();
    }

    /**
     * Réservations (admin/membre) triées par salle + créneau
     */
    public function reservations_par_jour($date) {
        $sql = "
            SELECT 
                c.crn_id,
                c.crn_date,
                s.sal_id,
                s.sal_nom,
                s.sal_photo,
                s.sal_jauge_max,
                GROUP_CONCAT(pi.cpt_pseudo SEPARATOR ', ') AS participants
            FROM t_creneau_crn c
            JOIN t_salle_sal s ON c.sal_id = s.sal_id
            LEFT JOIN t_inscription_ins i ON i.crn_id = c.crn_id
            LEFT JOIN t_profil_pfl pi ON pi.cpt_pseudo = i.cpt_pseudo
            WHERE DATE(c.crn_date) = ?
            GROUP BY c.crn_id
            ORDER BY s.sal_nom ASC, c.crn_date ASC
        ";
        return $this->db->query($sql, [$date])->getResultArray();
    }

    /**
     * Réservations (admin)
     */
    public function get_reservations_admin($date) {
        $sql = "
            SELECT 
                c.crn_id,
                c.crn_date,
                s.sal_id,
                s.sal_nom,
                s.sal_photo,
                s.sal_jauge_max,
                GROUP_CONCAT(pi.cpt_pseudo SEPARATOR ', ') AS participants
            FROM t_creneau_crn c
            JOIN t_salle_sal s ON c.sal_id = s.sal_id
            LEFT JOIN t_inscription_ins i ON i.crn_id = c.crn_id
            LEFT JOIN t_profil_pfl pi ON pi.cpt_pseudo = i.cpt_pseudo
            WHERE DATE(c.crn_date) = ?
            GROUP BY c.crn_id
            ORDER BY s.sal_nom ASC, c.crn_date ASC
        ";
        return $this->db->query($sql, [$date])->getResultArray();
    }

    /**
     * Indisponibilités (admin)
     */
    public function get_indispos_admin($date) {
        $sql = "
            SELECT 
                i.ind_id,
                i.ind_intitule,
                DATE_FORMAT(i.ind_date_debut, '%H:%i') AS debut,
                DATE_FORMAT(i.ind_date_fin, '%H:%i') AS fin,
                s.sal_nom
            FROM t_indisponibilite_ind i
            JOIN t_etat_eta e ON e.ind_id = i.ind_id
            JOIN t_salle_sal s ON s.sal_id = e.sal_id
            WHERE DATE(i.ind_date_debut) = ?
            ORDER BY s.sal_nom ASC, i.ind_date_debut ASC
        ";
        return $this->db->query($sql, [$date])->getResultArray();
    }



    /************************************************************
     *                      DASHBOARD
     ************************************************************/

    public function count_actus()     { return $this->db->table('t_actualite_act')->countAll(); }
    public function count_messages()  { return $this->db->table('t_message_msg')->countAll(); }
    public function count_salles()    { return $this->db->table('t_salle_sal')->countAll(); }
    public function count_comptes()   { return $this->db->table('t_compte_cpt')->countAll(); }

}
