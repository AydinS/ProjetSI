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
	
	public function getIdFicByPath($path){
		
		//$req = "SELECT * FROM FICHIER WHERE PATHS = '".$path."'";
		$req = "SELECT * FROM FICHIER WHERE PATHS = :path";
		$query = $this->db->prepare($req);
		$query->execute(array(':path' => $path));
		$res = $query->fetchAll();
		$infos = array();
		
		foreach($res as $r){
			$infos['PATH'] = $r->PATHS;
			$infos['ID_FICHIER'] = $r->ID_FICHIER;
		}
		if(count($res) > 0){
			return $infos;
		}else return -1;
	}
	

	
	public function getServiceId($service,$idUser = null){
		$req = "SELECT * FROM FICHIER WHERE NOM = :service and parents = 0";
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
			$info['DROIT'] = $idUser != null ? NavigationModel::getDroit($idUser,$infos->ID_FICHIER) : 0;
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
			$info['DROIT'] = $idUser != null ? NavigationModel::getDroit($idUser,$infos->ID_FICHIER) : 0;
		}
		if(count($res) > 0)
			return $info;
		else
			return -1;
		
	}

	public function getFilesInfoByIdFic($idfic){
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
		}
		if(count($res) > 0)
			return $info;
		else
			return -1;
		
	}	
	
	public function getAllFilesByParents($idParents,$idUser = null,$path = null){
		$fichiers = array();
		$i = 0;
		if($path == null){
			
			$req = "SELECT * FROM FICHIER where PARENTS = :idparent";
			$query = $this->db->prepare($req);
			$query->execute(array(':idparent' => $idParents));
			$res = $query->fetchAll();
			//pour chaque fichier :
			
			if(count($res)>0){
				
				foreach($res as $fic){
					$fichiers[$i]['NOM'] = $fic->NOM;
					$fichiers[$i]['ID_FICHIER'] = $fic->ID_FICHIER;
					$fichiers[$i]['DROIT'] = $idUser != null ? NavigationModel::getDroit($idUser,$fic->ID_FICHIER) : 0;
					$fichiers[$i]['DESC'] = $fic->DESCRIPTION;
					$fichiers[$i]['PATH'] = $fic->PATHS;
					$fichiers[$i]['DOSSIER'] = $fic->DOSSIER;
					$fichiers[$i]['SERVICE'] = $fic->SERVICE;
					$fichiers[$i]['PARENT'] = $fic->PARENTS;
					$fichiers[$i]['ID_USER'] = $fic->ID_USER;
					$i+=1;
				}
			}
			return $fichiers;
		}
		return 0;

	}
	
	public function getDroit($idUser,$idFic){
			$req = "SELECT * FROM DROIT WHERE ID_USER = :iduser and ID_FICHIER = :idfic";
			$query = $this->db->prepare($req);
			$query->execute(array(':iduser' => $idUser,':idfic' => $idFic));
			$res = $query->fetchAll();
			if(count($res)>0){
				//echo 'LOOOOOOOOOOOOL<br/>';
				foreach($res as $r){
					return $r->ID_DROIT;
				}
			}
			else return -1;
	
	}

	
}
