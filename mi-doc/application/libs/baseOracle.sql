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
--       CREATION DE LA BASE 
-- -----------------------------------------------------------------------------

CREATE DATABASE IF NOT EXISTS ProjetSI;
use ProjetSI;

-- -----------------------------------------------------------------------------
--       TABLE : FICHIER
-- -----------------------------------------------------------------------------

CREATE TABLE FICHIER
   (
    ID_FICHIER int not null,
    ID_USER int not null,
    NOM VARCHAR(50),
    DESCRIPTION VARCHAR(50),
    PATHS VARCHAR(80),
    DOSSIER number(1),
    SERVICE int not null,
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
    ID_USER int NOT NULL,
    STATUT VARCHAR(50),
    PRIMARY KEY (ID_DEMANDE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : VALIDATION
-- -----------------------------------------------------------------------------

CREATE TABLE VALIDATION
   (
    ID_VALIDATION int not null,
    ID_FICHIER int NOT NULL,
    ID_USER int NOT NULL,
    PRIMARY KEY (ID_VALIDATION)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : DROIT
-- -----------------------------------------------------------------------------

CREATE TABLE DROIT
   (
    ID_DROIT int not null,
    ID_USER int NOT NULL,
    ID_FICHIER int NOT NULL,
    DROIT VARCHAR(50),
    PRIMARY KEY (ID_DROIT)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : FAIRE
-- -----------------------------------------------------------------------------

CREATE TABLE FAIRE
   (
    ID_FAIRE int not null,
    ID_VALIDATION int NOT NULL,
    ID_USER int NOT NULL,
    STATUT VARCHAR(32),
    PRIMARY KEY (ID_FAIRE)  
   );

-- -----------------------------------------------------------------------------
--       CREATION DES REFERENCES DE TABLE
-- -----------------------------------------------------------------------------


ALTER TABLE FICHIER ADD (
     CONSTRAINT FK_FICHIER_UTILISATEUR
          FOREIGN KEY (ID_USER)
               REFERENCES UTILISATEUR (ID_USER))   ;

ALTER TABLE FICHIER ADD (
     CONSTRAINT FK_FICHIER_FICHIER
          FOREIGN KEY (PARENT)
               REFERENCES FICHIER (ID_FICHIER))   ;

ALTER TABLE DEMANDE_EXTENSION ADD (
     CONSTRAINT FK_DEMANDE_EXTENSION_FICHIER
          FOREIGN KEY (ID_FICHIER)
               REFERENCES FICHIER (ID_FICHIER))   ;

ALTER TABLE DEMANDE_EXTENSION ADD (
     CONSTRAINT FK_DEMANDE_EXTENSION_UTILISATE
          FOREIGN KEY (ID_USER)
               REFERENCES UTILISATEUR (ID_USER))   ;


ALTER TABLE VALIDATION ADD (
     CONSTRAINT FK_VALIDATION_FICHIER
          FOREIGN KEY (ID_FICHIER)
               REFERENCES FICHIER (ID_FICHIER))   ;


ALTER TABLE DROIT ADD (
     CONSTRAINT FK_DROIT_FICHIER
          FOREIGN KEY (ID_FICHIER)
               REFERENCES FICHIER (ID_FICHIER))   ;

ALTER TABLE FAIRE ADD (
     CONSTRAINT FK_FAIRE_VALIDATION
          FOREIGN KEY (ID_VALIDATION)
               REFERENCES VALIDATION (ID_VALIDATION))   ;


-- -----------------------------------------------------------------------------
--                FIN DE GENERATION
-- -----------------------------------------------------------------------------