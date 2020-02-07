<?php
error_reporting(E_ERROR | E_PARSE);

### This file is the SSL Key used to encrypt the _GET variable.
if ( empty ($SystemAdmin)) {
	header("Location: /signoff");
	exit();
}

?>