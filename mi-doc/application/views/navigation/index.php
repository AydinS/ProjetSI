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
							echo '<li><a href="'.URL.'navigation/displaycontent/'.$infos['ID_FICHIER'].'">'.$d.'</a></li>';
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
				<?php if(isset($_SESSION['CURR_DIR_ID'])) {echo '<a href="'.URL.'upload/uploadto/'.$_SESSION['CURR_DIR_ID'].'" class="btn btn-default" role="button">Upload</a> <br/>';}?>
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
						echo '<tr>';
						echo '<td>'.$fichiers[$i]['ID_USER'].'</td>';
						echo '<td>'.$fichiers[$i]['NOM'].'</td>';
						echo '<td>'.$fichiers[$i]['DESC'].'</td>';
						echo '<td>';
						//btn ouvrir si dossier  et si droit :
						
						if($fichiers[$i]['DOSSIER'] == 1){//Si c'est un dossier un formulaire se chargera du bouton pour consulter le dossier
							echo '<form action="'.URL.'navigation/gotodirectory" method="POST">';
							//On devrait bloquer ce bouton si l'utilisateur n'a pas les droits, on récupère le droit via la variable $fichiers[$i]['DROIT']
							echo '<button type="submit" name="gotodirectory" value="'.$fichiers[$i]['PATH'].'/'.$fichiers[$i]['NOM'].'" class="btn btn-primary" role="button">Ouvrir</button>';
							
						}
						else{//Ici on devrai bloquer l'acces au bouton les droits que possède l'utilisateur sur le fichier
							//on récupère le droit via la variable : $fichiers[$i]['DROIT'] 
							echo '<a href="'.$fichiers[$i]['PATH'].'/'.$fichiers[$i]['NOM'].'" class="btn btn-primary" role="button" download="'.$fichiers[$i]['NOM'].'">Download</a>&nbsp;&nbsp;&nbsp;';
							echo '<a href="'.$fichiers[$i]['PATH'].''.$fichiers[$i]['NOM'].'" class="btn btn-default" role="button">Upload</a>';
						}
						echo '<input type="hidden" name="idfic" value="'.$fichiers[$i]['ID_FICHIER'].'" class="btn btn-primary">';
						if($fichiers[$i]['DOSSIER'] == 1){//On ferme le formulaire
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