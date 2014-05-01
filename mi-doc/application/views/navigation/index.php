<div class="page-content inset">

	<fieldset>
	
		<legend><ol class="breadcrumb">	
			<?php  
			
				if (isset($nomDossier)){
					
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
		<ul class="pagination pagination-sm">
			<?php 
				if(isset($pagination))
				{ 	
				}
				else{ echo '  <li class="disabled"><a href="#">&laquo;</a></li>
					<li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li><li><a href="#">2</a></li></li><li><a href="#">3</a></li></li><li><a href="#">4</a></li>';} ?>
		</ul>
		</legend>
	</fieldset>
	<div class="row">
		<?php 
			if(isset($fichiers)){

				$maxf = count($fichiers);
				$str = "";
				for($i = 0;$i<$maxf;$i++){
					echo '<div class="col-sm-3 col-md-2">
						<div class="thumbnail">
						  <img data-src="holder.js/300x200" alt="150x100" src="" style="width: 150px; height: 100px;">
						  <div class="caption">';
					echo '<p>'.$fichiers[$i]['nom'].'</p>';
					echo '<p>'.$fichiers[$i]['desc'].'</p>';
					echo '<p>';
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
					echo '</p> </div></div></div>';
				}
				
				//echo $fichiers;
			}else{
				echo '<h2>Exemples</h2>';
			} 
		?>
	</div>
		<fieldset>
		<legend>
		<ul class="pagination pagination-sm">
			<?php if(isset($pagination)){ echo $pagination;}else{ echo '  <li class="disabled"><a href="#">&laquo;</a></li>
	  <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li><li><a href="#">2</a></li></li><li><a href="#">3</a></li></li><li><a href="#">4</a></li>';} ?>
		</ul>
		</legend>
	</fieldset>
</div>