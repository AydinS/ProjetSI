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
			$info[$i]['DROIT'] = $idUser != null ? NavigationModel::getDroit($idUser,$infos->ID_FICHIER) : RW_NAV;
			$i++;
		}
		if(count($res) > 0)
			return $info;
		else
			return -1;
		
	}
	
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
			$info[$i]['DROIT'] = $idUser != null ? NavigationModel::getDroit($idUser,$infos->ID_FICHIER) : RW_NAV;
			$i++;
		}
		if(count($res) > 0)
			return $info;
		else
			return -1;
		
	}
	
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
			$info['DROIT'] = $idUser != null ? NavigationModel::getDroit($idUser,$infos->ID_FICHIER) : RW_NAV;
		}
		if(count($res) > 0)
			return $info;
		else
			return -1;
		
	}
	
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
			$info['SERVICE'] = $infos->SERVICE;
			$info['DROIT'] = $idUser != null ? NavigationModel::getDroit($idUser,$infos->ID_FICHIER) : RW_NAV;
		}
		if(count($res) > 0)
			return $info;
		else
			return -1;
		
	}

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
			$info['PARENT'] = $infos->PARENTS;
			$info['DOSSIER'] = $infos->DOSSIER;
			$info['SERVICE'] = $infos->SERVICE;
			$info['DROIT'] = $idUser != null ? NavigationModel::getDroit($idUser,$infos->ID_FICHIER) : RW_NAV;
		}
		if(count($res) > 0)
			return $info;
		else
			return -1;
		
	}	
	
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
					$fichiers[$i]['DROIT'] = $idUser != null ? NavigationModel::getDroit($idUser,$fic->ID_FICHIER) : RW_NAV;
					$fichiers[$i]['DESC'] = $fic->DESCRIPTION;
					$fichiers[$i]['PATH'] = $fic->PATHS;
					$fichiers[$i]['DOSSIER'] = $fic->DOSSIER;
					$fichiers[$i]['SERVICE'] = $fic->SERVICE;
					$fichiers[$i]['PARENT'] = $fic->PARENTS;
					$fichiers[$i]['ID_USER'] = $fic->ID_USER;
					$i+=1;
				}
				return $fichiers;
			}
			else return 0;
			
	

	}
	
	public function getAllSharedFolders($idUser){
		$fichiers = array();
		$i = 0;
		$req = "SELECT * FROM FICHIER f, DROIT d where d.ID_USER = :iduser and d.ID_FICHIER = f.ID_FICHIER and f.DOSSIER = 1 and f.ID_USER <> d.ID_USER and d.DROIT >= ".LECTURE."";
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
					$fichiers[$i]['ID_USER'] = $fic->ID_USER;
					$i+=1;
				}
				return $fichiers;
			}
			else return 0;
	}
	
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
	echo "Fichier = $idFile<br>";
			if($idUser == 1) $req = "DELETE FROM FICHIER WHERE ID_FICHIER = :idFile";
			else $req = "DELETE FROM FICHIER WHERE ID_USER = :iduser and ID_FICHIER = :idFile";
			
			$query = $this->db->prepare($req);
			if($idUser == 1) $query->execute(array(':idFile' => $idFile));
			else $query->execute(array(':iduser' => $idUser,':idFile' => $idFile));
	}
}
