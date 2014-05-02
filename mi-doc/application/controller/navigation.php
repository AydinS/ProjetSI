<?php

class Navigation extends Controller
{

	public function index(){
		
		//echo $_SESSION['service'];
		require 'application/views/_templates/header.php';
		if(isset($_SESSION['SERVICE'])){
			//si user connecté et si on connait le service de l'utilisateur
			// on instancie le model navigationmodel pour récup les fichier de la racine de son service
			$navModel = $this->loadModel('navigationmodel');
			// on récupère l'id de la racine du service pour ensuite faire un readdir et une requete renvoyant tous les fichier qui ont pour parent l'id 
			$infoService = $navModel->getServiceId($_SESSION['SERVICE'],$_SESSION['uid']);
			if($infoService != -1){// on a bien récupérer l'id service
				
				$path = __DIR__.'../../'.RACINE.$_SESSION['SERVICE'];
				
				$nomDossier = $navModel->getCurrentLocation(RACINE.$_SESSION['SERVICE'],$infoService['ID_FICHIER']);
				
				$fichiers = $navModel->getAllFilesByParents($infoService['ID_FICHIER']);
				$_SESSION['CURR_DIR_PATH'] = $path;
				$_SESSION['CURR_DIR_ID'] = $infoService['ID_FICHIER'];
			}
			
		}
		
        require 'application/views/navigation/index.php';
        require 'application/views/_templates/footer.php';
		
	}
	
	/**
	* Fonction appellée quand on clique sur un dossier de la liste de fichiers
	*
	*/
	public function displaycontent($idfic){
		require 'application/views/_templates/header.php';
		
		if(isset($idfic)){
			
			$navModel = $this->loadModel('navigationmodel');
			//récupère les infos du dossier que l'utilisateur veut consulter
			$infoService = $navModel->getFilesInfoByIdFic($idfic);
			//ici on teste si l'utilisateur à les droits sur le fichier d'id idfic et s'il n'a pas les droits on le redirige on sort de la fonction par un return
			
			$path = $infoService['PATH'];
			$nomDossier = $navModel->getCurrentLocation($infoService['PATH'],$idfic);//
			$fichiers = $navModel->getAllFilesByParents($infoService['PARENT'],$_SESSION['uid']);	
			$_SESSION['CURR_DIR_PATH'] = $path;
			$_SESSION['CURR_DIR_ID'] = $idfic;
		}
		require 'application/views/navigation/index.php';
        require 'application/views/_templates/footer.php';
		
	}
	
	/**
	* Fonction appellée quand on clique sur un dossier qui compose le chemin vers le dossier courant 
	*
	*/
	public function goToDirectory(){
		
		require 'application/views/_templates/header.php';
		if(isset($_POST['gotodirectory']) && isset($_POST['idfic'])){
			$navModel = $this->loadModel('navigationmodel');
			$infoService = $navModel->getFilesInfoByIdFic((int)$_POST['idfic'],$_SESSION['uid']);
			//ici on teste si l'utilisateur à les droits sur le fichier d'id idfic et s'il n'a pas les droits on le redirige on sort de la fonction par un return
			
			$path = __DIR__.'../../'.$_POST['gotodirectory'];
			$nomDossier = $navModel->getCurrentLocation((string)$_POST['gotodirectory'],(int)$_POST['idfic']);
			$fichiers = $navModel->getAllFilesByParents((int)$_POST['idfic']);
			$_SESSION['CURR_DIR_PATH'] = $path;
			$_SESSION['CURR_DIR_ID'] = $_POST['idfic'];
		}
		require 'application/views/navigation/index.php';
        require 'application/views/_templates/footer.php';
	}

}



?>