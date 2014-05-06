drop table demande_extension;
drop table faire;
drop table validation;
drop table droit;
drop table fichier;

insert into FICHIER values(0, ' ', ' ', ' ', ' ', ' ', 0, ' ', 0);


-------------------------------------------------------------------------
--                   EXEMPLES D'INSERTION                               --
-------------------------------------------------------------------------

insert into FICHIER values('', 'SAydin', 'Quake', 'Quake', 'Dossier Rage quit system', '', 0, 'IT', 0);
insert into FICHIER value('', 'SAydin', 'Quakemap', 'quake.java', 'Rage quit system', 'C:\User\Simon\Documents\', 1, 'IT', 1)