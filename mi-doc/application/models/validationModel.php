<?php

class ValidationModel
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
	
	function insertValidation($fichier, $user)
	{
		$req = "INSERT INTO VALIDATION(ID_FICHIER, ID_USER) VALUES('".$fichier."','".$user."')";
		$query = $this->db->prepare($req);
		$query->execute();
	}
	
	function getIdValidation($fichier, $user)
	{
		$req = "SELECT * FROM VALIDATION WHERE ID_FICHIER='".$fichier."' AND ID_USER='".$user."'";
		$query = $this->db->prepare($req);
		$query->execute();
		
		$res = $query->fetchAll();
		foreach($res as $r){
			$infos = $r->ID_VALIDATION;
		}
		
		if(count($res) > 0){
			return $infos;
		}else return 0;
	}
}
?>