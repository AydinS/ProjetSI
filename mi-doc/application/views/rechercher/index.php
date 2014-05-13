<?php ?>
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
		<h2>Effectuer une recherche de fichier </h2>
		<h5>(Seuls les fichiers qui vous sont autorisés seront affichés)</h5>
		<br>
		<table class="table">
	    	<tbody>	
	            <tr>
		        	<?php
		        	if(isset($resultService) || isset($resultExt)){$placeholder1=$_POST['searchMotCle'];$placeholder2=$_POST['searchAuteur'];$placeholder3=$_POST['searchExt'];}
		        	else{$placeholder1="Chercher par mots clés ex : mc1;mc2;mc3;";$placeholder2="Chercher par auteur";$placeholder3="Chercher par extension de fichier";}
		        	echo '<form name="form_recherche" action="'.URL.'rechercher/effectuerRecherche" method="POST">';
		                echo '<td><input type="text" class="form-control" placeholder="'.$placeholder1.'" name = "searchMotCle" ></td>';
		                echo '<td><input type="text" class="form-control" placeholder="'.$placeholder2.'" name = "searchAuteur"></td>';
		                echo '<td><input type="text" class="form-control" placeholder="'.$placeholder3.'" name = "searchExt" ></td>';
		                echo '<td><button type="submit" name="creatfolder" class="btn btn-success" role="button">&nbsp;Valider&nbsp;</button></td>';
		        	echo '</form>';
		        	?>
	            </tr>
	    	</tbody>
		</table>
		<div class="pull-right">
            <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
        </div>
	</div>

<?php
if(isset($resultExt))
{
?>
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
			if(isset($resultService)){

				$maxf = count($resultService);
				$str = "";
				for($i = 0;$i<$maxf;$i++){
					if(trim($resultService[$i]['NOM']) != ""){	
						//Affichage des informations sur le ième resultService
						echo '<tr>';
						echo '<td>'.$resultService[$i]['ID_USER'].'</td>';
						echo '<td>'.$resultService[$i]['NOM'].'</td>';
						echo '<td>'.$resultService[$i]['DESCRIPTION'].'</td>';
						echo '<td>';
						
						//Affichage des boutons de download :
						if((isset($_SESSION['RESPONSABLE']) and $_SESSION['RESPONSABLE'] == true and isset($_SESSION['CURR_DIR_SERVICE']) and $_SESSION['CURR_DIR_SERVICE'] == $_SESSION['SERVICE']) || ($resultService[$i]['DROIT'] >= LECTURE || (isset($_SESSION['SERVICE']) && isset($_SESSION['CURR_DIR_SERVICE']) and $_SESSION['SERVICE'] == $_SESSION['CURR_DIR_SERVICE'])))		
							echo '<a href="'.URL.'application/'.$resultService[$i]['PATHS'].'/'.$resultService[$i]['NOM'].'" class="btn btn-primary" role="button"  download="'.$resultService[$i]['NOM'].'"><span class="glyphicon glyphicon-cloud-download"></span>&nbsp;Download</a>&nbsp;&nbsp;&nbsp;';
						echo '<input type="hidden" name="idfic" value="'.$resultService[$i]['ID_FICHIER'].'" class="btn btn-primary">';
						if($resultService[$i]['DOSSIER'] == 1){//On ferme le formulaire
							echo '</form>';
						}
						
						echo '</td>';
						echo '<td>';
						//Boutons de suppression :
						if(isset($_SESSION['RESPONSABLE']) || ($resultService[$i]['ID_USER'] == $_SESSION['uid'] && $_SESSION['RESPONSABLE'] != 1))
						{
							echo '<form action="'.URL.'navigation/DeleteFileNavigation" method="POST">';
							echo '<input type="hidden" name="idfic" value="'.$resultService[$i]['ID_FICHIER'].'">';
							echo '<button type="submit" name="gotodirectory" value="'.$resultService[$i]['ID_FICHIER'].'" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-remove"></span>&nbsp; Supprimer</button>';
							echo '</form>';
						}
						echo '</td>';
						echo '</tr>';
					}
				}

				$maxf = count($resultExt);
				$str = "";
				for($i = 0;$i<$maxf;$i++){
					if(trim($resultExt[$i]['NOM']) != ""){	
						//Affichage des informations sur le ième resultExt
						echo '<tr>';
						echo '<td>'.$resultExt[$i]['ID_USER'].'</td>';
						echo '<td>'.$resultExt[$i]['NOM'].'</td>';
						echo '<td>'.$resultExt[$i]['DESCRIPTION'].'</td>';
						echo '<td>';
						
						//Affichage des boutons de download :
						if((isset($_SESSION['RESPONSABLE']) and $_SESSION['RESPONSABLE'] == true and isset($_SESSION['CURR_DIR_SERVICE']) and $_SESSION['CURR_DIR_SERVICE'] == $_SESSION['SERVICE']) || ($resultExt[$i]['DROIT'] >= LECTURE || (isset($_SESSION['SERVICE']) && isset($_SESSION['CURR_DIR_SERVICE']) and $_SESSION['SERVICE'] == $_SESSION['CURR_DIR_SERVICE'])))		
							echo '<a href="'.URL.'application/'.$resultExt[$i]['PATHS'].'/'.$resultExt[$i]['NOM'].'" class="btn btn-primary" role="button"  download="'.$resultExt[$i]['NOM'].'"><span class="glyphicon glyphicon-cloud-download"></span>&nbsp;Download</a>&nbsp;&nbsp;&nbsp;';
						echo '<input type="hidden" name="idfic" value="'.$resultExt[$i]['ID_FICHIER'].'" class="btn btn-primary">';
						if($resultExt[$i]['DOSSIER'] == 1){//On ferme le formulaire
							echo '</form>';
						}
						
						echo '</td>';
						echo '<td>';
						//Boutons de suppression :
						if(isset($_SESSION['RESPONSABLE']) || ($resultExt[$i]['ID_USER'] == $_SESSION['uid'] && $_SESSION['RESPONSABLE'] != 1))
						{
							echo '<form action="'.URL.'navigation/DeleteFileNavigation" method="POST">';
							echo '<input type="hidden" name="idfic" value="'.$resultExt[$i]['ID_FICHIER'].'">';
							echo '<button type="submit" name="gotodirectory" value="'.$resultExt[$i]['ID_FICHIER'].'" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-remove"></span>&nbsp; Supprimer</button>';
							echo '</form>';
						}
						echo '</td>';
						echo '</tr>';
					}
				}
				//echo $resultService;
			}
		?>
	</tbody>
</table>
</div>
</div>
<script type="text/javascript" src="<?php echo URL.'public/'; ?>js/filter.js"></script>
<?php
}
?>
