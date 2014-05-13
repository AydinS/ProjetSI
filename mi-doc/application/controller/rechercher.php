<?php

/**
 * Class Rechercher
 * Développeur : EJA
 * MàJ : 11/05/2014
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
//ini_set("display_errors",0);error_reporting(o);
class Rechercher extends Controller
{
		public function formRechercher(){
			// 1] Appeler la vue de la recherche

			if(isset($_SESSION['SERVICE'])){//Vérifier que l'utilisateur est toujours connecté
				require 'application/views/_templates/header.php';
				require 'application/views/rechercher/index.php';
				require 'application/views/_templates/footer.php';
    	}
}
        /**
         * Créateur : EJA
         * MàJ : 11/05/2014
         * Methode: effectuerRecherche
         * Comportement : Cherche les fichiers téléchargeables selon les critères rentrés par l'utilisateur puis affiche les resultats de la recherche
         * Paramètres IN : void
         * Paramètres OUT : void
         * Page IN possibles : views/rechercher/index.php
         * Page out possibles : views/rechercher/index.php
         */
    	public function effectuerRecherche(){
    		if(isset($_POST['searchMotCle']) && isset($_POST['searchAuteur']) && isset($_POST['searchExt']))
    		{
    			if($_POST['searchMotCle'] != "" || $_POST['searchAuteur'] != "" || $_POST['searchExt'] != ""){//Si au moins un des champs est renseigné
    				$rechercherModel = $this->loadModel('rechercherModel');

                    //Initialisation des variables
    				$iduser = $_SESSION['uid'];
    				$idservice = $_SESSION['SERVICE'];
    				$resultService = array();//Accueil tous les résultats des fichiers téléchargeable de son service
    				$resultExt = array();//Accueil tous les résultats des fichiers téléchargeables de services exterieurs et accessibles
    				
                    //Construction de la requète à partir des renseignement passés en paramètre
    				$where = $rechercherModel->construireReq($_POST['searchMotCle'],$_POST['searchAuteur'],$_POST['searchExt']);//Partie communes au requetes
    				$reqExt = "SELECT * FROM DROIT dr, FICHIER fi $where AND fi.DOSSIER = 0 AND dr.ID_USER='$iduser' AND dr.DROIT = '1' AND dr.ID_FICHIER=fi.ID_FICHIER AND fi.SERVICE<>'$idservice'";
    				$reqService = "SELECT * FROM FICHIER fi $where AND fi.SERVICE = '$idservice' AND fi.DOSSIER = 0";

    				//Execution des requetes
    				$resultExt = $rechercherModel->recupererAllFichiers($reqExt);
    				$resultService = $rechercherModel->recupererAllFichiers($reqService);
    			}
    		}
    		require 'application/views/_templates/header.php';
			require 'application/views/rechercher/index.php';
			require 'application/views/_templates/footer.php';

    	}

}