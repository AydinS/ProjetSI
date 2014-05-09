<script language="JavaScript">
//Fonction testant si la zone de saisie est vide
function TestChamp()
{
	//Declaration des variables
	var PasErreur = true;
	var chaine="Vous devez entrer :\n";
	if(document.formUpload.description.value  == '')
	{
		chaine=chaine+"- La description\n";
			PasErreur = false;
	}
	if(document.formUpload.uploadfile.value  == 0 || document.fen.uploadfile.value  == '')
	{
		chaine=chaine+"- Un fichier\n";
			PasErreur = false;
	}
	if (PasErreur == false) alert(chaine);
	return PasErreur;
}
</script>
<div class="page-content inset">

	<form class="form-horizontal" id="formUpload" name="formUpload" action="<?php echo URL; ?>navigation/uploadto" method="post" onSubmit="return TestChamp();" enctype="multipart/form-data">
	<fieldset>
	<input type="hidden" name="chemin" value="<?php echo "$chemin"; ?>">
	<input type="hidden" name="parent" value="<?php echo "$parent"; ?>">
	<input type="hidden" name="modif" value="<?php if(isset($modif)) echo "$modif"; ?>">
	<input type="hidden" name="fic" value="<?php if(isset($fic)) echo "$fic"; ?>">
	<!-- Form Name -->
	<legend>Demande d'extension</legend>
	<!-- Select Basic -->
	<div class="control-group">
	  <label class="control-label" for="service">Propriétaire</label>
	  <div class="controls">
			<?php $proprietaire = $_SESSION['uid']; ?>
			<input type="text" name="uid" value="<?php echo $proprietaire; ?>" disabled>
	  </div>
	</div>
	
	<!-- Select Basic -->
	<div class="control-group">
	  <label class="control-label" for="dossier">Description du fichier</label>
	  <div class="controls">
			<input type="text" name="description" value="<?php if(isset($infoFile['DESCRIPTION'])) echo $infoFile['DESCRIPTION']; ?>" size="40">				
	  </div>
	</div>
	
	
	<div class="control-group">
	  <label class="control-label" for="dossier">Fichier à uploader</label>
	  <div class="controls">
			<input type="file" name="uploadfile">				
	  </div>
	</div>
	
	<!-- Button -->
	<div class="control-group">
	  <label class="control-label" for="singlebutton"></label>
	  <div class="controls">
		<button id="singlebutton" name="singlebutton" class="btn btn-primary" type="submit">Valider</button>
	  </div>
	</div>
	
	</fieldset>
	</form>
</div>
