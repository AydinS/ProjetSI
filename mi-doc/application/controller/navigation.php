<?php

class Navigation extends Controller
{

	public function index(){
		
		require 'application/views/_templates/header.php';
        require 'application/views/navigation/index.php';
        require 'application/views/_templates/footer.php';
		
	}

}



?>