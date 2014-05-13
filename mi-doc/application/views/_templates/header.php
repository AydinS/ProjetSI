<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo URL.'public/'; ?>css/bootstrap.css" rel="stylesheet">

    <script src="<?php echo URL.'public/'; ?>js/jquery-1.10.2.js"></script>
    <script src="<?php echo URL.'public/'; ?>js/bootstrap.js"></script>
    <!-- Add custom CSS here -->
    <link href="<?php echo URL.'public/'; ?>css/simple-sidebar.css" rel="stylesheet">
	<link href="<?php echo URL.'public/'; ?>css/filter.css" rel="stylesheet">
    <link href="<?php echo URL.'public/fonts/'; ?>font-awesome.min.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand"><a href="#" <?php if(isset($_SESSION['uid'])) echo 'style="color:#0099FF;" '; ?> >Start E-DOC!</a>
                </li>
				<?php
					if(!isset($_SESSION['cn'])){ 
						echo '<li><a href="'.URL.'connexion/index">Connexion</a></li>';
					}
					else{
						echo '<li style="color:#33D633;">'.$_SESSION['cn'].'</li>';
						echo '<li><a href="'.URL.'navigation/index">Navigation</a></li>';
						echo '<li><a href="'.URL.'navigation/displaySharedFiles">Dossiers partages</a></li>';
						echo '<li><a href="'.URL.'extensionDroit/demanderExtension">Demander une extension</a></li>';
                        echo '<li><a href="'.URL.'rechercher/formRechercher">Rechercher un fichier</a></li>';
						if($_SESSION['RESPONSABLE']) echo '<li><a href="'.URL.'extensionDroit/demandeEnAttente">Demande d\'extension de droit</a></li>';
						echo '<li><a style="color:#FF5C33;" href="'.URL.'connexion/logout">Déconnexion</a></li>';
					}
				?>
                <!--<li><a href="<?php //echo URL.'contacts/index'; ?>">Contacts</a>-->
            </ul>
        </div>
