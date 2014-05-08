<?php

class ExtensionDroit extends Controller
{

	public function demandeEnAttente(){
	
		require 'application/views/_templates/header.php';
		
		if( isset($_SESSION['RESPONSABLE']) )
		{
			//Loading du model extension droit
			$extensionModel=$this->loadModel('ExtensionDroitModel');
			$navModel = $this->loadModel('navigationmodel');
			
			//on récupère toutes les demandes associé au service
			$demande=$extensionModel->getAllDemande($_SESSION['uid'], $navModel);
			
			//On a bien récuperer des demandes
			if($demande != -1)
			{
				$i=0;
				foreach($demande as $infos){
				
					if($infos['statut']=="0")
					{
						$enattente[$i]=$infos;
					}
					$i++;
				}
			}
		}
		
		require 'application/views/extension/table_demande_enattente.php';
        require 'application/views/_templates/footer.php';
	}
	
	public function demandeArchive(){
	
		require 'application/views/_templates/header.php';
			
			if( isset($_SESSION['RESPONSABLE']) )
			{
				//Loading du model extension droit
				$extensionModel=$this->loadModel('ExtensionDroitModel');
				$navModel = $this->loadModel('navigationmodel');
				
				//on récupère toutes les demandes associé au service
				$demande=$extensionModel->getAllDemande($_SESSION['uid'], $navModel);
				
				if($demande != -1)
				{
					foreach($demande as $infos){
					
						if($infos['statut']=="1" || $infos['statut']=="2")
						{
							$enattente=$infos;
						}
					}
				}
			}
			
			require 'application/views/extension/table_demande_archive.php';
			require 'application/views/_templates/footer.php';
	}
	
	/**
	* Fonction qui charge la page du formulaire de demande d'extension
	* 
	*/
	public function demanderExtension(){
	
		require 'application/views/_templates/header.php';
		$navModel = $this->loadModel('navigationmodel');
		$selectDossier = $navModel->getAllServiceFolder();
        require 'application/views/extension/form_demande_extension.php';
        require 'application/views/_templates/footer.php';
		
	}
	
	public function validerDemande(){
	
		require 'application/views/_templates/header.php';
		$extensionModel = $this->loadModel('extensiondroitmodel');
		
		if(isset($_POST["dossier"]) && isset($_POST["droit"]))
		{
			$statut=$extensionModel->newDemande($_POST["dossier"], $_SESSION["uid"], $_POST["droit"]);
			
			if($statut)
			{
				echo '<div class="alert alert-success"><strong>Demande crée !</strong> Votre demande est maintenant soumise à validation</div>';
			}
			else
			{
				echo '<div class="alert alert-danger"><strong>Echec interne !</strong> La demande contient des paramètres invalide</div>';
			}
		}
		else
		{
			echo '<div class="alert alert-danger"><strong>Champ manquant !</strong> Veuillez renseigner tous les champs de la demande</div>';
		}
		
		require 'application/views/_templates/footer.php';
	}
	/**
	* 
	* Fonction qui affiche un balise déroulante contenant tous les dossier d'un service
	*/
	public function getDossiers(){
		
		if(isset($_POST['service'])){
			$navModel = $this->loadModel('navigationmodel');
			$dossiers = $navModel->getAllFoldersFrom((int)$_POST['service'], $idUser = null);
			$options = "";
			for($i=0;$i<count($dossiers);$i++){
				
				$options = $options.'<option value="'.$dossiers[$i]['ID_FICHIER'].'">'.$dossiers[$i]['NOM'].'</option>';
				
				$sousDossier=$navModel->getAllFoldersFrom($dossiers[$i]['ID_FICHIER'], null);

				while($sousDossier > 0)
				{
					for($j=0;$j<count($sousDossier);$j++)
					{
						$options = $options.'<option value="'.$sousDossier[$j]['ID_FICHIER'].'">-- '.$sousDossier[$j]['NOM'].'</option>';
						$sousDossier=$navModel->getAllFoldersFrom($sousDossier[$j]['ID_FICHIER'], null);
					}
				}
				
			}
			echo $options;
		}
	}
	
	
	public function action(){
	
		$extensionModel=$this->loadModel('ExtensionDroitModel');
		
		if(isset($_POST['valider']))
		{
			$extensionModel->addDroit($_POST['demandeur'],$_POST['id_fichier'],$_POST['droit']);
			$extensionModel->updateStatus($_POST['id_demande'], "1");
			header("Location:".URL."/extensionDroit/demandeEnAttente");
		}
		else if(isset($_POST['refuser']))
		{
			$extensionModel->updateStatus($_POST['id_demande'], "2");
			header("Location:".URL."/extensionDroit/demandeEnAttente");
		}
	}
}
?>