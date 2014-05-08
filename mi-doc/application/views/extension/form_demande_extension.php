
<div class="page-content inset">

<?php echo '<form action="'.URL.'extensionDroit/validerDemande" method="POST">'; ?>
<fieldset>


	<!-- Form Name -->
	<legend>Demande d'extension</legend>
	<div class="page-content inset" style="padding: 20px;border: 2px solid #D79543;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px; width: 500px; margin:50px auto;">

	<!-- Select Basic -->
	<div class="control-group">
	  <label class="control-label" for="service">Service</label>
	  <div class="controls">
		<select id="service" name="service" class="form-control" style="width:400px; margin-top:6px;">
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
	<br/>

	<!-- Select Basic -->
	<div class="control-group">
	  <label class="control-label" for="dossier">Dossier</label>
	  <div class="controls">
		<select multiple size="8" id="dossier" name="dossier" class="form-control" style="width:400px; margin-top:6px;">
			
		</select>
	  </div>
	</div>
	<br/>

	<div class="control-group">
	  <label class="control-label" for="dossier">Droit demandé</label>
	  <div class="radio">
			<input type="radio" id="droit" name="droit" value="1" /> Consulté <br/>
			<input type="radio" id="droit" name="droit" value="2" /> Déposé
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
	</div>

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
