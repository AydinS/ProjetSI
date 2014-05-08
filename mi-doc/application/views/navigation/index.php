<?php //print_r($fichiers); ?>
<div class="content-header">
    <h1>
        <a id="menu-toggle" href="#" class="btn btn-default"><i class="icon-reorder"></i></a>
                    <?php  if(isset($_SESSION['SERVICE'])) echo  'Service: '.$_SESSION['SERVICE']; ?>
    </h1>
</div>
<div class="page-content inset">
<div class="row">
 <div class="panel panel-primary filterable">
            <div class="panel-heading">
				<ol class="breadcrumb">
			<?php  
			
				if (isset($nomDossier)){
					//affiche du chemin
					$maxd = count($nomDossier)-1;
					$str = "";
					$str2 = "";
					$infos = array();
					foreach($nomDossier as $id => $d){
					
						if($maxd > 0){
							$str = $str.$d.'/';
							$infos = $navModel->getIdFicByPath(substr($str,0,strlen($str)-1));
							$droit_fic = $navModel->getDroit($_SESSION['uid'],$infos['PARENT']);//on récupère les droit du dossier
							if(($maxd != (count($nomDossier)-1)) && ($droit_fic >= LECTURE || $infos['SERVICE'] == $_SESSION['SERVICE']))//s'il a les droit
								echo '<li><a href="'.URL.'navigation/displaycontent/'.$infos['ID_FICHIER'].'">'.$d.'</a></li>';//ici le lien vers le dossier est créé en passant l'id d'un des fichier du dossier, ensuite dans la fonction displaycontent on récupèrera l'id du dossier via le parent de l'id du fichier
							else//si pas de droit
								echo '<li><a href="#">'.$d.'</a></li>';
						}
						else{
							$str = $str.'/'.$d;
							echo '<li class="active" >'.$d.'</li>';
						}
						
						$maxd-=1;
					}
				}
			?> 
				</ol>
				<?php 
					//Affichages des boutons de création et d'upload dans le dossier courant
					if((isset($_SESSION['RESPONSABLE']) and $_SESSION['RESPONSABLE'] == true and isset($_SESSION['CURR_DIR_SERVICE']) and $_SESSION['CURR_DIR_SERVICE'] == $_SESSION['SERVICE']) || (isset($droit) and $droit != BLOCK and (isset($_SESSION['CURR_DIR_ID']) and isset($droit) and $droit == MODIF) || (isset($_SESSION['SERVICE']) && isset($_SESSION['CURR_DIR_SERVICE']) and $_SESSION['SERVICE'] == $_SESSION['CURR_DIR_SERVICE']))) {echo '<a href="'.URL.'upload/uploadto/'.$_SESSION['CURR_DIR_ID'].'" class="btn btn-default" role="button"><span class="glyphicon glyphicon-cloud-upload"></span>&nbsp;Upload</a>&nbsp;&nbsp;&nbsp;';}
					if((isset($_SESSION['RESPONSABLE']) and $_SESSION['RESPONSABLE'] == true and isset($_SESSION['CURR_DIR_SERVICE']) and $_SESSION['CURR_DIR_SERVICE'] == $_SESSION['SERVICE']) || (isset($droit) and $droit != BLOCK and (isset($_SESSION['CURR_DIR_ID']) and isset($droit) and $droit == MODIF) || (isset($_SESSION['SERVICE']) && isset($_SESSION['CURR_DIR_SERVICE']) and $_SESSION['SERVICE'] == $_SESSION['CURR_DIR_SERVICE']))) {echo '<a href="'.URL.'navigation/createDir/'.$_SESSION['CURR_DIR_ID'].'" class="btn btn-success" role="button"><span class="glyphicon glyphicon-plus"></span>&nbsp;Creer dossier</a> <br/>';}
					else echo'<br/>';
				?>
                <!--<h3 class="panel-title">Fichiers</h3>-->
				
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
				
            </div>
	
	        <table class="table">
                <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="Propriétaire" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Nom" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Description" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Action" disabled></th>
                    </tr>
                </thead>
			<tbody>

		<?php 
			if(isset($fichiers)){

				$maxf = count($fichiers);
				$str = "";
				for($i = 0;$i<$maxf;$i++){
					if(trim($fichiers[$i]['NOM']) != ""){
						//Affichage des informations sur le ième fichier
						echo '<tr>';
						echo '<td>'.$fichiers[$i]['ID_USER'].'</td>';
						echo '<td>'.$fichiers[$i]['NOM'].'</td>';
						echo '<td>'.$fichiers[$i]['DESC'].'</td>';
						echo '<td>';
						
						//Affichage du bouton ouvrir pour un dossier
						if($fichiers[$i]['DOSSIER'] == 1 and ((isset($_SESSION['RESPONSABLE']) and $_SESSION['RESPONSABLE'] == true  and isset($_SESSION['CURR_DIR_SERVICE']) and $_SESSION['CURR_DIR_SERVICE'] == $_SESSION['SERVICE']) || ($fichiers[$i]['DROIT'] > BLOCK || $fichiers[$i]['ID_USER'] == $_SESSION['uid']))){//Si c'est un dossier un formulaire se chargera du bouton pour consulter le dossier
							echo '<form action="'.URL.'navigation/gotodirectory" method="POST">';
							//On devrait bloquer ce bouton si l'utilisateur n'a pas les droits, on récupère le droit via la variable $fichiers[$i]['DROIT']
							echo '<button type="submit" name="gotodirectory" value="'.$fichiers[$i]['PATH'].'/'.$fichiers[$i]['NOM'].'" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-folder-open"></span>&nbsp; Ouvrir</button>';
							
						}
						else{//Affichage des boutons de download et d'upload :
							if((isset($_SESSION['RESPONSABLE']) and $_SESSION['RESPONSABLE'] == true and isset($_SESSION['CURR_DIR_SERVICE']) and $_SESSION['CURR_DIR_SERVICE'] == $_SESSION['SERVICE']) || ($fichiers[$i]['DROIT'] >= LECTURE || (isset($_SESSION['SERVICE']) && isset($_SESSION['CURR_DIR_SERVICE']) and $_SESSION['SERVICE'] == $_SESSION['CURR_DIR_SERVICE'])))		
								echo '<a href="'.URL.'application/'.$fichiers[$i]['PATH'].'/'.$fichiers[$i]['NOM'].'" class="btn btn-primary" role="button"  download="'.$fichiers[$i]['NOM'].'"><span class="glyphicon glyphicon-cloud-download"></span>&nbsp;Download</a>&nbsp;&nbsp;&nbsp;';
							if((isset($_SESSION['RESPONSABLE']) and $_SESSION['RESPONSABLE'] == true and isset($_SESSION['CURR_DIR_SERVICE']) and $_SESSION['CURR_DIR_SERVICE'] == $_SESSION['SERVICE']) || ($fichiers[$i]['DROIT'] == MODIF || $fichiers[$i]['ID_USER'] == $_SESSION['uid']))	
								echo '<a href="'.$fichiers[$i]['PATH'].''.$fichiers[$i]['NOM'].'" class="btn btn-default" role="button"><span class="glyphicon glyphicon-cloud-upload"></span>&nbsp;Upload</a>';
						}
						echo '<input type="hidden" name="idfic" value="'.$fichiers[$i]['ID_FICHIER'].'" class="btn btn-primary">';
						if($fichiers[$i]['DOSSIER'] == 1){//On ferme le formulaire
							echo '</form>';
						}
						
						echo '</td>';
						echo '<td>';
						//Boutons de suppression :
						if(isset($_SESSION['RESPONSABLE']) || ($fichiers[$i]['ID_USER'] == $_SESSION['uid'] && $_SESSION['RESPONSABLE'] != 1))
						{
							echo '<form action="'.URL.'navigation/DeleteFileNavigation" method="POST">';
							echo '<input type="hidden" name="idfic" value="'.$fichiers[$i]['ID_FICHIER'].'">';
							echo '<button type="submit" name="gotodirectory" value="'.$fichiers[$i]['ID_FICHIER'].'" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-remove"></span>&nbsp; Supprimer</button>';
							echo '</form>';
						}
						echo '</td>';
						echo '</tr>';
					}
				}
				
				//echo $fichiers;
			}
		?>
		  </tbody>
		  </table>
</div>
</div>
<script type="text/javascript" src="<?php echo URL.'public/'; ?>js/filter.js"></script>