<?php

class Navigation extends Controller
{
	/**
	* Fonction appellée quand on clique sur Navigation dans le menu à gauche
	*
	*/
	public function index(){
		
		//echo $_SESSION['service'];
		require 'application/views/_templates/header.php';
		if(isset($_SESSION['SERVICE'])){
			//si user connectÃ© et si on connait le service de l'utilisateur
			// on instancie le model navigationmodel pour récup les fichier de la racine de son service
			$navModel = $this->loadModel('navigationmodel');
			//on récupère l'id du service de l'utilisateur
			$infoService = $navModel->getServiceId($_SESSION['SERVICE'],$_SESSION['uid']);
			if($infoService != -1){// on a bien récupéré l'id service
				
				$path = __DIR__.'../../'.RACINE.$_SESSION['SERVICE'];
				
				$nomDossier = $navModel->getCurrentLocation(RACINE.$_SESSION['SERVICE'],$infoService['ID_FICHIER']);
				//on affiche tous les fichiers du service
				$fichiers = $navModel->getAllFilesByParents($infoService['ID_FICHIER'],$_SESSION['uid']);
				$_SESSION['CURR_DIR_PATH'] = $path;
				$_SESSION['CURR_DIR_ID'] = $infoService['ID_FICHIER'];
				$_SESSION['CURR_DIR_SERVICE'] = $infoService['SERVICE'];
				$_SESSION['CURR_DIR_OWNER'] = $infoService['ID_USER'];
				$droit = $navModel->getDroit($_SESSION['uid'],$_SESSION['CURR_DIR_ID']);
			}
			
		}
		
        require 'application/views/navigation/index.php';
        require 'application/views/_templates/footer.php';
		
	}
	
	/**
	* Fonction appellée quand on clique sur un dossier de la liste des fichiers
	* param : l'id fichier
	*/
	public function displaycontent($idfic){
		require 'application/views/_templates/header.php';
		
		if(isset($idfic)){
			
			$navModel = $this->loadModel('navigationmodel');
			//rÃ©cupÃ¨re les infos du dossier que l'utilisateur veut consulter
			$infoService = $navModel->getFilesInfoByIdFic($idfic);
			$path = $infoService['PATH'];
			//on récupère le chemin vers dossier courant
			$nomDossier = $navModel->getCurrentLocation($infoService['PATH'],$idfic);//
			//on récupère tous les fichiers du dossier
			$fichiers = $navModel->getAllFilesByParents($infoService['PARENT'],$_SESSION['uid']);	
			$_SESSION['CURR_DIR_PATH'] = $path;
			$_SESSION['CURR_DIR_ID'] = $infoService['PARENT'];
			$_SESSION['CURR_DIR_SERVICE'] = $infoService['SERVICE'];
			$_SESSION['CURR_DIR_OWNER'] = $infoService['ID_USER'];
			$droit = $navModel->getDroit($_SESSION['uid'],$infoService['PARENT']);
		}
		require 'application/views/navigation/index.php';
        require 'application/views/_templates/footer.php';
		
	}
	
	/**
	* Fonction appellée quand on clique sur un dossier qui compose le chemin vers le dossier courant 
	*/
	public function goToDirectory(){
		
		require 'application/views/_templates/header.php';
		if(isset($_POST['gotodirectory']) && isset($_POST['idfic'])){
			$navModel = $this->loadModel('navigationmodel');
			$infoService = $navModel->getFilesInfoByIdFic((int)$_POST['idfic'],$_SESSION['uid']);
			$path = __DIR__.'../../'.$_POST['gotodirectory'];
			//on récupère le chemin vers dossier courant
			$nomDossier = $navModel->getCurrentLocation((string)$_POST['gotodirectory'],(int)$_POST['idfic']);
			//on récupère tous les fichiers du dossier
			$fichiers = $navModel->getAllFilesByParents((int)$_POST['idfic'],$_SESSION['uid']);
			$_SESSION['CURR_DIR_PATH'] = $path;
			$_SESSION['CURR_DIR_ID'] = $_POST['idfic'];
			$_SESSION['CURR_DIR_SERVICE'] = $infoService['SERVICE'];
			$_SESSION['CURR_DIR_OWNER'] = $infoService['ID_USER'];
			$droit = $navModel->getDroit($_SESSION['uid'],$_POST['idfic']);
		}
		require 'application/views/navigation/index.php';
        require 'application/views/_templates/footer.php';
	}
	
	/**
	* Fonction appellée pour aller vers le dosssier d'ID idDossier
	* param : l'id dossier
	*/
	public function goToFolder($idDossier){
		
		require 'application/views/_templates/header.php';
		if(isset($idDossier)){
			$navModel = $this->loadModel('navigationmodel');
			$infoService = $navModel->getFilesInfoByIdFic($idDossier,$_SESSION['uid']);
			//on récupère le chemin vers dossier courant
			$path = __DIR__.'../../'.$infoService['PATH'].'/'.$infoService['NOM'];
			$nomDossier = $navModel->getCurrentLocation((string)$infoService['PATH'].'/'.$infoService['NOM'],$idDossier);
			//on récupère tous les fichiers du dossier
			$fichiers = $navModel->getAllFilesByParents((int)$idDossier,$_SESSION['uid']);
			$_SESSION['CURR_DIR_PATH'] = $path;
			$_SESSION['CURR_DIR_ID'] = $idDossier;
			$_SESSION['CURR_DIR_SERVICE'] = $infoService['SERVICE'];
			$_SESSION['CURR_DIR_OWNER'] = $infoService['ID_USER'];
			$droit = $navModel->getDroit($_SESSION['uid'],$idDossier);
		}
		require 'application/views/navigation/index.php';
        require 'application/views/_templates/footer.php';
	}
	
	/**
	* Fonction qui va afficher les dossier extérieurs (au service de l'utilisateur coonecté) partagés avec l'utilisateur
	* appellée quand on clique sur Dossiers partagées
	*/
	public function displaySharedFiles(){
		
		require 'application/views/_templates/header.php';
		if(isset($_SESSION['SERVICE']) and isset($_SESSION['uid'])){
			$_SESSION['CURR_DIR_PATH'] = "";
			$_SESSION['CURR_DIR_ID'] = "";
			$_SESSION['CURR_DIR_SERVICE'] = "";
			$_SESSION['CURR_DIR_OWNER'] = "";
			$navModel = $this->loadModel('navigationmodel');
			$nomDossier = array();
			$nomDossier[0] = "Dossier partages";
			$fichiers = $navModel->getAllSharedFolders($_SESSION['uid']);
			
		}
		require 'application/views/navigation/index.php';
        require 'application/views/_templates/footer.php';
	}
	
	
	/**
	* Fonction appellée quand on clique sur le bouton supprimer 
	*
	*/
	public function DeleteFileNavigation()
	{
		require 'application/views/_templates/header.php';
		
		if(isset($_SESSION['RESPONSABLE']) && isset($_POST['idfic']))
		{
			$fichier = $_POST['idfic'];
			$idResponsable = $_SESSION['RESPONSABLE'];
			$navModel = $this->loadModel('navigationmodel');
			$infoService = $navModel->getFilesInfoByIdFic($fichier);
			$parent = $infoService['PARENT'];
			
			if($idResponsable == 1) $delete = $navModel->DeleteFile($idResponsable, $fichier);
			else $delete = $navModel->DeleteFile($_SESSION['uid'], $fichier);
			header('location:'.URL.'navigation/goToFolder/'.$parent.'');
		}
		
		require 'application/views/navigation/index.php';
        require 'application/views/_templates/footer.php';
	}
	
	public function uploadto()
	{
		require 'application/views/_templates/header.php';
		if(isset($_POST['chemin'])) $chemin = $_POST['chemin'];
		else $chemin = $_GET['chemin'];
		if(isset($_POST['parent'])) $parent = $_POST['parent'];
		else $parent = $_GET['parent'];
		
		if(isset($_POST['modif'])) $modif = $_POST['modif'];
		else if(isset($_GET['modif'])) $modif = $_GET['modif'];
		$service = $_SESSION['SERVICE'];
		
		$ldapModel = $this->loadModel('LdapModel');
		$allUser = $ldapModel->SearchAllUserService($service);	
		
		
		if(isset($_POST['description']))
		{
			if($_FILES['uploadfile']['error'] > 0) $erreur = "Erreur lors du transfert";
			$uid = $_SESSION['uid'];
			$description = $_POST['description'];
			
			$dossier = 0;
			$fichier = $_FILES['uploadfile']['name'];			
			
			
			$path = __DIR__.$chemin;
			$path = str_replace('/', '\\', $path);
			$path = str_replace('\\controller', '', $path);
			$chemin = str_replace('/services', 'services', $chemin);
			
			$navModel = $this->loadModel('navigationmodel');
			$exist = $navModel->dossierExists($fichier, $chemin);
			
			
			if($exist == false)
			{
				echo '<div class="alert alert-danger">';
					echo 'L\'upload n\'a pas eu lieu car le nom de fichier "'.$fichier.'" existe déjà dans le répertoire "'.$chemin.'"!';
				echo '</div>';
				
				require 'application/views/navigation/form_upload.php';
			}
			else
			{
				if(isset($modif) && $modif!="")
				{
					if(isset($_POST['fic'])) $fic = $_POST['fic'];
					else $fic = $_GET['fic'];
					
					$infoService = $navModel->updateUploadFile($fic, $uid, $description, $fichier, $chemin);
					
					if(isset($_POST['list_checked']) && isset($_POST['singlebutton2'])) //Demande de validation lors d'un update
					{
						$valModel = $this->loadModel('validationmodel');
						$insertVal = $valModel->insertValidation($fic, $uid);
						
						$getVal = $valModel->getIdValidation($fic, $uid);
						
						$faireModel = $this->loadModel('fairemodel');
						foreach($_POST['list_checked'] as $list_checked)
						{
							$insertFaire = $faireModel->insertFaire($getVal, $list_checked);
						}
					}
				}
				else
				{
					$infoService = $navModel->uploadFile($uid, $description, $fichier, $chemin, $dossier, $service, $parent);
					
					if(isset($_POST['list_checked']) && isset($_POST['singlebutton2'])) //Demande de validation lors d'un update
					{
						$fic = $navModel->getIdFichierWithAllInfo($uid, $fichier, $chemin, $dossier, $service, $parent);
						echo "L'id du fichier est $fic";
						$valModel = $this->loadModel('validationmodel');
						$insertVal = $valModel->insertValidation($fic, $uid);
						
						$getVal = $valModel->getIdValidation($fic, $uid);
						
						$faireModel = $this->loadModel('fairemodel');
						foreach($_POST['list_checked'] as $list_checked)
						{
							$insertFaire = $faireModel->insertFaire($getVal, $list_checked);
						}
					}
				}
				
				echo '<div class="container text-left" >'.'<legend>Upload :'.$_FILES['uploadfile']['name'].'</legend>';
				if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $path.'\\'.$fichier))
				{
						echo '<div class="alert alert-success">';
							echo 'Upload effectué avec succès !';
						echo '</div>';
				}
				else //Sinon (la fonction renvoie FALSE).
				{
						echo '<div class="alert alert-danger">';
							echo 'Echec de l\'upload !';
						echo '</div>';
				}
				echo '</div>';
				
				header('location:'.URL.'navigation/goToFolder/'.$parent.'');
			}
		}
		else
		{
			if(isset($modif))
			{
				if(isset($_POST['fic'])) $fic = $_POST['fic'];
				else $fic = $_GET['fic'];
				
				$navModel = $this->loadModel('navigationmodel');
				$infoFile = $navModel->getFilesInfoByIdFic($fic);
			}
			
			require 'application/views/navigation/form_upload.php';
		}
        require 'application/views/_templates/footer.php';
	}


	/**
	 * Créateur : EJA
	 * MàJ : 18/05/2014
     * Methode: creerDossier
     * Comportement : Créée un dossier puis affiche le dossier qui contient le nouveau dossier créé
     * Paramètres IN : void
     * Paramètres OUT : void
     * Page IN possibles : views/naviguation/index.php
     * Page out possibles : views/naviguation/index.php
     */
    public function creerDossier()
    {
        //Traitements 
        // 1] creer le dossier
        if(isset($_POST['nomDoss']) && isset($_POST['descDoss'])){//on test si les données rentrée par l'utilisateur existent
       		$dossierModel = $this->loadModel('navigationmodel');
        	if($dossierModel->dossierExists($_POST['nomDoss'],$_SESSION['CURR_DIR_SERVICE']))//on test si un dossier avc le même nom n'existe pas deja
            	$dossierModel->creerDossier($_POST['truePath'],$_SESSION['CURR_DIR_PATH'],$_POST['nomDoss'],$_POST['descDoss'],$_SESSION['uid'],$_POST['trueCurrID'],$_SESSION['SERVICE']);
            else
            	$erreurCreatDoss = "Un dossier du même nom existe dejà";
        }
        else
            $erreurCreatDoss = "Les informations renseignées ne sont pas valides";
        // 2] Afficher la page ayant appelé la création de dossier
        header('location:'.URL.'navigation/goToFolder/'.$_POST['trueCurrID']);
    }

}



?>