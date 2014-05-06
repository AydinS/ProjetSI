<?php

class ExtensionDroitModel
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

    }
	
	public function getAllDemande($uid,$navModel)
	{
			
		$req_validation="SELECT * FROM demande_extension";
		$query = $this->db->prepare($req_validation);
		$query->execute();
		$res = $query->fetchAll();
		
		$infos = array();
		$i=0;
		
		foreach($res as $r){
		
			$appartient= $navModel->getFilesInfoByIdFic($r->ID_FICHIER,null);
			//$service= $ldapModel->SearchServiceUtilisateur($uid);
			
			if(($appartient['SERVICE'] == $_SESSION['SERVICE'] ))
			{
				$infos[$i]['id_demande'] = $r->ID_DEMANDE;
				$infos[$i]['nom'] = $appartient['NOM'];
				$infos[$i]['id_fichier']=  $appartient['ID_FICHIER'];
				$infos[$i]['demandeur'] = $r->ID_USER;
				$infos[$i]['droit'] = $r->DROIT;
				$infos[$i]['statut'] = $r->STATUT;
				$i++;
			}
		}
		
		if(count($res) > 0){
			return $infos;
		}
		else return -1;
	}
	
	public function addDroit($uid,$id_fichier,$droit)
	{
		try {
			
		$stmt = $this->db->prepare("INSERT INTO droit (ID_USER, ID_FICHIER, DROIT) VALUES (:id_user, :id_fichier, :droit)");
		$stmt->bindParam(':id_user', $uid);
		$stmt->bindParam(':id_fichier', $id_fichier);
		$stmt->bindParam(':droit', $droit);
		}
		catch (Exception $e) {
			if(DEBUG) die('Erreur : '.$e->getMessage());
			return false;
		}
		// insertion d'une ligne
		$stmt->execute();
	}
	
	public function updateStatus($id_demande, $value)
	{
		try {
			
		$stmt = $this->db->prepare("UPDATE  demande_extension SET STATUT = :statut WHERE ID_DEMANDE = :id_demande");
		$stmt->bindParam(':id_demande', $id_demande);
		$stmt->bindParam(':statut', $value);
		}
		catch (Exception $e) {
			if(DEBUG) die('Erreur : '.$e->getMessage());
			return false;
		}
		// insertion d'une ligne
		$stmt->execute();
	}
}
?>