<?php

/**
 * Configuration
 *
 * For more info about constants please @see http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 */

/**
 * Configuration for: Error reporting
 * Useful to show every little problem during development, but only show hard errors in production
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Configuration for: Project URL
 * Put your URL here, for local development "127.0.0.1" or "localhost" (plus sub-folder) is fine
 */
define('URL', 'http://127.0.0.1/mi-doc/');

/**
 * Configuration for: Database
 * This is the place where you define your database credentials, database type etc.
 * Pour une base Oracle on remplis les champs comme suit:
 */

/*define('DB_TYPE', 'oci');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'miage03/miage');
define('DB_USER', 'madelcaf');
define('DB_PASS', 'I6fjwtmw');*/
 
define('DB_TYPE', 'oci');
define('DB_HOST', '127.0.0.1:8080/xe');
define('DB_NAME', '127.0.0.1');
define('DB_USER', 'ProjetSI');
define('DB_PASS', 'ProjetSI');

/**
 * Configuration pour la connexion Ldap a ApacheDS
 * 
 */
define('LDAP_HOST', '127.0.0.1');
define('LDAP_PORT', '11389');
define('LDAP_RDN', 'uid=admin,ou=system');
define('LDAP_PASS', 'secret');

/**
 *
 * Dossier où serons créés les dossier racines des services
 */
define('RACINE','services/');

/**
 *
 * Constantes qui définissent les différents droits possibles sur les fichiers
 */
 
define('LECTURE','1');
define('MODIF','2');
define('BLOCK','-2');//Bloque un dossier à un utilisateur de son service
define('RW_NAV','-1');//constante pour les tests