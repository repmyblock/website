<?php 

 	/* This directory is to keep track of the branding */
 	
 	if ( empty ($_GET['brand'])) {
 		header("Location: /web/exp/index");
 		exit();
 	} else {
 		header("Location: /" . $_GET['brand'] . "/exp/index");
 		exit();
 	} 	
?>
