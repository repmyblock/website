<?php
### This file is the SSL Key used to encrypt the _GET variable.
if ( empty ($URIEncryptedString["SystemAdmin"])) {
	header("Location: /signoff");
	exit();
}
?>