-- -----------------------------------------------------------------------------
--             Suppresion des tables
-- -----------------------------------------------------------------------------

drop table demande_extension;
drop table faire;
drop table validation;
drop table droit;
drop table fichier;

-- -----------------------------------------------------------------------------
--             Suppresion des séquences
-- -----------------------------------------------------------------------------

drop sequence s_t1;
drop sequence s_t2;
drop sequence s_t3;
drop sequence s_t4;
drop sequence s_t5;


-- -----------------------------------------------------------------------------
--             Suppresion des triggers
-- -----------------------------------------------------------------------------

drop trigger tr_t1;
drop trigger tr_t2;
drop trigger tr_t3;
drop trigger tr_t4;
drop trigger tr_t5;


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
	DROIT VARCHAR2(5),
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

-- -----------------------------------------------------------------------------
--       Insertion : Ligne parent
-- -----------------------------------------------------------------------------

insert into FICHIER values(0, ' ', ' ', ' ', ' ', ' ', 0, ' ', 0);


-- -----------------------------------------------------------------------------
--       Insertion : Ligne test
-- -----------------------------------------------------------------------------

REM INSERTING into VALIDATION
SET DEFINE OFF;
REM INSERTING into FICHIER
SET DEFINE OFF;
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('0',' ',' ',' ',' ',' ','0',' ','0');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('59','madecalf','L3App','L3App','Dossier des L3App','services','1','L3App','0');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('60','madecalf','Marketing Mix','Marketing Mix','Cours de Maketing Mix','services/L3App','1','L3App','59');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('61','siaydin','Reglement L3App','Reglement_L3App.doc','Reglement du service L3App','services/L3App','0','L3App','59');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('62','siaydin','Résultats net financiers','Resultats_net.xlsx','Resultats de l''entreprise','services/L3App','0','L3App','59');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('63','isoard','Cours 1 de MM','Cours1.doc','Cours 1 portant sur la demarche maketing','services/L3App/Marketing Mix','0','L3App','60');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('64','isoard','Cours 1 de MM','Cours2.doc','Cours 2 portant sur la demarche maketing','services/L3App/Marketing Mix','0','L3App','60');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('65','isoard','Cours 1 de MM','Cours3.doc','Cours 3 portant sur la demarche maketing','services/L3App/Marketing Mix','0','L3App','60');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('66','isoard','Cours 1 de MM','Cours4.doc','Cours 4 portant sur la demarche maketing','services/L3App/Marketing Mix','0','L3App','60');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('67','admin','rh','ressources_humaines','Dossier des rh','services','1','rh','0');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('68','isoard','Exercices de MM','Exercices','Exercices de Marketing','services/L3App/Marketing Mix','1','L3App','60');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('69','isoard','Corriges de MM','Corriges','Corriges de  Marketing','services/L3App/Marketing Mix/Exercices','1','L3App','68');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('70','isoard','Cours 1 de MM','exo1.doc','Exercice 1 portant sur la demarche maketing','services/L3App/Marketing Mix/Exercices','0','L3App','68');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('71','isoard','Cours 1 de MM','exo2.doc','Exercice 2 portant sur la demarche maketing','services/L3App/Marketing Mix/Exercices','0','L3App','68');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('74','isoard','Cours 1 de MM','exo2_corrige.doc','Corriges 2 portant sur la demarche maketing','services/L3App/Marketing Mix/Exercices/Corriges','0','L3App','69');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('75','admin','Dossier M1App','M1App','Dossier des M1App','services','1','M1App','0');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('76','admin','PRojets des M1 app','Projets','Projets des M1App','services/M1App','1','M1App','75');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('77','admin','Projet de C pour les M1App','projet_c.c','Projet de c des M1App','services/M1App/Projets','0','M1App','76');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('78','admin','Liste des eleves de M1App','liste_eleves_m1.doc','Listes des eleves de M1App','services/M1App','0','M1App','75');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('1','admin','liste personnel','liste_personnel.doc','Liste du personnel','services/ressources_humaines','0','rh','67');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('2','admin','fiches perso','fiches_perso','Dossier des fiches sur le personnel','services/ressources_humaines','1','rh','67');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('3','admin','resume fiche perso','resume_fiche.rtf','Resume fiches perso','services/ressources_humaines/fiches_perso','0','rh','2');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('4','admin','fiches l3app','fiches_L3App','Fiches des L3App','services/ressources_humaines/fiches_perso','1','rh','2');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('5','admin','fiches sur les l3App','l3App_fiches.txt','Fiches sur les L3App','services/ressources_humaines/fiches_perso/fiches_L3App','0','rh','4');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('6','noelmoja','fiche noelmoja','Fiche_noelmoja.doc','fiche sur noelmoja','services/L3App','0','L3App','59');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('7','madecalf','dossier inscription nanterre','DossierMiageP10-AydinSimon.rtf','dossier inscription nanterre','services/L3App','0','L3App','59');
Insert into FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('12','madecalf','Ljkfsd','DossierMiageP10-AydinSimon.rtf','Ljkfsd','services/M1App/Projets','0','L3App','76');
REM INSERTING into FAIRE
SET DEFINE OFF;
REM INSERTING into DROIT
SET DEFINE OFF;
Insert into DROIT (ID_DROIT,ID_USER,ID_FICHIER,DROIT) values ('1','madecalf','74','1');
Insert into DROIT (ID_DROIT,ID_USER,ID_FICHIER,DROIT) values ('2','madecalf','76','2');
Insert into DROIT (ID_DROIT,ID_USER,ID_FICHIER,DROIT) values ('3','siaydin','4','1');
REM INSERTING into DEMANDE_EXTENSION
SET DEFINE OFF;
Insert into DEMANDE_EXTENSION (ID_DEMANDE,ID_FICHIER,ID_USER,STATUT,DROIT) values ('1','76','madecalf','0','1');


-- -----------------------------------------------------------------------------
--       Création : Séquences
-- -----------------------------------------------------------------------------

CREATE SEQUENCE s_t1 START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE s_t2 START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE s_t3 START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE s_t4 START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE s_t5 START WITH 1 INCREMENT BY 1;


-- -----------------------------------------------------------------------------
--       Création : Triggers
-- -----------------------------------------------------------------------------

--       Création : Trigger 1

CREATE OR REPLACE TRIGGER tr_t1 BEFORE INSERT ON FICHIER
FOR EACH ROW
DECLARE
v_nb int;
BEGIN
select count(*) into v_nb from Fichier;

IF v_nb>0 then
    :new.ID_FICHIER := s_t1.nextval;
    else :new.ID_FICHIER := 1;
END IF;
END;
/

--       Fin : Trigger 1


--       Création : Trigger 2

CREATE OR REPLACE TRIGGER tr_t2 BEFORE INSERT ON DEMANDE_EXTENSION
FOR EACH ROW
DECLARE
v_nb int;
BEGIN
select count(*) into v_nb from DEMANDE_EXTENSION;

IF v_nb>0 then
    :new.ID_DEMANDE := s_t2.nextval;
    else :new.ID_DEMANDE := 1;
END IF;
END;
/

--       Fin : Trigger 2


--       Création : Trigger 3

CREATE OR REPLACE TRIGGER tr_t3 BEFORE INSERT ON VALIDATION
FOR EACH ROW
DECLARE
v_nb int;
BEGIN
select count(*) into v_nb from VALIDATION;

IF v_nb>0 then
    :new.ID_VALIDATION := s_t3.nextval;
    else :new.ID_VALIDATION := 1;
END IF;
END;
/

--       Fin : Trigger 3


--       Création : Trigger 4

CREATE OR REPLACE TRIGGER tr_t4 BEFORE INSERT ON DROIT
FOR EACH ROW
DECLARE
v_nb int;
BEGIN
select count(*) into v_nb from DROIT;

IF v_nb>0 then
    :new.ID_DROIT := s_t4.nextval;
    else :new.ID_DROIT := 1;
END IF;
END;
/

--       Fin : Trigger 4


--       Création : Trigger 5

CREATE OR REPLACE TRIGGER tr_t5 BEFORE INSERT ON FAIRE
FOR EACH ROW
DECLARE
v_nb int;
BEGIN
select count(*) into v_nb from FAIRE;

IF v_nb>0 then
    :new.ID_FAIRE := s_t5.nextval;
    else :new.ID_FAIRE := 1;
END IF;
END;
/

--       Fin : Trigger 5


-- -----------------------------------------------------------------------------
--       CREATION DES REFERENCES DE TABLE
-- -----------------------------------------------------------------------------

ALTER TABLE FICHIER ADD (
     CONSTRAINT FK_FICHIER_FICHIER
          FOREIGN KEY (PARENTS)
               REFERENCES FICHIER (ID_FICHIER)
					ON DELETE CASCADE)   ;   
					

ALTER TABLE DEMANDE_EXTENSION ADD (
     CONSTRAINT FK_DEMANDE_EXTENSION_FICHIER
          FOREIGN KEY (ID_FICHIER)
               REFERENCES FICHIER (ID_FICHIER))   ;

ALTER TABLE VALIDATION ADD (
     CONSTRAINT FK_VALIDATION_FICHIER
          FOREIGN KEY (ID_FICHIER)
               REFERENCES FICHIER (ID_FICHIER)
					ON DELETE CASCADE)   ;


ALTER TABLE DROIT ADD (
     CONSTRAINT FK_DROIT_FICHIER
          FOREIGN KEY (ID_FICHIER)
               REFERENCES FICHIER (ID_FICHIER)
					ON DELETE CASCADE)   ;

ALTER TABLE FAIRE ADD (
     CONSTRAINT FK_FAIRE_VALIDATION
          FOREIGN KEY (ID_VALIDATION)
               REFERENCES VALIDATION (ID_VALIDATION)
					ON DELETE CASCADE)   ;


-- -----------------------------------------------------------------------------
--                FIN DE GENERATION
-- -----------------------------------------------------------------------------