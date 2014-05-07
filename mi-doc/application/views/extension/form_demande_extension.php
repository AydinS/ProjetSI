
<div class="page-content inset">

<form class="form-horizontal" id="formDemande">
<fieldset>

<!-- Form Name -->
<legend>Demande d'extension</legend>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="service">Service</label>
  <div class="controls">
    <select id="service" name="service" class="input-xlarge">
     <?php 
		if(isset($selectDossier)){
			
			for($i = 0;$i<count($selectDossier);$i++){
				if(trim($selectDossier[$i]['NOM']) != "")
					echo '<option value="'.$selectDossier[$i]['ID_FICHIER'].'">'.$selectDossier[$i]['NOM'].'</option>';
			}
			
		}
		
	 ?>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="dossier">Dossier</label>
  <div class="controls">
    <select id="dossier" name="dossier" class="input-xlarge">
		
    </select>
  </div>
</div>

<!-- Button -->
<div class="control-group">
  <label class="control-label" for="singlebutton"></label>
  <div class="controls">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Valider</button>
  </div>
</div>

</fieldset>
</form>

<script type="text/javascript">
$( "#service" )
    .change(function () {
		var dossier = $("#service").val();
		var posting = $.post( "<?php echo URL.'extensionDroit/getDossiers'; ?>",{service: dossier});
		posting.done(function( data ) {
			//alert(data);
			$("#dossier").html(data);
	});
  })
.change();
</script>
</div>
