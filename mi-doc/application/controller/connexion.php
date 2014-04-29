<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
//ini_set("display_errors",0);error_reporting(o);
class Connexion extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        // debug message to show where you are, just for the demo
        //echo 'test LDAAAP';
        // load views. within the views we can echo out $songs and $amount_of_songs easily
        require 'application/views/_templates/header.php';
        
		//$contactsModel = $this->loadModel('testLdapModel');
        //$contacts = $contactsModel->getPersonnes();
		
		require 'application/views/connexion/connexion_form.php';
        require 'application/views/_templates/footer.php';
    }
	
	public function login(){
		require 'application/views/_templates/header.php';
		$ldapModel = $this->loadModel('ldapmodel');
		if(isset($_POST['login']) && isset($_POST['mdp'])){
			$con = $ldapModel->Connexion($_POST['login'],$_POST['mdp']);
			if(!$con){
				//if(!isset($_POST['login']))
					$erreur['login'] = true;
				//if(!isset($_POST['mdp']))	
					$erreur['mdp'] = true;
				
				require 'application/views/connexion/connexion_form.php';
			}
			if($con) header("Location: ".URL);
		}
		else{
			if(!isset($_POST['login']))
				$erreur['login'] = true;
			if(!isset($_POST['mdp']))	
				$erreur['mdp'] = true;
				
			require 'application/views/connexion/connexion_form.php';
		}
		
		require 'application/views/_templates/footer.php';
	}
	
	public function logout(){
		
		if(isset($_SESSION)){
			session_unset();
			session_destroy();
		}
		header("Location: ".URL."connexion/index");
	}
}
