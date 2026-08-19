-- ============================================================
-- Projet : Touche pas au klaxon
-- Description : Ajout des données
-- ============================================================

USE touche_pas_au_klaxon;

--
-- Insertion des données de la table `agences`
--

INSERT INTO `agences` (`ville`) VALUES
    ('Paris'),
    ('Lyon'),
    ('Marseille'),
    ('Toulouse'),
    ('Nice'),
    ('Nantes'),
    ('Strasbourg'),
    ('Montpellier'),
    ('Bordeaux'),
    ('Lille'),
    ('Rennes'),
    ('Reims');

    -- ============================================================

--
-- Insertion des données de la table `employes`
--

INSERT INTO `employes` (`nom`,`prenom`,`telephone`,`email`,
                        `mot_de_passe`,`role`) VALUES

    ('Doe', 'John', '0600000000', 'john.doe@email.fr', 'Admin123!', 'ADMIN'),
    ('Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', 'User123!', 'USER'),
    ('Dubois', 'Sophie', '0698765432', 'sophie.dubois@email.fr', 'User123!', 'USER'),
    ('Bernard', 'Julien', '0622446688', 'julien.bernard@email.fr', 'User123!', 'USER'),
    ('Moreau', 'Camille', '0611223344', 'camille.moreau@email.fr', 'User123!', 'USER'),
    ('Lefèvre', 'Lucie', '0777889900', 'lucie.lefevre@email.fr', 'User123!', 'USER'),
    ('Leroy', 'Thomas', '0655443322', 'thomas.leroy@email.fr', 'User123!', 'USER'),
    ('Roux', 'Chloé', '0633221199', 'chloe.roux@email.fr', 'User123!', 'USER'),
    ('Petit', 'Maxime', '0766778899', 'maxime.petit@email.fr', 'User123!', 'USER'),
    ('Garnier', 'Laura', '0688776655', 'laura.garnier@email.fr', 'User123!', 'USER'),
    ('Dupuis', 'Antoine', '0744556677', 'antoine.dupuis@email.fr', 'User123!', 'USER'),
    ('Lefebvre', 'Emma', '0699887766', 'emma.lefebvre@email.fr', 'User123!', 'USER'),
    ('Fontaine', 'Louis', '0655667788', 'louis.fontaine@email.fr', 'User123!', 'USER'),
    ('Chevalier', 'Clara', '0788990011', 'clara.chevalier@email.fr', 'User123!', 'USER'),
    ('Robin', 'Nicolas', '0644332211', 'nicolas.robin@email.fr', 'User123!', 'USER'),
    ('Gauthier', 'Marine', '0677889922', 'marine.gauthier@email.fr', 'User123!', 'USER'),
    ('Fournier', 'Pierre', '0722334455', 'pierre.fournier@email.fr', 'User123!', 'USER'),
    ('Girard', 'Sarah', '0688665544', 'sarah.girard@email.fr', 'User123!', 'USER'),
    ('Lambert', 'Hugo', '0611223366', 'hugo.lambert@email.fr', 'User123!', 'USER'),
    ('Masson', 'Julie', '0733445566', 'julie.masson@email.fr', 'User123!', 'USER'),
    ('Henry', 'Arthur', '0666554433', 'arthur.henry@email.fr', 'User123!', 'USER');