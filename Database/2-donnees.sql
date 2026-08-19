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

INSERT INTO `employes` (`nom`,`prenom`,`telephone`,`email`,`mot_de_passe`,`role`) VALUES
    ('Doe','John','0600000000','john.doe@email.fr''$2y$10$T7jh/WYIcGnX6XKmwlDvE.5Xcp0C3NZHxldH0pHveE9/5/829VgWe','ADMIN'),
    ('Martin','Alexandre','0612345678','alexandre.martin@email.fr','$2y$10$.raKjVI2iXrtMUIFPASFYOf2oQsjMb2ZCtlj7XqnR85ZivzYF6RWa','USER'),
    ('Dubois','Sophie','0698765432','sophie.dubois@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER'),
    ('Bernard','Julien','0622446688','julien.bernard@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER'),
    ('Moreau','Camille','0611223344','camille.moreau@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER'),
    ('Lefèvre','Lucie','0777889900','lucie.lefevre@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER'),
    ('Leroy','Thomas','0655443322','thomas.leroy@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER'),
    ('Roux','Chloé','0633221199','chloe.roux@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER'),
    ('Petit','Maxime','0766778899','maxime.petit@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER'),
    ('Garnier','Laura','0688776655','laura.garnier@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER'),
    ('Dupuis','Antoine','0744556677','antoine.dupuis@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER'),
    ('Lefebvre','Emma','0699887766','emma.lefebvre@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER'),
    ('Fontaine','Louis','0655667788','louis.fontaine@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER'),
    ('Chevalier','Clara','0788990011','clara.chevalier@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER'),
    ('Robin','Nicolas','0644332211','nicolas.robin@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER'),
    ('Gauthier','Marine','0677889922','marine.gauthier@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER'),
    ('Fournier','Pierre','0722334455','pierre.fournier@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER'),
    ('Girard','Sarah','0688665544','sarah.girard@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER'),
    ('Lambert','Hugo','0611223366','hugo.lambert@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER'),
    ('Masson','Julie','0733445566','julie.masson@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER'),
    ('Henry','Arthur','0666554433','arthur.henry@email.fr','$2y$10$8AinQ2UOImRALzWIOxIoNOCHV.ylol.19M6IYSU/bpAISxl2mN3nG','USER');