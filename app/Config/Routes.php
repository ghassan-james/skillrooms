<?php

use CodeIgniter\Router\RouteCollection;

/**
 * -----------------------------------------------------------
 * Définition des routes du projet
 * Projet : Application Web RESAWEB - L3 UBO
 * Auteur : MZE Ghassan James
 * -----------------------------------------------------------
 * Organisation :
 *   1. Accueil
 *   2. Comptes & Profils
 *   3. Actualités
 *   4. Messages visiteurs
 *   5. Gestion des Salles (Admin)
 *   6. Réservations Admin
 *   7. Contact Admin
 *   8. Réservations Membre
 * -----------------------------------------------------------
 */

/* ===========================================================
 * 1 ACCUEIL
 * =========================================================== */
use App\Controllers\Accueil;
$routes->get('/', [Accueil::class, 'afficher']);



/* ===========================================================
 * 2 COMPTES & PROFILS
 * =========================================================== */
use App\Controllers\Compte;

// Liste / création
$routes->get('compte/lister', [Compte::class, 'lister']);
$routes->get('compte/creer', [Compte::class, 'creer']);
$routes->post('compte/creer', [Compte::class, 'creer']);

// Connexion / déconnexion
$routes->get('compte/connecter', [Compte::class, 'connecter']);
$routes->post('compte/connecter', [Compte::class, 'connecter']);
$routes->get('compte/deconnecter', [Compte::class, 'deconnecter']);

// Profil + modification
$routes->get('compte/afficher_profil', [Compte::class, 'afficher_profil']);
$routes->get('compte/modifier', [Compte::class, 'modifier']);
$routes->post('compte/modifier_valider', [Compte::class, 'modifier_valider']);

// Accueil privé
$routes->get('compte/accueil', [Compte::class, 'accueil']);

// Administration comptes/profils
$routes->get('compte/comptes_admin', 'Compte::comptes_admin');
$routes->get('compte/ajouter_invite', 'Compte::ajouter_invite');
$routes->post('compte/ajouter_invite_action', 'Compte::ajouter_invite_action');



/* ===========================================================
 * 3 ACTUALITÉS
 * =========================================================== */
// Les actualités sont affichées sur la page d'accueil via Accueil::afficher().
// Les anciennes routes dédiées ont été retirées car aucun contrôleur Actualite
// n'est présent dans cette version du projet.

/* ===========================================================
 * 4 MESSAGES VISITEURS (CONTACT)
 * =========================================================== */
use App\Controllers\Message;

$routes->get('message/gestion', [Message::class, 'gestion']);
$routes->get('message/contact', [Message::class, 'contact']);
$routes->post('message/contact', [Message::class, 'contact']);

$routes->get('message/formulaire', [Message::class, 'formulaire']);
$routes->post('message/formulaire', [Message::class, 'formulaire']);

$routes->get('message/suivi/(:alphanum)', [Message::class, 'suivi']);



/* ===========================================================
 * 5 GESTION DES SALLES (ADMIN)
 * =========================================================== */
use App\Controllers\Salle;

// Liste des salles
$routes->get('salle/gestion', [Salle::class, 'gestion']);

// Ajouter salle
$routes->get('salle/ajouter', [Salle::class, 'ajouter']);
$routes->post('salle/ajouter', [Salle::class, 'ajouter']);

// Supprimer salle
$routes->get('salle/supprimer/(:num)', [Salle::class, 'supprimer/$1']);



/* ===========================================================
 * 6 ADMIN – RÉSERVATIONS
 * =========================================================== */
use App\Controllers\AdminReservation;

$routes->get('admin/reservations',            [AdminReservation::class, 'choisir_jour']);
$routes->post('admin/reservations',           [AdminReservation::class, 'choisir_jour']);
$routes->get('admin/reservations/jour/(:any)',[AdminReservation::class, 'voir_jour']);



/* ===========================================================
 * 7 ADMIN – CONTACT (MESSAGES VISITEUR)
 * =========================================================== */
use App\Controllers\Contact;

$routes->get('admin/contact', [Contact::class, 'liste']);
$routes->get('admin/contact/voir/(:num)', [Contact::class, 'voir/$1']);

// Répondre à un message
$routes->post('admin/contact/repondre/(:num)', [Contact::class, 'repondre/$1']);



/* ===========================================================
 * 8 RÉSERVATIONS – MEMBRE
 * =========================================================== */
use App\Controllers\Reservation;

// Choix du jour
$routes->get('membre/reservations', [Reservation::class, 'choisir_jour']);
$routes->post('membre/reservations', [Reservation::class, 'choisir_jour']);

// Affichage du planning
$routes->get('membre/reservations/jour/(:any)', [Reservation::class, 'voir_jour']);



/* ===========================================================
 * 9 LISTE DES MEMBRES
 * =========================================================== */
use App\Controllers\Membre;
$routes->get('membre/liste', [Membre::class, 'liste']);
