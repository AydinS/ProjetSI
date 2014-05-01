<?php

class Navigation extends Controller
{

	public function index(){
		
		//echo $_SESSION['service'];
		require 'application/views/_templates/header.php';
		if(isset($_SESSION['service'])){
			//si user connecté et si on connait le service de l'utilisateur
			// on instancie le model navigationmodel pour récup les fichier de la racine de son service
			$navModel = $this->loadModel('navigationmodel');
			// on récupère l'id de la racine du service pour ensuite faire un readdir et une requete renvoyant tous les fichier qui ont pour parent l'id 
			$infoService = $navModel->getServiceId($_SESSION['service']);
			if($infoService != -1){// on a bien récupérer l'id service
				//$idService = $infoService->ID_SERVICE;
				//$folderService = $infoService->NOM;
				//recup ici tous les fichier du dossier
				$path = __DIR__.'../../'.RACINE.$_SESSION['service'];
				//$path = __DIR__.'../../'.RACINE.$_SESSION['service'];
				$nomDossier = $navModel->getCurrentLocation(RACINE.$_SESSION['service'],$infoService['ID_FICHIER']);
				//$files = $navModel->getAllFilesByParents($infoService['ID_FICHIER'],null,$path);
				$fichiers = $navModel->getAllFilesByParents($infoService['ID_FICHIER']);
				$_SESSION['CURR_DIR'] = $path;
			}
			
		}
		
        require 'application/views/navigation/index.php';
        require 'application/views/_templates/footer.php';
		
	}
	
	public function displaycontent($idfic){
		require 'application/views/_templates/header.php';
		
		if(isset($idfic)){
			
			$navModel = $this->loadModel('navigationmodel');
			$infoService = $navModel->getFilesInfoByIdFic($idfic);
			$path = $infoService['PATH'];
			$nomDossier = $navModel->getCurrentLocation($infoService['PATH'],$idfic);
			$fichiers = $navModel->getAllFilesByParents($infoService['PARENTS'],$_SESSION['uid']);	
				
		}
		require 'application/views/navigation/index.php';
        require 'application/views/_templates/footer.php';
		
	}
	
	public function goToDirectory(){
		
		require 'application/views/_templates/header.php';
		if(isset($_POST['gotodirectory']) && isset($_POST['idfic'])){
			$navModel = $this->loadModel('navigationmodel');
			$path = __DIR__.'../../'.$_POST['gotodirectory'];
			$nomDossier = $navModel->getCurrentLocation($_POST['gotodirectory'],$_POST['idfic']);
			$fichiers = $navModel->getAllFilesByParents($_POST['idfic']);
		}
		require 'application/views/navigation/index.php';
        require 'application/views/_templates/footer.php';
	}

}



?>