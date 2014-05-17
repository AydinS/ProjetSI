<script language="JavaScript">
var cpt = 0;
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

function VisibleButton()
{
	var Vide = true;
	if(document.formUpload.description.value  == '') 
	{
		Vide = false;
	}
	if(document.formUpload.uploadfile.value  == 0 || document.formUpload.uploadfile.value  == '') 
	{
		Vide = false;
	}
	
	if(Vide == false)
	{
		document.formUpload.singlebutton1.style.visibility="hidden";
	}
	else
	{
		document.formUpload.singlebutton1.style.visibility="visible";
	}
}

function VisibleButtonVal()
{
		if(cpt%2 == 0) document.getElementById("validation").style.visibility="hidden";
		else document.getElementById("validation").style.visibility="visible";
		cpt = cpt+1;
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
			<input type="text" id="description" name="description" value="<?php if(isset($infoFile['DESCRIPTION'])) echo $infoFile['DESCRIPTION']; ?>" size="40" onChange="javascript:VisibleButton();">				
	  </div>
	</div>
	
	
	<div class="control-group">
	  <label class="control-label" for="dossier">Fichier à uploader</label>
	  <div class="controls">
			<input type="file" name="uploadfile" onChange="javascript:VisibleButton();">				
	  </div>
	</div>
	
	<!-- Button -->
	<div class="control-group">
	  <label class="control-label" for="singlebutton"></label>
	  <div class="controls">
		<button id="singlebutton" name="singlebutton" class="btn btn-primary" type="submit">Valider</button>
		<button id="singlebutton1" name="singlebutton1" class="btn btn-success" type="button" onClick="javascript:VisibleButtonVal();">Demande de validation</button>
	  </div>
	</div>
	
	</fieldset>
	
	<div class="page-content inset" id="validation">
		<div class="controls" style="padding: 20px;border: 2px solid #D79543;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px; width: 300px; margin:50px auto;">
		
		  <div class="controls">
				<?php
					for($i = 0; $i<$allUser[0]['uniquemember']['count']; $i++)
					{
						$user = $allUser[0]['uniquemember'][$i];
						$user = str_replace("uid=", "", $user);
						
						if($user != $_SESSION['uid'])
						{
							echo "$user &nbsp;";
							echo '<input type="checkbox" name="list_checked[]" value="'.$user.'">';
							if($i%2 == 0) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							else echo "<br>";
						}
					}
				?>
		  </div>
		  <br>
		  <div class="controls" align="center">
			<button id="singlebutton2" name="singlebutton2" class="btn btn-success" type="submit">Soummettre à validation</button>
		  </div>
		</div>
	</div>
	</form>
	<script language="JavaScript">
		VisibleButton();
		VisibleButtonVal();
	</script>

</div>