--------------------------------------------------------
--  Fichier créé - dimanche-mai-04-2014   
--------------------------------------------------------
REM INSERTING into PROJETSI.DROIT
SET DEFINE OFF;
Insert into PROJETSI.DROIT (ID_DROIT,ID_USER,ID_FICHIER,DROIT) values ('1','madecalf','74','1');
Insert into PROJETSI.DROIT (ID_DROIT,ID_USER,ID_FICHIER,DROIT) values ('2','madecalf','76','1');
REM INSERTING into PROJETSI.FICHIER
SET DEFINE OFF;
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('59','madecalf','L3App','L3App','Dossier des L3App','services','1','L3App','0');
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('60','madecalf','Marketing Mix','Marketing Mix','Cours de Maketing Mix','services/L3App','1','L3App','59');
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('61','siaydin','Reglement L3App','Reglement_L3App.doc','Reglement du service L3App','services/L3App','0','L3App','59');
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('62','siaydin','Résultats net financiers','Resultats_net.xlsx','Resultats de l''entreprise','services/L3App','0','L3App','59');
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('63','isoard','Cours 1 de MM','Cours1.doc','Cours 1 portant sur la demarche maketing','services/L3App/Marketing Mix','0','L3App','60');
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('64','isoard','Cours 1 de MM','Cours2.doc','Cours 2 portant sur la demarche maketing','services/L3App/Marketing Mix','0','L3App','60');
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('65','isoard','Cours 1 de MM','Cours3.doc','Cours 3 portant sur la demarche maketing','services/L3App/Marketing Mix','0','L3App','60');
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('66','isoard','Cours 1 de MM','Cours4.doc','Cours 4 portant sur la demarche maketing','services/L3App/Marketing Mix','0','L3App','60');
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('67','admin','rh','ressources_humaines','Dossier des rh','services','1','rh','0');
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('68','isoard','Exercices de MM','Exercices','Exercices de Marketing','services/L3App/Marketing Mix','1','L3App','60');
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('69','isoard','Corriges de MM','Corriges','Corriges de  Marketing','services/L3App/Marketing Mix/Exercices','1','L3App','68');
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('70','isoard','Cours 1 de MM','exo1.doc','Exercice 1 portant sur la demarche maketing','services/L3App/Marketing Mix/Exercices','0','L3App','68');
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('71','isoard','Cours 1 de MM','exo2.doc','Exercice 2 portant sur la demarche maketing','services/L3App/Marketing Mix/Exercices','0','L3App','68');
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('74','isoard','Cours 1 de MM','exo2_corrige.doc','Corriges 2 portant sur la demarche maketing','services/L3App/Marketing Mix/Exercices/Corriges','0','L3App','69');
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('75','admin','Dossier M1App','M1App','Dossier des M1App','services','1','M1App','0');
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('76','admin','PRojets des M1 app','Projets','Projets des M1App','services/M1App','1','M1App','75');
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('77','admin','Projet de C pour les M1App','projet_c.c','Projet de c des M1App','services/M1App/Projets','0','M1App','76');
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('78','admin','Liste des eleves de M1App','liste_eleves_m1.doc','Listes des eleves de M1App','services/M1App','0','M1App','75');
Insert into PROJETSI.FICHIER (ID_FICHIER,ID_USER,LIBELLE,NOM,DESCRIPTION,PATHS,DOSSIER,SERVICE,PARENTS) values ('0',' ',' ',' ',' ',' ','0',' ','0');
