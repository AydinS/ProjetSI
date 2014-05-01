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
		
		$req = "SELECT * FROM FICHIER WHERE PATHS = '".$path."'";
		$query = $this->db->prepare($req);
		$query->execute();
		$res = $query->fetchAll();
		$infos = array();
		
		foreach($res as $r){
			$infos['path'] = $r->PATHS;
			$infos['idfic'] = $r->ID_FICHIER;
		}
		if(count($res) > 0){
			return $infos;
		}else return -1;
	}
	

	
	public function getServiceId($service){
		$req = "SELECT * FROM FICHIER WHERE NOM = :service and parents = 0";
		$query = $this->db->prepare($req);
		$query->execute(array(':service' => $service));
		$res = $query->fetchAll();
		$info = array();
		foreach($res as $infos){
			$info['ID_FICHIER'] = $infos->ID_FICHIER;
			$info['nom'] = $infos->NOM;
			$info['ID_USER'] = $infos->ID_USER;
			$info['PATH'] = $infos->PATHS;
			$info['PARENTS'] = $infos->PARENTS;
		}
		if(count($res) > 0)
			return $info;
		else
			return -1;
		
	}
	
	public function getFilesInfoByParent($idfic){
		$req = "SELECT * FROM FICHIER WHERE parents = :idfic";
		$query = $this->db->prepare($req);
		$query->execute(array(':idfic' => $idfic));
		$res = $query->fetchAll();
		$info = array();
		foreach($res as $infos){
			$info['ID_FICHIER'] = $infos->ID_FICHIER;
			$info['nom'] = $infos->NOM;
			$info['ID_USER'] = $infos->ID_USER;
			$info['PATH'] = $infos->PATHS;
			$info['PARENTS'] = $infos->PARENTS;
			$info['DOSSIER'] = $infos->DOSSIER;
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
			$info['nom'] = $infos->NOM;
			$info['ID_USER'] = $infos->ID_USER;
			$info['PATH'] = $infos->PATHS;
			$info['PARENTS'] = $infos->PARENTS;
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
					$fichiers[$i]['nom'] = $fic->NOM;
					$fichiers[$i]['idfic'] = $fic->ID_FICHIER;
					$fichiers[$i]['droit'] = $idUser != null ? NavigationModel::getDroit($idUser,$fic->ID_FICHIER) : 0;
					$fichiers[$i]['desc'] = $fic->DESCRIPTION;
					$fichiers[$i]['path'] = $fic->PATHS;
					$fichiers[$i]['dossier'] = $fic->DOSSIER;
					$fichiers[$i]['service'] = $fic->SERVICE;
					$fichiers[$i]['parent'] = $fic->PARENTS;
					$i+=1;
				}
			}
			return $fichiers;
		}

	}
	
	public function getDroit($idUser,$idFic){
			$req = "SELECT * FROM DROIT WHERE ID_USER = :iduser and ID_FICHIER = :idfic";
			$query = $this->db->prepare($req);
			$query->execute(array(':iduser' => $idUser,':idfic' => $idFic));
			$res = $query->fetchAll();
			if(count($res)>0){
				echo 'LOOOOOOOOOOOOL<br/>';
				foreach($res as $r){
					return $r->ID_DROIT;
				}
			}
			else return -1;
	
	}

	
}
