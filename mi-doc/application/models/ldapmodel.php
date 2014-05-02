<?php	

define('USERS_TREE', 'ou=users,dc=projetsi,dc=com');
define('SERVICES_TREE', 'ou=services,dc=projetsi,dc=com');
define('typeOfAttributeBinding', 'uid=');

class LdapModel
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
	
public  function Connexion($uid,$password)
	{

		//Connection au LDAP
		$ds=$this->ldapCon;

		try{
			$this->ldapBind = ldap_bind($ds, typeOfAttributeBinding.$uid.','.USERS_TREE, $password);//BIND LDAP
		} catch(Exception $eBind){
			exit('Could not bind to ldap connection.');
		}
		
		// verify binding
		if ($this->ldapBind) {
			$info = LdapModel::SearchUser($uid);
			if(count($info) > 0){
				echo "LDAP bind successful... Welcome ".$info[0]["mail"][0]."<br/>";
				$_SESSION['cn'] = $info[0]["cn"][0];
				$_SESSION['sn'] = $info[0]["sn"][0];
				$_SESSION['mail'] = $info[0]["mail"][0];
				$_SESSION['uid'] = $info[0]["uid"][0];
				$_SESSION['mail'] = $info[0]["mail"][0];
				$service = LdapModel::SearchServiceUtilisateur($uid);
				if($service != 0)
					$_SESSION['service'] = $service[0]["cn"][0]; // on récup le service
			}
			return $ds;
		} else {
			echo "LDAP bind failed...\n";
			return 0;
		}
	}
	

	public function SearchUser($uid)
	{
		$ds=$this->ldapCon;
		
		
		//Recherche des infos associé a l'utilisateur
		$sr=ldap_search($ds,USERS_TREE, 'uid='.$uid);  
		$info = ldap_get_entries($ds, $sr);
		
		//echo 'User :'.$info[0]["cn"][0];
		if($info["count"] > 0){
			return $info;
		}
		else
			return 0;
	}
	
	public function SearchServiceUtilisateur($uid)
	{	
		$ds=$this->ldapCon;
		
		//Recherche du service de l'utilisateur
		$result = ldap_search(
				$ds,
				SERVICES_TREE,
				'(&(objectClass=groupOfUniqueNames)(uniqueMember=uid='.$uid.'))'
		);
		
		$group = ldap_get_entries($ds, $result);
		
		if($group["count"] > 0)
			return $group;
		else
			return 0;
		
	}
	
	public function isResponsableService($uid)
	{
		$ds=$this->ldapCon;

		$group = SearchService($uid);
		
		if($group != 0)
		{
			$service = $group["dn"][0];
			
			//Recherche si responsable de services
			$result = ldap_search(
					$ds,
					'cn=Responsables, '.$service,
					'(&(objectClass=groupOfUniqueNames)(uniqueMember=uid='.$uid.'))'
			);
			
			$group = ldap_get_entries($ds, $result);
		}
		
		if($group["count"] > 0)
			return true;
		else
			return 0;
	}
	
	public function DelResponsableService($uid)
	{
		$ds=$this->ldapCon;

		$group = SearchService($uid);
		
		if($group != 0)
		{
			$service = $group["dn"][0];
			
			//Recherche si responsable de services
			$result = ldap_search(
					$ds,
					'cn=Responsables, '.$service,
					'(&(objectClass=groupOfUniqueNames)(uniqueMember=uid='.$uid.'))'
			);
			
			//Supprime l'utilisateur de la liste des responsable du service
			$r = ldap_mod_del($ds, $group["dn"][0], $entry);
		}
		
		if($r)
			return true;
		else
			return false;
	}
	
	public function AddResponsableService($uid, $dnService)
	{
		$ds=$this->ldapCon;

		$group = SearchService($uid);
		
		$entry['uniqueMember'] = "uid=".$uid;
		
		//On supprime l'utilisateur des responsables de son ancien service si il était responsable
		DelResponsableService($uid);
		
		//Ajoute l'utilisateur comme responsable du service
		$r = ldap_mod_add($ds, 'cn=Responsables, '.$dnService, $entry);
		
		if($r)
			return true;
		else
			return false;
	}
	
	public function DelUtilisateurService($uid)
	{
		$ds=$this->ldapCon;
		
		$group = SearchService($uid);

		$entry['uniqueMember'] = "uid=".$uid;
		
		//Supprime l'utilisateur dans le service
		$r = ldap_mod_del($ds, $group["dn"][0], $entry);
		
		if($r)
			return true;
		else
			return false;
	}
	
	public function AddUtilisateurService($uid, $dnService)
	{
		$ds=$this->ldapCon;
		
		$group = SearchService($uid);
		
		$entry['uniqueMember'] = "uid=".$uid;
		
		//On supprime l'utilisateur de son ancien groupe si il en avait un
		DelUtilisateurService($uid);

		//Ajoute l'utilisateur dans le service
		$r = ldap_mod_add($ds, $dnService, $entry);
		
		if($r)
			return true;
		else
			return false;
	}
	
	public function DelUser($uid)
	{
		$ds=$this->ldapCon;
		
		//Supprime l'utilisateur de la base des users
		$r = ldap_delete($ds, "uid=".$uid.",".USERS_TREE);
		
		if($r)
			return true;
		else
			return false;
	}
	
	//Brief : Prend un cn=Prenom Nom, un password et une adresse mail et crée un nouvel utilisateur
	//Return : 0 si cree, 1 si echec
	public function CreateUser($cn,$password_user,$mail)
	{		
		$ds=$this->ldapCon;
		
		$parse = explode(" ", $cn);
		
		$i=0;
		$uid_user=NULL;
		
		//decoupage du prenom et du nom
		foreach($parse as $compo)
		{
			echo $compo.'<br/>';
		}
		
		foreach($parse as $compo)
		{
			if($i==0)
			{
				for($j=0;$j<2;$j++)
				{
					$uid_user = $uid_user.$compo[$j];
				}
			}
			
			if($i>0 && strlen($uid_user) < 8)
			{
				for($j=0;$j<strlen($compo) && strlen($uid_user) < 8 ;$j++)
				{
					$uid_user = $uid_user.$compo[$j];
				}
			}
			
			$i++;
		}
		
		$salt = mcrypt_create_iv(8, MCRYPT_DEV_URANDOM);
		$hash = '{ssha512}' . base64_encode(hash('sha512', $password_user . $salt, TRUE) . $salt);
		
		// prepare data
		$info["cn"] = $cn;
		$info["sn"] = strtolower($uid_user);
		$info["uid"] = strtolower($uid_user);
		$info["mail"] = $mail;
		$info["userPassword"] = $hash;
		$info["objectclass"] = "inetOrgPerson";

		// add data to directory
		$r = ldap_add($ds, "uid=".$uid_user.", ".$baseUsers, $info);
		ldap_close($ds);
		
		if($r)
			return 0;
		else
			return 1;
	}
	
	//Brief : Prend un nom de service et un UID d'utilisateur valide et creer un service
	//Attention, si le nom de l'admin service est mal orthographié, rien n'empechera la creation du service mais il n'y aura pas d'admin service reel
	//Return : 0 si cree, 1 si echec
	public function CreateService($nomService, $nomAdminService)
	{
			
		$ds=$this->ldapCon;
		
		// prepare data
		$info["cn"] = $nomService;
		$info["uniqueMember"] = $typeOfAttributeBinding.$nomAdminService;
		$info["objectclass"] = "groupOfUniqueNames";

		// add data to directory
		$r = ldap_add($ds, "cn=".$nomService.", ".$baseServices, $info);
		ldap_close($ds);
			
		if($r)
			return 0;
		else
			return 1;
	}
	
	public function DelService($nomService)
	{
		$ds=$this->ldapCon;
		
		//Supprime un service de la base des services
		$r = ldap_delete($ds, "cn=".$nomService.",".SERVICES_TREE);
		
		if($r)
			return true;
		else
			return false;
	}
}
