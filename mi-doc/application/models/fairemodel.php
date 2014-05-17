<?php


class FaireModel
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
	*Renvoie la validation à faire pour un utilisateur
	*
	*/
	public function getStatut($idFaire,$idVal,$idUser){
		$req = "SELECT STATUT FROM FAIRE WHERE ID_FAIRE = :idfaire and ID_USER = :iduser and ID_VALIDATION = :idval";
		$query = $this->db->prepare($req);
		$query->execute(array(':idfaire' => $idFaire, ':iduser' => $idUser, ':idval' => $idVal));
		return $query->fetchAll();
	}
	
	function insertFaire($validation, $user)
	{
		$req = "INSERT INTO FAIRE(ID_VALIDATION, ID_USER) VALUES('".$validation."','".$user."')";
		$query = $this->db->prepare($req);
		$query->execute();
	}
	
}
