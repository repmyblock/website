<?php 

 	/* This directory is to keep track of the branding */ 	
 	if ( empty ($_GET['brand'])) {
 		header("Location: /");
 		exit();
 	} else {
 	
	 	switch($_GET['brand']) {
		case 'howto':
			header("Location: /" . rawurlencode($_GET['brand']) . "/training/steps/torun");
			exit();
		
		case 'about':
			header("Location: /" . rawurlencode($_GET['brand']) . "/howto/toplinks/about");
			exit();
				
	 	default:
	 		header("Location: /" . rawurlencode($_GET['brand']) . "/brand/" . rawurlencode($_GET['brand']) . "/index");
	 		exit();
	 	}
	 	
	}
?>