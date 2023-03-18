<?php
### This file is the SSL Key used to encrypt the _GET variable.
if ( empty ($URIEncryptedString["SystemUser_Priv"]) || $URIEncryptedString["SystemUser_Priv"] < 4294967295) {
	header("Location: /signoff");
	exit();
}

?>