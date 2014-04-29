<div class="page-content inset">

	<fieldset>
	
		<legend><ol class="breadcrumb">	<?php  if (isset($nomDossier)){echo $nomDossier;}
												else{echo ' <li><a href="#">Home</a></li><li><a href="#">Library</a></li><li class="active">Data</li>';}  ?> 
		</ol>
		<ul class="pagination pagination-sm">
			<?php if(isset($pagination)){ echo $pagination;}else{ echo '  <li class="disabled"><a href="#">&laquo;</a></li>
	  <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li><li><a href="#">2</a></li></li><li><a href="#">3</a></li></li><li><a href="#">4</a></li>';} ?>
		</ul>
		</legend>
	</fieldset>
	<div class="row">
		<?php if(isset($fichiers)){echo $fichiers;}else{echo '<h2>Exemples</h2>';} ?>
	<div class="col-sm-3 col-md-2">
        <div class="thumbnail">
          <img data-src="holder.js/300x200" alt="150x100" src="" style="width: 150px; height: 100px;">
          <div class="caption">
            <h4>Dossiers Emmanuel</h4>
            <p>Manu parlait de Maxime à Nordine</p>
            <p><a href="#" class="btn btn-primary" role="button">Dl</a> <a href="#" class="btn btn-default" role="button">Upload</a></p>
          </div>
        </div>
      </div>
	  
	  <div class="col-sm-3 col-md-2">
        <div class="thumbnail">
          <img data-src="holder.js/300x200" alt="150x100" src="" style="width: 150px; height: 100px;">
          <div class="caption">
            <h4>Quake</h4>
            <p>Quand j'ai gagné</p>
            <p><a href="#" class="btn btn-primary" role="button">Dl</a> <a href="#" class="btn btn-default" role="button">Upload</a></p>
          </div>
        </div>
      </div>
	  
	  <div class="col-sm-3 col-md-2">
        <div class="thumbnail">
          <img data-src="holder.js/300x200" alt="150x100" src="" style="width: 150px; height: 100px;">
          <div class="caption">
            <h4>Dossiers Nordine</h4>
            <p>Nordine parle de Manu à Maxime</p>
            <p><a href="#" class="btn btn-primary" role="button">Dl</a> <a href="#" class="btn btn-default" role="button">Upload</a></p>
          </div>
        </div>
      </div>
	  
	  <div class="col-sm-3 col-md-2">
        <div class="thumbnail">
          <img data-src="holder.js/300x200" alt="150x100" src="" style="width: 150px; height: 100px;">
          <div class="caption">
            <h4>LE TUNNEL</h4>
            <p>... ... ... ...</p>
            <p><a href="#" class="btn btn-primary" role="button">???</a> <a href="#" class="btn btn-default" role="button">?!?!?!</a></p>
          </div>
        </div>
      </div>
	  
	  <div class="col-sm-3 col-md-2">
        <div class="thumbnail">
          <img data-src="holder.js/300x200" alt="150x100" src="" style="width: 150px; height: 100px;">
          <div class="caption">
            <h4>Fichiers ou Dossier</h4>
            <p>Description</p>
            <p><a href="#" class="btn btn-primary" role="button">Dl</a> <a href="#" class="btn btn-default" role="button">Upload</a></p>
          </div>
        </div>
      </div>
	
		  <div class="col-sm-3 col-md-2">
        <div class="thumbnail">
          <img data-src="holder.js/300x200" alt="150x100" src="" style="width: 150px; height: 100px;">
          <div class="caption">
            <h4>Fichiers ou Dossier</h4>
            <p>Description</p>
            <p><a href="#" class="btn btn-primary" role="button">Dl</a> <a href="#" class="btn btn-default" role="button">Upload</a></p>
          </div>
        </div>
      </div>
	  
	  	  <div class="col-sm-3 col-md-2">
        <div class="thumbnail">
          <img data-src="holder.js/300x200" alt="150x100" src="" style="width: 150px; height: 100px;">
          <div class="caption">
            <h4>Fichiers ou Dossier</h4>
            <p>Description</p>
            <p><a href="#" class="btn btn-primary" role="button">Dl</a> <a href="#" class="btn btn-default" role="button">Upload</a></p>
          </div>
        </div>
      </div>
	  
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