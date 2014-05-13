<?php

/**
 * This is the "base controller class". All other "real" controllers extend this class.
 */
class Controller
{
    /**
     * @var null Database Connection
     */
    public $db = null;
	//public $ldapBind = null;
	public $ldapCon = null;

    /**
     * Whenever a controller is created, open a database connection too. The idea behind is to have ONE connection
     * that can be used by multiple models (there are frameworks that open one connection per model).
     */
    function __construct()
    {
        $this->openDatabaseConnection();
		$this->openLdapConnection();
    }

    /**
     * Open the database connection with the credentials from application/config/config.php
     */
    private function openDatabaseConnection()
    {
        // set the (optional) options of the PDO connection. in this case, we set the fetch mode to
        // "objects", which means all results will be objects, like this: $result->user_name !
        // For example, fetch mode FETCH_ASSOC would return results like this: $result["user_name] !
        // @see http://www.php.net/manual/en/pdostatement.fetch.php
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        // generate a database connection, using the PDO connector
        // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
		//Pour une base Oracle on met un '/' entre le type et le host  
        $this->db = new PDO(DB_TYPE .':dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
    }
	/**
	* Lance une connection Ldap vers le serveur spécifié dans le fichier application/config/config.php
	*/
	private function openLdapConnection(){
		
		$this->ldapCon = ldap_connect(LDAP_HOST,LDAP_PORT)
            or die("Could not connect to LDAP server.");

		// Set some ldap options for talking to 
		ldap_set_option($this->ldapCon, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($this->ldapCon, LDAP_OPT_REFERRALS, 0);
		$this->ldapBind = null;
		/*if ($this->ldapCon) {

				// binding to ldap server
				$this->ldapBind = @ldap_bind($this->ldapCon, LDAP_RDN, LDAP_PASS) or die("Could not bind to LDAP con.");
		}*/
	}
	
    /**
     * Load the model with the given name.
     * loadModel("SongModel") would include models/songmodel.php and create the object in the controller, like this:
     * $songs_model = $this->loadModel('SongsModel');
     * Note that the model class name is written in "CamelCase", the model's filename is the same in lowercase letters
     * @param string $model_name The name of the model
     * @return object model
     */
    public function loadModel($model_name)
    {
        require 'application/models/' . strtolower($model_name) . '.php';
        // return new model (and pass the database connection to the model)
        return new $model_name($this->db,$this->ldapCon,$this->ldapBind);//on passe aussi au model les attribut de co LDAP
    }
}
