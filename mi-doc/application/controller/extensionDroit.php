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
				foreach($demande as $infos){
				
					if($infos['statut']=="0")
					{
						$enattente=$infos;
					}
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
					
						if($infos['statut']=="1")
						{
							$enattente=$infos;
						}
					}
				}
			}
			
			require 'application/views/extension/table_demande_archive.php';
			require 'application/views/_templates/footer.php';
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