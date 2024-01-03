<?php
	if ( preg_match('/Mobile/', $_SERVER['HTTP_USER_AGENT'])) { $MobileDisplay = true; }
	//$MobileDisplay = true; 

	WriteStderr($k,"Header K");
	WriteStderr(isset($URIEncryptedString["SystemUser_ID"]) ? $URIEncryptedString["SystemUser_ID"] : NULL, "Header SystemID");
	$MenuLogin = isset($MenuLogin) ? $MenuLogin : NULL;
	$BigMenu = isset($BigMenu) ? $BigMenu : NULL;

	if ( ! empty ($k) && ($URIEncryptedString["SystemUser_ID"] > 0 ||
												$URIEncryptedString["SystemUser_ID"] == "TMP")) { 
		$MenuLogin = "logged"; 
		$logourl = "/" . $k . "/lgd/summary/summary";
		$middleuri = $k;
				
	} else {		
		if ( empty ($URIEncryptedString) && empty ($middleuri) && ! empty ($k)) {
			$middleuri = $k;
		}
		if (empty ($middleuri)) { $middleuri = "web"; };
		$logourl = "/" . $middleuri . "/main/page";
		
		if ( ! empty ($BrandLink)) {
			$logourl = $BrandLink;
		}
	}	
	
	// This is the image
	if ( empty ($imgtoshow )) {	$imgtoshow = "/images/RepMyBlock.png"; }	

	if (empty ($HeaderTwitterSite)) {	$HeaderTwitterSite = "@RepMyBlock"; }
	if (empty ($HeaderTwitterCreator)) {	$HeaderTwitterCreator = "@RepMyBlock"; }
		
	if ( empty ($HeaderTwitter)) {
		$HeaderTwitterTitle = "Rep My Block - Rep My Block";
		$HeaderTwitterPicLink = $FrontEndStatic . "/pics/paste/PoliticalMachineKeepEngagementLow.jpg";
		$HeaderTwitterDesc = "Registrations for the 2024 Queens, Brooklyn and Bronx Democratic and 2025 Citywide Republican county committee. Get your nominating petition kit here! The County Committee is the most basic committee of the Democratic and Republican Parties; it's their backbone. The &hellip; Continue reading Rep My Block &rarr;";
	}

	if (empty ($HeaderOGTitle)) {	$HeaderOGTitle = "County Committee"; }
	if (empty ($HeaderOGDescription)) {	$HeaderOGDescription = "Represent My Block at the County Committee"; }
	if (empty ($HeaderOGImage)) { 
		$HeaderOGImage = $FrontEndWebsite . "/images/RepMyBlock.png"; 
		$HeaderOGImageWidth = "99";
		$HeaderOGImageHeight = "71";
	}
	
?><!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js">
	<HEAD>
		
		<META charset="UTF-8">
<?php if ("https://" . $_SERVER['HTTP_HOST'] != $FrontEndWebsite) { ?>
		<meta name="robots" content="noindex"><?php } ?>
		<meta name="twitter:card" content="summary_large_image" />
		<meta name="twitter:description" content="<?= $HeaderTwitterDesc ?>" />
		<meta name="twitter:title" content="<?= $HeaderTwitterTitle ?>" />
		<meta name="twitter:site" content="<?= $HeaderTwitterSite ?>" />
		<meta name="twitter:image" content="<?= $HeaderTwitterPicLink ?>" />
		<meta name="twitter:creator" content="<?= $HeaderTwitterCreator ?>" />
		<meta name="Description" CONTENT="Rep My Block is your starting point to run The starting point on how to run for office with no money by running for District Leader, County Committee and Precinct Officer.">
		<TITLE>Rep My Block - The starting point on how to run for office with no money by running for District Leader, County Committee and Precinct Officer.</TITLE>

		<meta name="Title" content="Run for office with no money">
		<meta property="og:title" content="<?= $HeaderOGTitle ?>"/>
		<meta property="og:url" content="https://<?= $_SERVER['HTTP_HOST'] ?><?= $_SERVER['REQUEST_URI'] ?>">
		<meta property="og:description" content="<?= $HeaderOGDescription ?>">
		<meta property="og:type" content="article">
		<meta property="og:image" content="<?= $HeaderOGImage ?>" />		
		<meta property="og:image:width" content="<?= $HeaderOGImageWidth ?>" />		
		<meta property="og:image:height" content="<?= $HeaderOGImageHeight ?>" />		

		<meta property="og:site_name" content="Rep My Block"/>
		
		<link rel="image_src" href="<?= $FrontEndWebsite ?>/images/RepMyBlock.png" />
  
		<link rel="icon" href="/images/favicon/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="/images/favicon/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" type="text/css" href="/images/icons/css/all.min.css" >		
		<link rel="stylesheet" type="text/css" href="/css/font_montserrat.css">
		<link rel="stylesheet" type="text/css" href="/css/Primer.css">		
<?php if ($MapShow == true) { ?>
		<link rel="stylesheet" href="/javascript/ol/openlayer/ol.css" type="text/css">
<?php } ?>
	  <link rel="dns-prefetch" href="<?= $FrontEndWebsite ?>">

<?php	if ($MobileDisplay == true) { ?>
		<!--- Mobile Check --->
		<link rel="stylesheet" type="text/css" href="/css/Mobile-RepMyBlock.css" />		
		<link rel="stylesheet" type="text/css" href="/css/Mobile-Headers.css">	
<?php 	} else { ?>
		<!--- Not Mobile Check --->
		<link rel="stylesheet" type="text/css" href="/css/RepMyBlock.css" />		
		<link rel="stylesheet" type="text/css" href="/css/Headers.css">	
<?php } ?>		
		<link rel="stylesheet" type="text/css" href="/css/FrameWorks.css">		


<?php if ($MapShow == true) { ?>
<style>
  .map {
    height: 400px;
    width: 100%;
  }
</style>
<script LANGUAGE="javascript" src="/javascript/ol/openlayer/ol.js"></script>
<?php } ?>
	</HEAD>
	
	
  <BODY class="logged-in env-production emoji-size-boost min-width-lg page-account">
	
	<?php /*
	
		<DIV class="header navbar">
			<div class="header-left">
			  <a href="<?= $logourl ?>" class="logo"<?php 
			  	if ( ! empty ($BrandTargetName)) { ?> TARGET="<?= $BrandTargetName ?>"<?php } 
			  ?>><IMG SRC="<?= $imgtoshow ?>" class="header-logo"></a>
			</DIV>
		  <div class="header-right">
		  	<?php if ( $MenuLogin == "logged") { ?>
			  	<a class="login" href="/<?= $k ?>/user/contact">CONTACT</a>
					<a href="/<?= $k ?>/lgd/signoff" class="login right<?php if ($BigMenu == "profile") { echo " active"; } ?>">LOGOUT</a>
				<?php } else { ?>
			  	<a class="login" href="/<?= $middleuri ?>/register/user">REGISTER</a>
		    	<a href="/<?= $middleuri ?>/user/login" class="login">LOGIN</a>
		    <?php } ?>
		  </DIV>
		
		<DIV>
			<?php if ( $MenuLogin == "logged") { ?>
			  <a href="/<?= $k ?>/lgd/profile/user" class="right<?php if ($BigMenu == "profile") { echo " active"; } ?>">PROFILE</a>
			  <a href="/<?= $k ?>/training/steps/torun"<?php if ($BigMenu == "represent") { echo " class=\"active\""; } ?>>REPRESENT</a>
			  <a href="/<?= $k ?>/toplinks/about"<?php if ($BigMenu == "about") { echo " class=\"active\""; } ?>>ABOUT</a>
			<?php } else { ?>
			 	<a  href="/<?= $middleuri ?>/user/contact" class="right<?php if ($BigMenu == "contact") { echo " active"; } ?>">CONTACT</a>
			  <a href="/<?= $middleuri ?>/training/steps/torun" class="right<?php if ($BigMenu == "howto") { echo " active"; } ?>">HOW TO</a>
			  <a href="/<?= $middleuri ?>/toplinks/about"<?php if ($BigMenu == "about") { echo " class=\"active\""; } ?>>ABOUT</a>
			<?php } ?>
		</div><?php WriteStderr($middleuri,"Middle URI at the end of header"); ?>
	</DIV>
	*/ ?>
	
	
  <BODY>
	<DIV class="header2">
		
		<div class="header2-logo">
		   <a href="<?= $logourl ?>"<?php 
			  	if ( ! empty ($BrandTargetName)) { ?> TARGET="<?= $BrandTargetName ?>"<?php } 
			  ?>><IMG SRC="<?= $imgtoshow ?>"></a>
		</DIV>	
		
		<DIV class="header2-text">
		
			<div class="header2-top">
				<?php if ( $MenuLogin == "logged") { ?>
			  	<a class="login" href="/<?= $k ?>/user/contact">CONTACT</a>
					<a href="/<?= $k ?>/lgd/signoff" class="<?php if ($BigMenu == "profile") { echo " active"; } ?>">LOGOUT</a>
				<?php } else { ?>
			  	<a class="login" href="/<?= $middleuri ?>/register/user">REGISTER</a>
		    	<a href="/<?= $middleuri ?>/user/login" class="login">LOGIN</a>
		    <?php } ?>
		  </DIV>
	  	  
			<div class="header2-botton">
				<?php if ( $MenuLogin == "logged") { ?>  
					<a href="/<?= $k ?>/toplinks/about"<?php if ($BigMenu == "about") { echo " class=\"active\""; } ?>>ABOUT</a>
					<a href="/<?= $k ?>/training/steps/torun"<?php if ($BigMenu == "represent") { echo " class=\"active\""; } ?>>REPRESENT</a>
					<a href="/<?= $k ?>/lgd/profile/user" class="<?php if ($BigMenu == "profile") { echo " active"; } ?>">PROFILE</a>
				<?php } else { ?>
				  <a href="/<?= $middleuri ?>/toplinks/about"<?php if ($BigMenu == "about") { echo " class=\"active\""; } ?>>ABOUT</a>
				  <a href="/<?= $middleuri ?>/training/steps/torun" class="right<?php if ($BigMenu == "howto") { echo " active"; } ?>">HOW TO</a>
				 	<a href="/<?= $middleuri ?>/user/contact" class="right<?php if ($BigMenu == "contact") { echo " active"; } ?>">CONTACT</a>
				<?php } ?>
			</div>	
		
		</DIV>
	</DIV>
