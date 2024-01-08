<?php 

 	/* This directory is to keep track of the branding */ 	
 	if ( empty ($_GET['brand'])) {
 		header("Location: /");
 		exit();
 	} else {
 	
	 	switch($_GET['brand']) {
		case 'howto':
			header("Location: " . $FrontEndWebsite . "/" . rawurlencode($_GET['brand']) . "/training/steps/torun");
			exit();
		
		case 'about':
			header("Location: " . $FrontEndWebsite . "/" . rawurlencode($_GET['brand']) . "/toplinks/about");
			exit();
			
		case 'guide':
			header("Location: " . $FrontEndWebsite . "/" . rawurlencode($_GET['brand']) . "/voter/guide");
			exit();
			
		case 'voterguide':
			header("Location: " . $FrontEndWebsite . "/" . rawurlencode($_GET['brand']) . "/voter/guide");
			exit();
				
	 	default:
	 		header("Location: " . $FrontEndWebsite . "/" . rawurlencode($_GET['brand']) . "/brand/" . rawurlencode($_GET['brand']) . "/index");
	 		exit();
	 	}
	 	
	}
?>