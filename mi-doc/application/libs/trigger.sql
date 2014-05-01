-- -----------------------------------------------------------------------------
--       CREATION DE LA SEQUENCE AUTO_INCREMENT FICHIER
-- -----------------------------------------------------------------------------

drop sequence s_t1;
CREATE SEQUENCE s_t1 START WITH 1 INCREMENT BY 1;

-- -----------------------------------------------------------------------------
--       CREATION DU TRIGGER AUTO_INCREMENT FICHIER
-- -----------------------------------------------------------------------------

drop trigger tr_t1;
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
 
-- -----------------------------------------------------------------------------
--       CREATION DE LA SEQUENCE AUTO_INCREMENT DEMANDE D'EXTENSION
-- -----------------------------------------------------------------------------

drop sequence s_t2;
CREATE SEQUENCE s_t2 START WITH 1 INCREMENT BY 1;

-- -----------------------------------------------------------------------------
--       CREATION DU TRIGGER AUTO_INCREMENT DEMANDE D'EXTENSION
-- -----------------------------------------------------------------------------

drop trigger tr_t2;
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

-- -----------------------------------------------------------------------------
--       CREATION DE LA SEQUENCE AUTO_INCREMENT VALIDATION
-- -----------------------------------------------------------------------------

drop sequence s_t3;
CREATE SEQUENCE s_t3 START WITH 1 INCREMENT BY 1;

-- -----------------------------------------------------------------------------
--       CREATION DU TRIGGER AUTO_INCREMENT VALIDATION
-- -----------------------------------------------------------------------------

drop trigger tr_t3;
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

-- -----------------------------------------------------------------------------
--       CREATION DE LA SEQUENCE AUTO_INCREMENT DROIT
-- -----------------------------------------------------------------------------

drop sequence s_t4;
CREATE SEQUENCE s_t4 START WITH 1 INCREMENT BY 1;

-- -----------------------------------------------------------------------------
--       CREATION DU TRIGGER AUTO_INCREMENT DROIT
-- -----------------------------------------------------------------------------

drop trigger tr_t4;
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

-- -----------------------------------------------------------------------------
--       CREATION DE LA SEQUENCE AUTO_INCREMENT FAIRE
-- -----------------------------------------------------------------------------

drop sequence s_t5;
CREATE SEQUENCE s_t5 START WITH 1 INCREMENT BY 1;

-- -----------------------------------------------------------------------------
--       CREATION DU TRIGGER AUTO_INCREMENT FAIRE
-- -----------------------------------------------------------------------------

drop trigger tr_t5;
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