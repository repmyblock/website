<?php
error_reporting(E_ERROR | E_PARSE);

echo "I am in the verif admin priv: " . $URIEncryptedString["SystemUser_Priv"] . "<BR>";


### This file is the SSL Key used to encrypt the _GET variable.
if ( empty ($URIEncryptedString["SystemAdmin"])) {
	header("Location: /signoff");
	exit();
}

?>