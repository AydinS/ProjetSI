-- -----------------------------------------------------------------------------
--             Génération d'une base de données pour
--                      Oracle Version 10g
--                        (17/4/2014 16:38:28)
-- -----------------------------------------------------------------------------
--      Nom de la base : MLR5
--      Projet : 
--      Auteur : MIAGE
--      Date de dernière modification : 17/4/2014 16:37:57
-- -----------------------------------------------------------------------------

-- -----------------------------------------------------------------------------
--       TABLE : FICHIER
-- -----------------------------------------------------------------------------

CREATE TABLE FICHIER
   (
    ID_FICHIER int not null,
    ID_USER VARCHAR2(50) not null,
	Libelle VARCHAR2(50) not null,
    NOM VARCHAR2(50),
    DESCRIPTION VARCHAR2(50),
    PATHS VARCHAR(80),
    DOSSIER number(1),
    SERVICE VARCHAR2(50) not null,
    PARENTS int NOT NULL,   
    PRIMARY KEY (ID_FICHIER)  
   ) ;


-- -----------------------------------------------------------------------------
--       TABLE : DEMANDE_EXTENSION
-- -----------------------------------------------------------------------------

CREATE TABLE DEMANDE_EXTENSION
   (
    ID_DEMANDE int not null,
    ID_FICHIER int NOT NULL,
    ID_USER VARCHAR2(50) NOT NULL,
    STATUT VARCHAR2(50),
    PRIMARY KEY (ID_DEMANDE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : VALIDATION
-- -----------------------------------------------------------------------------

CREATE TABLE VALIDATION
   (
    ID_VALIDATION int not null,
    ID_FICHIER int NOT NULL,
    ID_USER VARCHAR2(50) NOT NULL,
    PRIMARY KEY (ID_VALIDATION)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : DROIT
-- -----------------------------------------------------------------------------

CREATE TABLE DROIT
   (
    ID_DROIT int not null,
    ID_USER VARCHAR2(50) NOT NULL,
    ID_FICHIER int NOT NULL,
    DROIT VARCHAR2(50),
    PRIMARY KEY (ID_DROIT)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : FAIRE
-- -----------------------------------------------------------------------------

CREATE TABLE FAIRE
   (
    ID_FAIRE int not null,
    ID_VALIDATION int NOT NULL,
    ID_USER VARCHAR2(50) NOT NULL,
    STATUT VARCHAR2(32),
    PRIMARY KEY (ID_FAIRE)  
   );

