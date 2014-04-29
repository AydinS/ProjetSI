<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Contacts extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        // debug message to show where you are, just for the demo
        //echo 'test LDAAAP';
        // load views. within the views we can echo out $songs and $amount_of_songs easily
        require 'application/views/_templates/header.php';
        
		$contactsModel = $this->loadModel('testLdapModel');
        $contacts = $contactsModel->getPersonnes();
		
		require 'application/views/contacts/index.php';
        require 'application/views/_templates/footer.php';
    }
}
