<?php
    // using ldap bind
    $ldaprdn  = 'uid=admin,ou=system';     // ldap rdn or dn
    $ldappass = 'secret';  // associated password
	$ldapport = 11389;
    // connect to ldap server
    $ldapconn = ldap_connect("localhost",$ldapport)
            or die("Could not connect to LDAP server.");

    // Set some ldap options for talking to 
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

    if ($ldapconn) {

            // binding to ldap server
            $ldapbind = @ldap_bind($ldapconn, $ldaprdn, $ldappass);

            // verify binding
            if ($ldapbind) {
                echo "LDAP bind successful...\n";
            } else {
                echo "LDAP bind failed...\n";
            }
			
			$ds=ldap_connect("localhost",$ldapport);  // doit être un serveur LDAP valide !
    // Set some ldap options for talking to
    ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
echo 'Le résultat de connexion est ' . $ds . '<br />';

if ($ds) { 
    echo 'Liaison ...'; 
    $r=ldap_bind($ds, $ldaprdn, $ldappass);     // connexion anonyme, typique
                                     // pour un accès en lecture seule.
    echo 'Le résultat de connexion est ' . $r . '<br />';

    echo 'Recherchons (sn=e*) ...';
    // Recherche par nom
    $sr=ldap_search($ds,null, "sn=a*");  
    echo 'Le résultat de la recherche est ' . $sr . '<br />';

    echo 'Le nombre d\'entrées retournées est ' . ldap_count_entries($ds,$sr) 
         . '<br />';

    echo 'Lecture des entrées ...<br />';
    $info = ldap_get_entries($ds, $sr);
    echo 'Données pour ' . $info["count"] . ' entrées:<br />';

    for ($i=0; $i<$info["count"]; $i++) {
        echo 'dn est : ' . $info[$i]["dn"] . '<br />';
        echo 'premiere entree cn : ' . $info[$i]["cn"][0] . '<br />';
        echo 'premier email : ' . $info[$i]["mail"][0] . '<br />';
    }

    echo 'Fermeture de la connexion';
    ldap_close($ds);

} else {
    echo '<h4>Impossible de se connecter au serveur LDAP.</h4>';
}

    }

?>