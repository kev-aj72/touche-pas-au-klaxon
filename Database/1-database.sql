-- ==================================================================
-- Projet : Touche pas au klaxon
-- Description : création de la base de données et des tables
-- ==================================================================


CREATE DATABASE IF NOT EXISTS touche_pas_au_klaxon
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE touche_pas_au_klaxon;
-- ==================================================================

--
-- Structure de la table `employes`
--

CREATE TABLE IF NOT EXISTS `employes` (
    `id_employe` INT NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR(100) NOT NULL,
    `prenom` VARCHAR(100) NOT NULL,
    `telephone` VARCHAR(20) NOT NULL,
    `email` VARCHAR(180) NOT NULL,
    `mot_de_passe` VARCHAR(255) NOT NULL,
    `role` VARCHAR(20) NOT NULL DEFAULT 'USER',

    PRIMARY KEY (`id_employe`),
    UNIQUE KEY `employes_email` (`email`),
     CONSTRAINT chk_employes_role CHECK (role IN ('USER', 'ADMIN'))
) ENGINE=InnoDB;

-- ==================================================================

--
-- Structure de la table `agences`
--

CREATE TABLE IF NOT EXISTS agences (
    `id_agence` INT NOT NULL AUTO_INCREMENT,
    `ville` VARCHAR(100) NOT NULL,

    PRIMARY KEY (`id_agence`),
    UNIQUE KEY `ville_agence` (`ville`)
) ENGINE=InnoDB;

-- ==================================================================

--
-- Structure de la table `trajets`
--

CREATE TABLE IF NOT EXISTS trajets (
    `id_trajet` INT AUTO_INCREMENT,
    `date_heure_depart` DATETIME NOT NULL,
    `date_heure_arrivee` DATETIME NOT NULL,
    `nombre_places_total` TINYINT UNSIGNED NOT NULL,
    `nombre_places_disponibles` TINYINT UNSIGNED NOT NULL,
    `id_employe` INT NOT NULL,
    `id_agence_depart` INT NOT NULL,
    `id_agence_arrivee` INT NOT NULL,

    PRIMARY KEY (`id_trajet`),
    CONSTRAINT chk_trajets_dates
        CHECK (date_heure_arrivee > date_heure_depart),

    CONSTRAINT chk_trajets_agences
        CHECK (id_agence_arrivee <> id_agence_depart),

    CONSTRAINT chk_trajets_places_total
        CHECK (nombre_places_total > 0),

    CONSTRAINT chk_trajets_places_disponibles
        CHECK (nombre_places_disponibles <= nombre_places_total),

    CONSTRAINT fk_trajets_employe
        FOREIGN KEY (id_employe)
        REFERENCES employes (id_employe)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_trajets_agence_depart
        FOREIGN KEY (id_agence_depart)
        REFERENCES agences (id_agence)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_trajets_agence_arrivee
        FOREIGN KEY (id_agence_arrivee)
        REFERENCES agences (id_agence)
        ON UPDATE CASCADE
        ON DELETE RESTRICT

) ENGINE=InnoDB;