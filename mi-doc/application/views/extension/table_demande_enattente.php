<STYLE type="text/css">


</style>

<div class="content-header">
    <h1>
        <a id="menu-toggle" href="#" class="btn btn-default"><i class="icon-reorder"></i></a>
                    <?php  if(isset($_SESSION['SERVICE'])) echo  ' Demandes de droits Service: '.$_SESSION['SERVICE']; ?>
    </h1>
</div>

<div class="page-content inset" style="padding: 10px;border: 2px solid #3689E2;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px; width: 1100px; margin:50px auto;">
	<table class="table table-striped" >
				<thead>
					<tr>
						<th style="width:100px">
							<?php 
								echo '<form action="'.URL.'extensionDroit/demandeArchive" method="POST">';
								echo '<input type="submit" class="btn btn-info" name="archive" value="Archive" />';
							?>
								</form>
						</th>
						<th>Id Demande</th>
						<th>Demandeur</th>
						<th>Nom du dossier</th>
						<th>Droit</th>
						<th>Action</th>
					</tr>
				</thead>
			<tbody>

			<?php
				if(isset($enattente)){

						foreach($demande as $infos){
							echo '<tr>';
							echo '<td></td>';
							echo '<td>'.$infos['id_demande'].'</td>';
							echo '<td>'.$infos['demandeur'].'</td>';
							echo '<td>'.$infos['nom'].'</td>';
							
							if($infos['droit']=="1")
								echo '<td>Consultation</td>';
							else
								echo '<td>Dépôt</td>';
							echo '<td>';
							
							echo '<form action="'.URL.'extensionDroit/action" method="POST">';
								echo '<input type="hidden" name="demandeur" value="'.$infos['demandeur'].'" />';
								echo '<input type="hidden" name="id_fichier" value="'.$infos['id_fichier'].'" />';
								echo '<input type="hidden" name="droit" value="'.$infos['droit'].'" />';
								echo '<input type="hidden" name="id_demande" value="'.$infos['id_demande'].'" />';
								
								echo '<input type="submit" class="btn btn-success" name="valider" value="Valider" />&nbsp;&nbsp;&nbsp;';
								echo '<input type="submit" class="btn btn-danger" name="refuser" value="Refuser" />';
							echo '</form>';
							
							
							echo '</td>';
							echo '</tr>';
						}
				}
			?>
		
		</tbody>
	</table>
</div>	
