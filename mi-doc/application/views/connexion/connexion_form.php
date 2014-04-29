<div class="page-content inset">
	<form class="form-horizontal" action=<?php echo URL."connexion/login"; ?> method="POST">
	<fieldset>

	<!-- Form Name -->
	<legend>Connexion E-Doc</legend>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label"  for="login">Login</label>  
	  <div class="col-md-4">
	  <input id="login" name="login" type="text" placeholder="nom d'utilisateur" class="form-control input-md">
	  <?php if(isset($erreur) && $erreur['login'] == true) echo '<span class="help-block" style="color:red;">Erreur login</span>'; ?>
	  <!--<span class="help-block">help!!</span>-->  
	  </div>
	</div>

	<!-- Password input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="mdp">Mot de passe</label>
	  <div class="col-md-4">
		<input id="mdp" name="mdp" type="password" placeholder="mot de passe du compte utilisateur" class="form-control input-md">
		<?php if(isset($erreur) && $erreur['mdp'] == true) echo '<span class="help-block" style="color:red;">Erreur mot de passe</span>'; ?>
	  </div>
	</div>

	<!-- Button -->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="valider"></label>
	  <div class="col-md-4">
		<button id="valider" name="valider" class="btn btn-primary">Valider</button>
	  </div>
	</div>

	</fieldset>
	</form>
</div>