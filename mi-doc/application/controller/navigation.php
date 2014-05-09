<?php

class Navigation extends Controller
{

	public function index(){
		
		//echo $_SESSION['service'];
		require 'application/views/_templates/header.php';
		if(isset($_SESSION['SERVICE'])){
			//si user connectÃ© et si on connait le service de l'utilisateur
			// on instancie le model navigationmodel pour rÃ©cup les fichier de la racine de son service
			$navModel = $this->loadModel('navigationmodel');
			// on rÃ©cupÃ¨re l'id de la racine du service pour ensuite faire un readdir et une requete renvoyant tous les fichier qui ont pour parent l'id 
			$infoService = $navModel->getServiceId($_SESSION['SERVICE'],$_SESSION['uid']);
			if($infoService != -1){// on a bien rÃ©cupÃ©rer l'id service
				
				$path = __DIR__.'../../'.RACINE.$_SESSION['SERVICE'];
				
				$nomDossier = $navModel->getCurrentLocation(RACINE.$_SESSION['SERVICE'],$infoService['ID_FICHIER']);
				
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
	* Fonction appellÃ©e quand on clique sur un dossier de la liste de fichiers
	* Fonction va se rendre dans le parent du fichier qui a pour ID idfic
	*/
	public function displaycontent($idfic){
		require 'application/views/_templates/header.php';
		
		if(isset($idfic)){
			
			$navModel = $this->loadModel('navigationmodel');
			//rÃ©cupÃ¨re les infos du dossier que l'utilisateur veut consulter
			$infoService = $navModel->getFilesInfoByIdFic($idfic);
			//ici on teste si l'utilisateur Ã  les droits sur le fichier d'id idfic et s'il n'a pas les droits on le redirige on sort de la fonction par un return
			
			$path = $infoService['PATH'];
			$nomDossier = $navModel->getCurrentLocation($infoService['PATH'],$idfic);//
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
	* Fonction appellÃ©e quand on clique sur un dossier qui compose le chemin vers le dossier courant 
	* 	
	*/
	public function goToDirectory(){
		
		require 'application/views/_templates/header.php';
		if(isset($_POST['gotodirectory']) && isset($_POST['idfic'])){
			$navModel = $this->loadModel('navigationmodel');
			$infoService = $navModel->getFilesInfoByIdFic((int)$_POST['idfic'],$_SESSION['uid']);
			//ici on teste si l'utilisateur Ã  les droits sur le fichier d'id idfic et s'il n'a pas les droits on le redirige on sort de la fonction par un return
			
			$path = __DIR__.'../../'.$_POST['gotodirectory'];
			$nomDossier = $navModel->getCurrentLocation((string)$_POST['gotodirectory'],(int)$_POST['idfic']);
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
	* Fonction appellÃ©e pour aller vers le dosssier d'ID idDossier
	* 
	*/
	public function goToFolder($idDossier){
		
		require 'application/views/_templates/header.php';
		if(isset($idDossier)){
			$navModel = $this->loadModel('navigationmodel');
			$infoService = $navModel->getFilesInfoByIdFic($idDossier,$_SESSION['uid']);
			//ici on teste si l'utilisateur Ã  les droits sur le fichier d'id idfic et s'il n'a pas les droits on le redirige on sort de la fonction par un return
			
			$path = __DIR__.'../../'.$infoService['PATH'].'/'.$infoService['NOM'];
			$nomDossier = $navModel->getCurrentLocation((string)$infoService['PATH'].'/'.$infoService['NOM'],$idDossier);
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
	* Fonction qui va afficher les dossier extÃ©rieurs (au service de l'utilisateur coonectÃ©) partagÃ©s avec l'utilisateur
	* 
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
	* Fonction appellÃ©e quand on clique sur le bouton supprimer 
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
			$delete = $navModel->DeleteFile($idResponsable, $fichier);
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
		
		if(isset($_POST['description']))
		{
			if($_FILES['uploadfile']['error'] > 0) $erreur = "Erreur lors du transfert";
			$uid = $_SESSION['uid'];
			$description = $_POST['description'];
			
			$dossier = 0;
			$service = $_SESSION['SERVICE'];
			$fichier = $_FILES['uploadfile']['name'];			
			
			$path = __DIR__.$chemin;
			$path = str_replace('/', '\\', $path);
			$path = str_replace('\\controller', '', $path);
			$chemin = str_replace('/services', 'services', $chemin);
			
			
			$navModel = $this->loadModel('navigationmodel');
			
			if(isset($modif) && $modif!="")
			{
				if(isset($_POST['fic'])) $fic = $_POST['fic'];
				else $fic = $_GET['fic'];
				
				$infoService = $navModel->updateUploadFile($fic, $uid, $description, $fichier, $chemin);
			}
			else
			{
				$infoService = $navModel->uploadFile($uid, $description, $fichier, $chemin, $dossier, $service, $parent);
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
}



?>