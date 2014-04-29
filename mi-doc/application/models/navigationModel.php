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
	
	public function getAllFilesInFolder($path){
		$req = "SELECT * FROM FICHIER WHERE PATHS = :path LIMIT 0,15";
		$query = $this->db->prepare($req);
		$res = $query->execute(array(':path' => $path));
	}
	
}
