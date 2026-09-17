-- SkillRooms / RESAWEB - schéma de base de données
-- Version destinée au dépôt public GitHub.
-- Les données de démonstration, profils, e-mails, messages et identifiants
-- présents dans l'export de travail original ont volontairement été supprimés.

-- phpMyAdmin SQL Dump
-- version 5.2.1deb1+deb12u1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : dim. 30 nov. 2025 à 11:01
-- Version du serveur : 10.11.11-MariaDB-0+deb12u1-log
-- Version de PHP : 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `skillrooms`
--

DELIMITER $$
--
-- Procédures
--
CREATE PROCEDURE `maj_document_reunion` (IN `id_reunion` INT)   BEGIN
    DECLARE nb INT;
    DECLARE intitule_cr VARCHAR(200);
    DECLARE intitule_run VARCHAR(200);
    DECLARE nb_docs INT;

    -- Récupération du nombre de participants à la réunion
    SET nb = Nbpersonnes(id_reunion);

    -- Récupération du nom de la réunion
    SELECT run_intitule INTO intitule_run
    FROM t_reunion_run
    WHERE run_id = id_reunion;

    IF nb != -1 THEN
        -- Construction de l’intitulé du CR
        SET intitule_cr = CONCAT('CR ', intitule_run, ' - ', nb, ' participants');

        -- Vérifier si un document existe déjà pour cette réunion
        SELECT COUNT(*) INTO nb_docs
        FROM t_document_doc
        WHERE run_id = id_reunion;

        -- Si aucun document n’existe → INSERT
        IF nb_docs = 0 THEN
        ELSE
            -- Sinon → UPDATE
            UPDATE t_document_doc
            SET doc_intitule = intitule_cr
            WHERE run_id = id_reunion;
        END IF;
    END IF;
END$$

--
-- Fonctions
--
CREATE FUNCTION `MailReu` (`reu` INT) RETURNS TEXT CHARSET utf8mb4 COLLATE utf8mb4_general_ci DETERMINISTIC BEGIN
    DECLARE list TEXT;

    -- Si la réunion n'existe pas, renvoyer -1
    IF NOT EXISTS (SELECT 1 FROM t_reunion_run WHERE run_id = reu) THEN
        RETURN NULL;
    END IF;

    -- Liste les email des participants 
    SELECT GROUP_CONCAT(pfl_email) INTO list 
    FROM t_profil_pfl 
    JOIN t_participation_par 
    USING (cpt_pseudo)
    WHERE run_id = reu;

    RETURN list;
END$$

CREATE FUNCTION `Nbpersonnes` (`reu` INT) RETURNS INT(11) DETERMINISTIC BEGIN
    DECLARE nb INT;

    -- Si la réunion n'existe pas, renvoyer -1
    IF NOT EXISTS (SELECT 1 FROM t_reunion_run WHERE run_id = reu) THEN
        RETURN -1;
    END IF;

    -- Compter le nombre d'inscrits à la reunion
    SELECT COUNT(*) INTO nb
    FROM t_participation_par
    WHERE run_id = reu;

    RETURN nb;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `t_actualite_act`
--

CREATE TABLE `t_actualite_act` (
  `act_id` int(11) NOT NULL,
  `act_titre` varchar(100) NOT NULL,
  `act_description` varchar(300) NOT NULL,
  `act_contenu` varchar(500) NOT NULL,
  `act_date_publication` datetime NOT NULL,
  `act_etat` char(1) NOT NULL DEFAULT 'D',
  `cpt_pseudo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_actualite_act`
--


-- --------------------------------------------------------

--
-- Structure de la table `t_compte_cpt`
--

CREATE TABLE `t_compte_cpt` (
  `cpt_pseudo` varchar(200) NOT NULL,
  `cpt_mdp` varchar(255) NOT NULL,
  `cpt_etat` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_compte_cpt`
--


-- --------------------------------------------------------

--
-- Structure de la table `t_creneau_crn`
--

CREATE TABLE `t_creneau_crn` (
  `crn_id` int(11) NOT NULL,
  `crn_date` datetime NOT NULL,
  `crn_lieu` varchar(60) NOT NULL,
  `sal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_creneau_crn`
--


-- --------------------------------------------------------

--
-- Structure de la table `t_document_doc`
--

CREATE TABLE `t_document_doc` (
  `doc_id` int(11) NOT NULL,
  `doc_intitule` varchar(100) NOT NULL,
  `doc_pdf` varchar(300) NOT NULL,
  `run_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_document_doc`
--


--
-- Déclencheurs `t_document_doc`
--
DELIMITER $$
CREATE TRIGGER `ajout_date_mise_en_ligne` BEFORE UPDATE ON `t_document_doc` FOR EACH ROW BEGIN
    -- Si on met en ligne un PDF
    IF OLD.doc_pdf LIKE 'CR en attente' THEN
        IF NEW.doc_pdf LIKE '%.pdf' THEN
            SET NEW.doc_intitule = CONCAT(
                OLD.doc_intitule,
                ' - CR mis en ligne le ',
                CURDATE()
            );
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `t_etat_eta`
--

CREATE TABLE `t_etat_eta` (
  `sal_id` int(11) NOT NULL,
  `ind_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_etat_eta`
--


-- --------------------------------------------------------

--
-- Structure de la table `t_indisponibilite_ind`
--

CREATE TABLE `t_indisponibilite_ind` (
  `ind_id` int(11) NOT NULL,
  `ind_date_debut` date NOT NULL,
  `ind_date_fin` date DEFAULT NULL,
  `ind_intitule` varchar(100) NOT NULL,
  `ind_com` varchar(200) DEFAULT NULL,
  `mot_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_indisponibilite_ind`
--


-- --------------------------------------------------------

--
-- Structure de la table `t_inscription_ins`
--

CREATE TABLE `t_inscription_ins` (
  `cpt_pseudo` varchar(45) NOT NULL,
  `crn_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_inscription_ins`
--


-- --------------------------------------------------------

--
-- Structure de la table `t_message_msg`
--

CREATE TABLE `t_message_msg` (
  `msg_id` int(11) NOT NULL,
  `msg_email` varchar(200) NOT NULL,
  `msg_titre` varchar(100) NOT NULL,
  `msg_contenu` varchar(500) NOT NULL,
  `msg_code` char(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `msg_date` date NOT NULL,
  `msg_reponse` varchar(500) NOT NULL,
  `cpt_pseudo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_message_msg`
--


-- --------------------------------------------------------

--
-- Structure de la table `t_motif_mot`
--

CREATE TABLE `t_motif_mot` (
  `mot_id` int(11) NOT NULL,
  `mot_intitule` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_motif_mot`
--


-- --------------------------------------------------------

--
-- Structure de la table `t_participation_par`
--

CREATE TABLE `t_participation_par` (
  `cpt_pseudo` varchar(45) NOT NULL,
  `run_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_participation_par`
--


--
-- Déclencheurs `t_participation_par`
--
DELIMITER $$
CREATE TRIGGER `maj_doc_apres_inscription` AFTER INSERT ON `t_participation_par` FOR EACH ROW BEGIN
    CALL maj_document_reunion(NEW.run_id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `t_profil_pfl`
--

CREATE TABLE `t_profil_pfl` (
  `pfl_nom` varchar(60) NOT NULL,
  `pfl_prenom` varchar(60) NOT NULL,
  `pfl_role` char(1) NOT NULL,
  `pfl_date_naissance` date NOT NULL,
  `pfl_email` varchar(200) NOT NULL,
  `pfl_telephone` varchar(12) NOT NULL,
  `pfl_fix` varchar(20) NOT NULL,
  `vil_id` int(11) NOT NULL,
  `cpt_pseudo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_profil_pfl`
--


--
-- Déclencheurs `t_profil_pfl`
--
DELIMITER $$
CREATE TRIGGER `gestion_suppression_admin` BEFORE DELETE ON `t_profil_pfl` FOR EACH ROW BEGIN
    DECLARE admin_principal VARCHAR(200);

    -- Vérifier que le profil supprimé est un administrateur
    IF OLD.pfl_role = 'A' THEN
        
        -- Supprimer toutes les actualités créées
        DELETE FROM t_actualite_act
        WHERE cpt_pseudo = OLD.cpt_pseudo;

        -- Réassigner ses réponses à l'administrateur principal
        UPDATE t_reponse_rep
        SET cpt_pseudo = principal
        WHERE cpt_pseudo = OLD.cpt_pseudo;

    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `t_reunion_run`
--

CREATE TABLE `t_reunion_run` (
  `run_id` int(11) NOT NULL,
  `run_intitule` varchar(100) NOT NULL,
  `run_bilan` varchar(500) DEFAULT NULL,
  `run_date` datetime NOT NULL,
  `run_lieu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_reunion_run`
--


--
-- Déclencheurs `t_reunion_run`
--
DELIMITER $$
CREATE TRIGGER `nettoyage_avant_suppression_reunion` BEFORE DELETE ON `t_reunion_run` FOR EACH ROW BEGIN
    -- Supprimer les participations liées
    DELETE FROM t_participation_par WHERE run_id = OLD.run_id;

    -- Supprimer les documents liés
    DELETE FROM t_document_doc WHERE run_id = OLD.run_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `t_salle_sal`
--

CREATE TABLE `t_salle_sal` (
  `sal_id` int(11) NOT NULL,
  `sal_nom` varchar(60) NOT NULL,
  `sal_photo` varchar(200) NOT NULL,
  `sal_jauge_max` char(1) NOT NULL,
  `sal_jauge_min` char(1) NOT NULL,
  `sal_pdf` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_salle_sal`
--


--
-- Déclencheurs `t_salle_sal`
--
DELIMITER $$
CREATE TRIGGER `trg_salle_photo_default_insert` BEFORE INSERT ON `t_salle_sal` FOR EACH ROW BEGIN
    IF NEW.sal_photo IS NULL OR NEW.sal_photo = '' THEN
        SET NEW.sal_photo = 'default.png';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_salle_photo_default_update` BEFORE UPDATE ON `t_salle_sal` FOR EACH ROW BEGIN
    IF NEW.sal_photo IS NULL OR NEW.sal_photo = '' THEN
        SET NEW.sal_photo = 'default.png';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `t_ville_vil`
--

CREATE TABLE `t_ville_vil` (
  `vil_id` int(11) NOT NULL,
  `vil_code_postal` varchar(5) NOT NULL,
  `vil_nom` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_ville_vil`
--


--
-- Index pour les tables déchargées
--

--
-- Index pour la table `t_actualite_act`
--
ALTER TABLE `t_actualite_act`
  ADD PRIMARY KEY (`act_id`,`cpt_pseudo`),
  ADD KEY `fk_t_actualite_act_t_compte_cpt1_idx` (`cpt_pseudo`);

--
-- Index pour la table `t_compte_cpt`
--
ALTER TABLE `t_compte_cpt`
  ADD PRIMARY KEY (`cpt_pseudo`),
  ADD UNIQUE KEY `cpt_pseudo_UNIQUE` (`cpt_pseudo`);

--
-- Index pour la table `t_creneau_crn`
--
ALTER TABLE `t_creneau_crn`
  ADD PRIMARY KEY (`crn_id`,`sal_id`),
  ADD KEY `fk_t_creneau_crn_t_salle_sal1_idx` (`sal_id`);

--
-- Index pour la table `t_document_doc`
--
ALTER TABLE `t_document_doc`
  ADD PRIMARY KEY (`doc_id`,`run_id`),
  ADD KEY `fk_t_document_doc_t_reunion_run1_idx` (`run_id`);

--
-- Index pour la table `t_etat_eta`
--
ALTER TABLE `t_etat_eta`
  ADD PRIMARY KEY (`sal_id`,`ind_id`),
  ADD KEY `fk_t_salle_sal_has_t_indisponibilite_ind_t_indisponibilite__idx` (`ind_id`),
  ADD KEY `fk_t_salle_sal_has_t_indisponibilite_ind_t_salle_sal1_idx` (`sal_id`);

--
-- Index pour la table `t_indisponibilite_ind`
--
ALTER TABLE `t_indisponibilite_ind`
  ADD PRIMARY KEY (`ind_id`),
  ADD KEY `fk_t_indisponibilite_ind_t_motif_mot1_idx` (`mot_id`);

--
-- Index pour la table `t_inscription_ins`
--
ALTER TABLE `t_inscription_ins`
  ADD PRIMARY KEY (`cpt_pseudo`,`crn_id`),
  ADD KEY `fk_t_compte_cpt_has_t_creneau_crn_t_creneau_crn1_idx` (`crn_id`),
  ADD KEY `fk_t_compte_cpt_has_t_creneau_crn_t_compte_cpt1_idx` (`cpt_pseudo`);

--
-- Index pour la table `t_message_msg`
--
ALTER TABLE `t_message_msg`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `fk_t_message_msg_t_compte_cpt1_idx` (`cpt_pseudo`);

--
-- Index pour la table `t_motif_mot`
--
ALTER TABLE `t_motif_mot`
  ADD PRIMARY KEY (`mot_id`);

--
-- Index pour la table `t_participation_par`
--
ALTER TABLE `t_participation_par`
  ADD PRIMARY KEY (`cpt_pseudo`,`run_id`),
  ADD KEY `fk_t_compte_cpt_has_t_reunion_run_t_reunion_run1_idx` (`run_id`),
  ADD KEY `fk_t_compte_cpt_has_t_reunion_run_t_compte_cpt1_idx` (`cpt_pseudo`);

--
-- Index pour la table `t_profil_pfl`
--
ALTER TABLE `t_profil_pfl`
  ADD PRIMARY KEY (`vil_id`,`cpt_pseudo`),
  ADD UNIQUE KEY `cpt_pseudo_UNIQUE` (`cpt_pseudo`),
  ADD KEY `fk_t_profil_pfl_t_ville_vil1_idx` (`vil_id`),
  ADD KEY `fk_t_profil_pfl_t_compte_cpt1_idx` (`cpt_pseudo`);

--
-- Index pour la table `t_reunion_run`
--
ALTER TABLE `t_reunion_run`
  ADD PRIMARY KEY (`run_id`);

--
-- Index pour la table `t_salle_sal`
--
ALTER TABLE `t_salle_sal`
  ADD PRIMARY KEY (`sal_id`);

--
-- Index pour la table `t_ville_vil`
--
ALTER TABLE `t_ville_vil`
  ADD PRIMARY KEY (`vil_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `t_actualite_act`
--
ALTER TABLE `t_actualite_act`
  MODIFY `act_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `t_creneau_crn`
--
ALTER TABLE `t_creneau_crn`
  MODIFY `crn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `t_document_doc`
--
ALTER TABLE `t_document_doc`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `t_message_msg`
--
ALTER TABLE `t_message_msg`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `t_motif_mot`
--
ALTER TABLE `t_motif_mot`
  MODIFY `mot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `t_reunion_run`
--
ALTER TABLE `t_reunion_run`
  MODIFY `run_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `t_salle_sal`
--
ALTER TABLE `t_salle_sal`
  MODIFY `sal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `t_ville_vil`
--
ALTER TABLE `t_ville_vil`
  MODIFY `vil_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `t_actualite_act`
--
ALTER TABLE `t_actualite_act`
  ADD CONSTRAINT `fk_t_actualite_act_t_compte_cpt1` FOREIGN KEY (`cpt_pseudo`) REFERENCES `t_compte_cpt` (`cpt_pseudo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_creneau_crn`
--
ALTER TABLE `t_creneau_crn`
  ADD CONSTRAINT `fk_t_creneau_crn_t_salle_sal1` FOREIGN KEY (`sal_id`) REFERENCES `t_salle_sal` (`sal_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_document_doc`
--
ALTER TABLE `t_document_doc`
  ADD CONSTRAINT `fk_t_document_doc_t_reunion_run1` FOREIGN KEY (`run_id`) REFERENCES `t_reunion_run` (`run_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_etat_eta`
--
ALTER TABLE `t_etat_eta`
  ADD CONSTRAINT `fk_t_salle_sal_has_t_indisponibilite_ind_t_indisponibilite_ind1` FOREIGN KEY (`ind_id`) REFERENCES `t_indisponibilite_ind` (`ind_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_t_salle_sal_has_t_indisponibilite_ind_t_salle_sal1` FOREIGN KEY (`sal_id`) REFERENCES `t_salle_sal` (`sal_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_indisponibilite_ind`
--
ALTER TABLE `t_indisponibilite_ind`
  ADD CONSTRAINT `fk_t_indisponibilite_ind_t_motif_mot1` FOREIGN KEY (`mot_id`) REFERENCES `t_motif_mot` (`mot_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_inscription_ins`
--
ALTER TABLE `t_inscription_ins`
  ADD CONSTRAINT `fk_t_compte_cpt_has_t_creneau_crn_t_compte_cpt1` FOREIGN KEY (`cpt_pseudo`) REFERENCES `t_compte_cpt` (`cpt_pseudo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_t_compte_cpt_has_t_creneau_crn_t_creneau_crn1` FOREIGN KEY (`crn_id`) REFERENCES `t_creneau_crn` (`crn_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_message_msg`
--
ALTER TABLE `t_message_msg`
  ADD CONSTRAINT `fk_t_message_msg_t_compte_cpt1` FOREIGN KEY (`cpt_pseudo`) REFERENCES `t_compte_cpt` (`cpt_pseudo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_participation_par`
--
ALTER TABLE `t_participation_par`
  ADD CONSTRAINT `fk_t_compte_cpt_has_t_reunion_run_t_compte_cpt1` FOREIGN KEY (`cpt_pseudo`) REFERENCES `t_compte_cpt` (`cpt_pseudo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_t_compte_cpt_has_t_reunion_run_t_reunion_run1` FOREIGN KEY (`run_id`) REFERENCES `t_reunion_run` (`run_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_profil_pfl`
--
ALTER TABLE `t_profil_pfl`
  ADD CONSTRAINT `fk_t_profil_pfl_t_compte_cpt1` FOREIGN KEY (`cpt_pseudo`) REFERENCES `t_compte_cpt` (`cpt_pseudo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_t_profil_pfl_t_ville_vil1` FOREIGN KEY (`vil_id`) REFERENCES `t_ville_vil` (`vil_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
