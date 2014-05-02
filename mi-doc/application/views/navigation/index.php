<div class="page-content inset">
<br/>
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
							echo '<li><a href="'.URL.'navigation/displaycontent/'.$infos['idfic'].'">'.$d.'</a></li>';
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
                <h3 class="panel-title">Fichiers</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
				
            </div>
	
	        <table class="table">
                <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="#" disabled></th>
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
					echo '<tr>';
					echo '<td>'.$i.'</td>';
					echo '<td>'.$fichiers[$i]['nom'].'</td>';
					echo '<td>'.$fichiers[$i]['desc'].'</td>';
					echo '<td>';
					//btn ouvrir si dossier  et si droit :
					
					if($fichiers[$i]['dossier'] == 1){
						echo '<form action="'.URL.'navigation/gotodirectory" method="POST">';
						echo '<button type="submit" name="gotodirectory" value="'.$fichiers[$i]['path'].'/'.$fichiers[$i]['nom'].'" class="btn btn-primary" role="button">Ouvrir</button>';
						
					}
					else{
						echo '<a href="'.$fichiers[$i]['path'].''.$fichiers[$i]['nom'].'" class="btn btn-primary" role="button" download="'.$fichiers[$i]['nom'].'">Ddl</a>';
						echo '<a href="'.$fichiers[$i]['path'].''.$fichiers[$i]['nom'].'" class="btn btn-default" role="button">Up</a>';
					}
					echo '<input type="hidden" name="idfic" value="'.$fichiers[$i]['idfic'].'" class="btn btn-primary">';
					if($fichiers[$i]['dossier'] == 1){
						echo '</form>';
					}
					echo '</td>';
					echo '</tr>';
				}
				
				//echo $fichiers;
			}
		?>
		  </tbody>
		  </table>
</div>
</div>
<script type="text/javascript" src="<?php echo URL.'public/'; ?>js/filter.js"></script>