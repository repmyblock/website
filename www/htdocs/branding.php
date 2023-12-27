<?php 

 	/* This directory is to keep track of the branding */
 	
 	if ( empty ($_GET['brand'])) {
 		header("Location: /web/index");
 		exit();
 	} else {
 		header("Location: /" . rawurlencode($_GET['brand']) . "/index");
 		exit();
 	} 	
?>
