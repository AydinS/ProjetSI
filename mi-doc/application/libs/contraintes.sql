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