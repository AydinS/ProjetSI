<?php


class DroitModel
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
	*Renvoie le droit que possède un utilisateu sur u fichier
	*
	*/
	public function getDroitByUser($idDroit,$idUser,$idFic){
		$req = "SELECT DROIT FROM DROIT WHERE ID_DROIT = :iddroit and ID_USER = :iduser and ID_FICHIER = :idfic";
		$query = $this->db->prepare($req);
		$query->execute(array(':iddroit' => $idDroit, ':iduser' => $idUser, ':idfic' => $idFic));
		return $query->fetchAll();
	}
	
}
