<STYLE type="text/css">


</style>

<div class="content-header">
    <h1>
        <a id="menu-toggle" href="#" class="btn btn-default"><i class="icon-reorder"></i></a>
                    <?php  if(isset($_SESSION['SERVICE'])) echo  ' Archives des demandes Service: '.$_SESSION['SERVICE']; ?>
    </h1>
</div>

<div class="page-content inset" style="padding: 10px;border: 2px solid #D79543;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px; width: 1100px; margin:50px auto;">
	<table class="table table-striped" >
				<thead>
					<tr>
						<th style="width:120px">
							<?php 
								echo '<form action="'.URL.'extensionDroit/demandeEnAttente" method="POST">';
								echo '<input type="submit" class="btn btn-info" name="enattente" value="Demande" />';
							?>
								</form>
						</th>
						<th>Id Demande</th>
						<th>Demandeur</th>
						<th>Nom du dossier</th>
						<th>Statut</th>
					</tr>
				</thead>
			<tbody>

			<?php
				if(isset($enattente)){

						foreach($demande as $infos){
						
							if($infos['statut'] == "1")
								echo '<tr class="success">';
							
							if($infos['statut'] == "2")
								echo '<tr class="danger">';
							
							echo '<td></td>';
							echo '<td>'.$infos['id_demande'].'</td>';
							echo '<td>'.$infos['demandeur'].'</td>';
							echo '<td>'.$infos['nom'].'</td>';
							
							if($infos['statut'] == "1")
								echo '<td>Validé</td>';
								
							if($infos['statut'] == "2")
								echo '<td>Refusé</td>';
							
							
							echo '</td>';
							echo '</tr>';
						}
				}
			?>
		
		</tbody>
	</table>
</div>	
