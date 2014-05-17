<?php


class NavigationModel
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
	* Renvoie le chemin vers le fichier sous forme décomposé dans un tableau
	* param : le chemin
	* param : l'id fichier
	*/
	public function getCurrentLocation($path,$idfic = null){
		$crumbs = explode("/",$path);
		$str = array();
		$i = 0;
		foreach($crumbs as $crumb){
			
			//echo $crumb.'<br />';
			$str[$i]= $crumb;
			$i+=1;
		}
		return $str;
	}
	
	/**
	* Renvoie l'id d'un fichier en fournissant un path
	* param : le chemin
	* param : l'id de l'utilisateur
	*/
	public function getIdFicByPath($path,$idUser = null){
		
		//$req = "SELECT * FROM FICHIER WHERE PATHS = '".$path."'";
		$req = "SELECT * FROM FICHIER WHERE PATHS = :path";
		$query = $this->db->prepare($req);
		$query->execute(array(':path' => $path));
		$res = $query->fetchAll();
		$infos = array();
		
		foreach($res as $r){
			$infos['PATH'] = $r->PATHS;
			$infos['ID_FICHIER'] = $r->ID_FICHIER;
			$infos['SERVICE'] = $r->SERVICE;
			$infos['NOM'] = $r->NOM;
			$infos['DOSSIER'] = $r->NOM;
			$infos['PARENT'] = $r->PARENTS;
			$infos['LIBELLE'] = $r->LIBELLE;
			$infos['ID_USER'] = $r->ID_USER;
			$infos['DROIT'] = $idUser != null ? NavigationModel::getDroit($idUser,$r->ID_FICHIER) : RW_NAV;
		}
		if(count($res) > 0){
			return $infos;
		}else return -1;
	}
	
	/**
	* Renvoie le statut d'un fichier
	* param : l'id du fichier
	* param : l'id utilisateur demandant la validation
	*/
	public function getFileStatut($idfic,$iduser){
		
		//vérifier s'il y a une validation
		$reqVal = "SELECT * FROM VALIDATION WHERE ID_FICHIER = :idfic and ID_USER = :iduser";
		$query = $this->db->prepare($reqVal);
		$query->execute(array(':idfic' => $idfic,":iduser" => $iduser));
		$infos = array();
		$res = $query->fetchAll();
		if(count($res) > 0){//
			foreach($res as $v){	
				$infos['ID_VALIDATION'] = $v->ID_VALIDATION;
			}
			//récupère la somme des validation
			$reqFaireVal = "SELECT * FROM FAIRE WHERE ID_VALIDATION = :idval and STATUT=2";
			$query = $this->db->prepare($reqFaireVal);
			$query->execute(array(':idval' => $infos['ID_VALIDATION']));
			$res = $query->fetchAll();
			if(count($res) > 0)
				return 'Refuse';
			//
			$reqFaireVal = "SELECT * FROM FAIRE WHERE ID_VALIDATION = :idval and STATUT = 0";
			$query = $this->db->prepare($reqFaireVal);
			$query->execute(array(':idval' => $infos['ID_VALIDATION']));
			$res = $query->fetchAll();
			if(count($res) > 0)
				return 'En Attente';
			
			$reqFaireVal = "SELECT count (ID_VALIDATION) as nbVal, SUM(STATUT) as sumstatut FROM FAIRE WHERE ID_VALIDATION = :idval";
			$query = $this->db->prepare($reqFaireVal);
			$query->execute(array(':idval' => $infos['ID_VALIDATION']));
			$res = $query->fetchAll();
			$nbval = 0;
			$sval = -1;
			$c = count($res);
			if(count($res) > 0){
				foreach($res as $r){
					$nbval = $r->NBVAL;
					$sval = $r->SUMSTATUT;
				}
				if($nbval == $sval)
					return 'Valide';
			
			}
			return 'En attente';
			
		}else{
			return '';
		}
	}
	
	/**
	* Renvoie tous les fichiers/dossiers à la racine du dossier service
	* param : l'id de l'utilisateur
	*/
	public function getAllServiceFolder($idUser = null){
		$req = "SELECT * FROM FICHIER WHERE parents = 0";
		$query = $this->db->prepare($req);
		$query->execute();
		$res = $query->fetchAll();
		$info = array();
		$i = 0;
		foreach($res as $infos){
			$info[$i]['ID_FICHIER'] = $infos->ID_FICHIER;
			$info[$i]['NOM'] = $infos->NOM;
			$info[$i]['ID_USER'] = $infos->ID_USER;
			$info[$i]['PATH'] = $infos->PATHS;
			$info[$i]['PARENT'] = $infos->PARENTS;
			$info[$i]['DOSSIER'] = $infos->DOSSIER;
			$info[$i]['LIBELLE'] = $infos->LIBELLE;
			$info[$i]['SERVICE'] = $infos->SERVICE;
			$info[$i]['STATUT']= $idUser != null ? NavigationModel::getFileStatut($infos->ID_FICHIER,$idUser) : '';
			$info[$i]['DROIT'] = $idUser != null ? NavigationModel::getDroit($idUser,$infos->ID_FICHIER) : RW_NAV;
			$i++;
		}
		if(count($res) > 0)
			return $info;
		else
			return -1;
		
	}
	
	/**
	* Renvoie tous les dossier d'un dossier (le dossier 'parent')
	* param : l'id du dossier parent
	* param : l'id utilisateur
	*/
	public function getAllFoldersFrom($idDossier, $idUser = null){
		$req = "SELECT * FROM FICHIER WHERE parents = :iddossier and dossier = 1";
		$query = $this->db->prepare($req);
		$query->execute(array(':iddossier' => $idDossier));
		$res = $query->fetchAll();
		$info = array();
		$i = 0;
		foreach($res as $infos){
			$info[$i]['ID_FICHIER'] = $infos->ID_FICHIER;
			$info[$i]['NOM'] = $infos->NOM;
			$info[$i]['ID_USER'] = $infos->ID_USER;
			$info[$i]['PATH'] = $infos->PATHS;
			$info[$i]['PARENT'] = $infos->PARENTS;
			$info[$i]['DOSSIER'] = $infos->DOSSIER;
			$info[$i]['LIBELLE'] = $infos->LIBELLE;
			$info[$i]['SERVICE'] = $infos->SERVICE;
			$info[$i]['STATUT']= $idUser != null ? NavigationModel::getFileStatut($infos->ID_FICHIER,$idUser) : '';
			$info[$i]['DROIT'] = $idUser != null ? NavigationModel::getDroit($idUser,$infos->ID_FICHIER) : RW_NAV;
			$i++;
		}
		if(count($res) > 0)
			return $info;
		else
			return -1;
		
	}
	
	/**
	* Renvoie les informations sur le dossier du service de l'utilisateur
	* param : le service de l'utilisateur
	* param : l'id utilisateur
	*/
	public function getServiceId($service,$idUser = null){
		$req = "SELECT * FROM FICHIER WHERE SERVICE = :service and parents = 0";
		$query = $this->db->prepare($req);
		$query->execute(array(':service' => $service));
		$res = $query->fetchAll();
		$info = array();
		foreach($res as $infos){
			$info['ID_FICHIER'] = $infos->ID_FICHIER;
			$info['NOM'] = $infos->NOM;
			$info['ID_USER'] = $infos->ID_USER;
			$info['PATH'] = $infos->PATHS;
			$info['PARENT'] = $infos->PARENTS;
			$info['DOSSIER'] = $infos->DOSSIER;
			$info['LIBELLE'] = $infos->LIBELLE;
			$info['SERVICE'] = $infos->SERVICE;
			$info['STATUT']= $idUser != null ? NavigationModel::getFileStatut($infos->ID_FICHIER,$idUser) : '';
			$info['DROIT'] = $idUser != null ? NavigationModel::getDroit($idUser,$infos->ID_FICHIER) : RW_NAV;
		}
		if(count($res) > 0)
			return $info;
		else
			return -1;
		
	}
	
	/**
	* Renvoie les informations sur un fichier en renseignant son parent
	* param : l'id du fichier parent
	* param : l'id utilisateur
	*/
	public function getFilesInfoByParent($idfic,$idUser = null){
		$req = "SELECT * FROM FICHIER WHERE parents = :idfic";
		$query = $this->db->prepare($req);
		$query->execute(array(':idfic' => $idfic));
		$res = $query->fetchAll();
		$info = array();
		foreach($res as $infos){
			$info['ID_FICHIER'] = $infos->ID_FICHIER;
			$info['NOM'] = $infos->NOM;
			$info['ID_USER'] = $infos->ID_USER;
			$info['PATH'] = $infos->PATHS;
			$info['PARENT'] = $infos->PARENTS;
			$info['DOSSIER'] = $infos->DOSSIER;
			$info['STATUT']= $idUser != null ? NavigationModel::getFileStatut($infos->ID_FICHIER,$idUser) : '';
			$info['SERVICE'] = $infos->SERVICE;
			$info['DROIT'] = $idUser != null ? NavigationModel::getDroit($idUser,$infos->ID_FICHIER) : RW_NAV;
		}
		if(count($res) > 0)
			return $info;
		else
			return -1;
		
	}
	
	/**
	* Renvoie toutes les informations sur un fichier
	* param : l'id fichier
	* param : l'id utilisateur
	*/
	public function getFilesInfoByIdFic($idfic,$idUser = null){
		$req = "SELECT * FROM FICHIER WHERE ID_FICHIER = :idfic";
		$query = $this->db->prepare($req);
		$query->execute(array(':idfic' => $idfic));
		$res = $query->fetchAll();
		$info = array();
		foreach($res as $infos){
			$info['ID_FICHIER'] = $infos->ID_FICHIER;
			$info['NOM'] = $infos->NOM;
			$info['ID_USER'] = $infos->ID_USER;
			$info['PATH'] = $infos->PATHS;
			$info['DESCRIPTION']= $infos->DESCRIPTION;
			$info['PARENT'] = $infos->PARENTS;
			$info['DOSSIER'] = $infos->DOSSIER;
			$info['SERVICE'] = $infos->SERVICE;
			$info['STATUT']= $idUser != null ? NavigationModel::getFileStatut($infos->ID_FICHIER,$idUser) : '';
			$info['DROIT'] = $idUser != null ? NavigationModel::getDroit($idUser,$infos->ID_FICHIER) : RW_NAV;
		}
		if(count($res) > 0)
			return $info;
		else
			return -1;
		
	}	
	
	/**
	* Renvoie tous les fichiers d'un dossier
	* param : le dossier
	* param : l'id utilisateur
	* param : le chemin vers ce dossier
	*/
	public function getAllFilesByParents($idParents,$idUser = null,$path = null){
		$fichiers = array();
		$i = 0;
		
			
			$req = "SELECT * FROM FICHIER where PARENTS = :idparent";
			$query = $this->db->prepare($req);
			$query->execute(array(':idparent' => $idParents));
			$res = $query->fetchAll();
			//pour chaque fichier :
			
			if(count($res)>0){
				
				foreach($res as $fic){
					$fichiers[$i]['NOM'] = $fic->NOM;
					$fichiers[$i]['ID_FICHIER'] = $fic->ID_FICHIER;
					$fichiers[$i]['DROIT'] = $idUser != null ? NavigationModel::getDroit($idUser,$fic->PARENTS) : RW_NAV;
					$fichiers[$i]['DESC'] = $fic->DESCRIPTION;
					$fichiers[$i]['PATH'] = $fic->PATHS;
					$fichiers[$i]['DOSSIER'] = $fic->DOSSIER;
					$fichiers[$i]['SERVICE'] = $fic->SERVICE;
					$fichiers[$i]['PARENT'] = $fic->PARENTS;
					$fichiers[$i]['STATUT']= $idUser != null ? NavigationModel::getFileStatut($fic->ID_FICHIER,$idUser) : '';
					$fichiers[$i]['ID_USER'] = $fic->ID_USER;
					$i+=1;
				}
				return $fichiers;
			}
			else return 0;
	}
	
	/**
	* Renvoie tous les dossiers partagés avec l'utilisateur
	* param : l'utilisateur
	*/
	public function getAllSharedFolders($idUser){
		$fichiers = array();
		$i = 0;
		$req = "SELECT * FROM DROIT d, FICHIER f where d.ID_USER = :iduser and d.ID_FICHIER = f.ID_FICHIER and f.DOSSIER = 1 and f.ID_USER <> d.ID_USER and d.DROIT >= ".LECTURE."";
		$query = $this->db->prepare($req);
		$query->execute(array(':iduser' => $idUser));
		$res = $query->fetchAll();
		if(count($res)>0){
				
				foreach($res as $fic){
					$fichiers[$i]['NOM'] = $fic->NOM;
					$fichiers[$i]['ID_FICHIER'] = $fic->ID_FICHIER;
					$fichiers[$i]['DROIT'] = $idUser != null ? NavigationModel::getDroit($idUser,$fic->ID_FICHIER) : RW_NAV;
					$fichiers[$i]['DESC'] = $fic->DESCRIPTION;
					$fichiers[$i]['PATH'] = $fic->PATHS;
					$fichiers[$i]['DOSSIER'] = $fic->DOSSIER;
					$fichiers[$i]['SERVICE'] = $fic->SERVICE;
					$fichiers[$i]['PARENT'] = $fic->PARENTS;
					$fichiers[$i]['STATUT']= $idUser != null ? NavigationModel::getFileStatut($fic->ID_FICHIER,$idUser) : '';
					$fichiers[$i]['ID_USER'] = $fic->ID_USER;
					$i+=1;
				}
				return $fichiers;
			}
			else return 0;
	}
	
	/**
	* Renvoie le droit d'un utilisateur sur un fichier
	* param : l'utilisateur
	* param : l'id fichier
	*/
	public function getDroit($idUser,$idFic){
			$req = "SELECT * FROM DROIT WHERE ID_USER = :iduser and ID_FICHIER = :idfic";
			$query = $this->db->prepare($req);
			$query->execute(array(':iduser' => $idUser,':idfic' => $idFic));
			$res = $query->fetchAll();
			if(count($res)>0){
				foreach($res as $r){
					return $r->DROIT;
				}
			}
			else return RW_NAV;
	}
	
	public function DeleteFile($idUser, $idFile){
			if($idUser == 1) $req = "DELETE FROM FICHIER WHERE ID_FICHIER = :idFile";
			else $req = "DELETE FROM FICHIER WHERE ID_USER = :iduser and ID_FICHIER = :idFile";
			
			$query = $this->db->prepare($req);
			if($idUser == 1) $query->execute(array(':idFile' => $idFile));
			else $query->execute(array(':iduser' => $idUser,':idFile' => $idFile));
	}
	
	public function uploadFile($uid, $description, $namefichier, $path, $dossier, $service, $parent)
	{
		$req = "INSERT INTO FICHIER(ID_USER, LIBELLE, NOM, DESCRIPTION, PATHS, DOSSIER, SERVICE, PARENTS) VALUES ('".$uid."', '".$description."', '".$namefichier."', '".$description."', '".$path."', $dossier, '".$service."', $parent)";
		echo "Requete = $req<br>";
		$query = $this->db->prepare($req);
		$query->execute();
	}
	
	public function updateUploadFile($fic, $uid, $description, $namefichier, $path)
	{
		$req = "UPDATE FICHIER SET ID_USER = '".$uid."', DESCRIPTION = '".$description."', NOM = '".$namefichier."', PATHS = '".$path."' where ID_FICHIER = $fic"; 
		$query = $this->db->prepare($req);
		$query->execute();
	}

	public function searchNameFile($nameFile, $path)
	{
		$req = "SELECT COUNT(*) FROM FICHIER WHERE NOM='".$nameFile."' and PATHS = '".$path."'";
		echo "Rquete = $req<br>";
		$query = $this->db->prepare($req);
		$query->execute();
		$res = $query->fetchAll();
		if(count($res)>0) return 1;
		else return 0;
	}

	/**
	* Methode: creerDossier
	 * Comportement : Créée un dossier
	 * Paramètres IN : void
	 * Paramètres OUT : void
	 * Controlleur : dossier
	 * Page out possibles : N/A
	*/
	public function creerDossier($pathParent,$nomDoss,$descDoss,$id_user,$idParent,$service){
		
		$pathComplet = array();
		$pathComplet = explode('\controller../../',$pathParent);
		$pathMkdir = $pathComplet[0].'\\'.$pathComplet[1];
		$pathMkdir = str_replace('/','\\',$pathMkdir);
		$pathMkdir = $pathMkdir.'\\'.$nomDoss;

		if(mkdir($pathMkdir,0700)){
			$req = "INSERT INTO FICHIER(ID_USER, LIBELLE, NOM, DESCRIPTION, PATHS, DOSSIER, SERVICE, PARENTS) VALUES ('".$id_user."', '".$nomDoss."', '".$nomDoss."', '".$descDoss."', '".$pathComplet[1]."', '1', '".$service."', '".$idParent."')";
			$query = $this->db->prepare($req);
			$query->execute();
		}
	}

	/**
	* Methode: dossierExits
	 * Comportement : Vérifie si un dossier du même nom existe dans un repertoire donné 
	 * Paramètres IN : le nom du dossier, le répertoire
	 * Paramètres OUT : Boolean, Vrai si le dossier existe, Faux sinon
	 * Controlleur : dossier
	 * Page out possibles : N/A
	*/
	public function dossierExists($nomDoss,$paths){
		$req = "SELECT * FROM FICHIER WHERE nom = '".$nomDoss."' AND PATHS='".$paths."'";
		$query = $this->db->prepare($req);
		$query->execute();

		$rows = $query->fetchAll();
		if (count($rows) == 0)
			return true;
		else return false;
	}
	
	function getIdFichierWithAllInfo($uid, $fichier, $chemin, $dossier, $service, $parent)
	{
		$req = "SELECT * FROM FICHIER WHERE ID_USER='".$uid."' and NOM='".$fichier."' and PATHS='".$chemin."' and SERVICE='".$service."' and PARENTS=$parent";
		$query = $this->db->prepare($req);
		$query->execute();
		
		$res = $query->fetchAll();
		foreach($res as $r){
			$infos = $r->ID_FICHIER;
		}
		
		if(count($res) > 0){
			return $infos;
		}else return 0;
	}
}
