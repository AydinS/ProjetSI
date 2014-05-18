<?php
/**
 * Modele rechercherModele
 * Développeur : EJA
 * MàJ : 11/05/2014
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */

class rechercherModel
{


    /**
     * Every model needs a database connection, passed to the model
     * @param object $db A PDO database connection
     */
    function __construct($db,$ldapCon,$ldapBind) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
		
		try{
			$this->ldapCon = $ldapCon;//Connexion LDAP
		} catch(Exception $eCon){
			exit('Ldap connection could not be established.');
			
		}
		$this->ldapBind = null;
		/*try{
			$this->ldapBind = $ldapBind;//BIND LDAP
		} catch(Exception $eBind){
			exit('Could not bind to ldap connection.');
		}*/
    }

    /**
     * Créateur : EJA
     * MàJ : 11/05/2014
     * Methode: recupererAllFichiers
     * Comportement : Execute une requete passée en paramètre et retourne un tableau resultant de la requete ou -1
     * Paramètres IN : la requète
     * Paramètres OUT : Le tableau ou -1 si aucun resultat n'a été trouvé
     * Page IN possibles : controller/rechercher.php->effectuerRecherche()
     * Page out possibles : N/A
     */
    public function recupererAllFichiers($req){
    	//Execution de la requète
    	$tabFic = array();
		$query = $this->db->prepare($req);
		$query->execute();
		$res = $query->fetchAll();
		if(count($res)>0){
			$i=0;
			foreach($res as $infos){
				$tabFic[$i]['ID_FICHIER'] = $infos->ID_FICHIER;
				$tabFic[$i]['ID_USER'] = $infos->ID_USER;
				$tabFic[$i]['LIBELLE'] = $infos->LIBELLE;
				$tabFic[$i]['NOM'] = $infos->NOM;
				$tabFic[$i]['DESCRIPTION']= $infos->DESCRIPTION;
				$tabFic[$i]['PATHS'] = $infos->PATHS;
				$tabFic[$i]['DOSSIER'] = $infos->DOSSIER;
				$tabFic[$i]['SERVICE'] = $infos->SERVICE;
				$tabFic[$i]['PARENT'] = $infos->PARENTS;
				$i+=1;
			}
		}
		
		if(count($res) > 0)
			return $tabFic;
		else
			return -1;
    }

    /**
     * Créateur : EJA
     * MàJ : 11/05/2014
     * Methode: construireReq
     * Comportement : Construit la partie commune aux requetes de recherche de fichier à partir des paramètres passés par l'utilisateur 
     * Paramètres IN : 1) les mot clés 2) l'auteur du fichier 3) l'extension
     * Paramètres OUT : Une chaine de caractère
     * Page IN possibles : controller/rechercher.php->effectuerRecherche()
     * Page out possibles : N/A
     */
    public function construireReq($motCle,$auteur,$extension)
    {
    	$where = "WHERE ";
    	if($motCle != "")
    	{
    		$tabMot = array();
    		$tabMot = explode(';', $motCle);
    		$where .= "(NOM LIKE '%".$tabMot[0]."%' ";
    		for($i=1;$i<count($tabMot)-1;$i++)
    		{
    			$where.="OR NOM LIKE '%".$tabMot[$i]."%' ";
    		}
    		$where .= ') ';
    	}
    	if($auteur != "")
    	{
    		if($motCle == "")
    		{
    			$where .= "fi.ID_USER = '$auteur' ";
    		}
    		else $where .= "AND fi.ID_USER = '$auteur' ";
    	}
    	if($extension != ""){
    		if($auteur == "" && $motCle == ""){
    			$where .= "NOM LIKE '%.$extension' ";
    		}
    		else $where .= "AND NOM LIKE '%.$extension' ";
    	}

    	return $where;
    }

    /**
     * Créateur : EJA
     * MàJ : 18/05/2014
     * Methode: getAllIdFichierExt
     * Comportement : Récupère tous les fichiers contenus dans les dossiers patagés
     * Paramètres IN : 1) l'accès aux fonctions du modèle naviguation 2) l'utilisateur connecté
     * Paramètres OUT : Une chaine de caractère sous la forme : (idFic, idFic, idFic)
     * Page IN possibles : controller/rechercher.php->effectuerRecherche()
     * Page out possibles : N/A
     */
    public function getAllIdFichierExt($navModel,$iduser){
            $idFichiersPartages = array();
            $nbIdFic=0;
            $test = array();

            $dossiers = $navModel->getAllSharedFolders($iduser);

            for($i=0;$i<count($dossiers);$i++){
                
                $test = $navModel->getAllFilesNotFolder($dossiers[$i]['ID_FICHIER'],0);
                for($cpt1 = 0;$cpt1<count($test);$cpt1++){
                    $idFichiersPartages[$nbIdFic]['id'] = $test[$cpt1]['ID_FICHIER'];
                    $nbIdFic++;
                }
                $sousDossier=$navModel->getAllFoldersFrom($dossiers[$i]['ID_FICHIER'], null);

                while($sousDossier > 0)
                {
                    for($j=0;$j<count($sousDossier);$j++)
                    {
                        $ssdos = $sousDossier[$j]['ID_FICHIER'];
                        $sousDossier=$navModel->getAllFoldersFrom($sousDossier[$j]['ID_FICHIER'], null);
                        $test = $navModel->getAllFilesNotFolder($ssdos,0);
                        for($cpt1 = 0;$cpt1<count($test);$cpt1++){
                            $idFichiersPartages[$nbIdFic]['id'] = $test[$cpt1]['ID_FICHIER'];
                            $nbIdFic++;
                        }
                    }
                }
            }
            
            if(count($idFichiersPartages) > 0){
                $id = '( '.$idFichiersPartages[0]['id'];
                
                for($l=1;$l<count($idFichiersPartages);$l++){
                    $id = $id.', '.$idFichiersPartages[$l]['id'];
                }
                $id = $id.' )';    
            }
            
            return $id;
            
        }
}