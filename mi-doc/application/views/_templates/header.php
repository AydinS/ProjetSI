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

    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
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
                <li class="sidebar-brand" <?php if(isset($_SESSION)) echo 'style="color:blue;" '; ?>><a href="#">Start E-DOC!</a>
                </li>
				<?php
					if(!isset($_SESSION['cn'])){ 
						echo '<li><a href="'.URL.'connexion/index">Connexion</a></li>';
					}
					else{
						echo '<li style="color:green;">Bienvenu '.$_SESSION['cn'].'</li>';
						echo '<li><a href="'.URL.'connexion/logout">Déconnexion</a></li>';
						echo '<li><a href="'.URL.'navigation/index">Navigation</a>';
					}
				?>
                <!--<li><a href="<?php //echo URL.'contacts/index'; ?>">Contacts</a>-->
                </li>
                </li>
                <li><a href="#">Overview</a>
                </li>
                <li><a href="#">Events</a>
                </li>
                <li><a href="#">About</a>
                </li>
                <li><a href="#">Services</a>
                </li>
                <li><a href="#">Contact</a>
                </li>
            </ul>
        </div>
