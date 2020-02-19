<?php
	error_reporting(E_ERROR | E_PARSE);
	// echo "<B>Decrypted Line:</B> " .  $_SERVER['DOCUMENT_URI'] .  "<UL>$Decrypted_k</UL>";
	if ( preg_match('/Mobile/', $_SERVER['HTTP_USER_AGENT'])) { $MobileDisplay = true; }
	//$MobileDisplay = true; 
	if ( ! empty ($k) && $SystemUser_ID > 0 ) { $MenuLogin = "logged"; }
	
	if ( empty ($imgtoshow )) {	$imgtoshow = "/pics/RepMyBlock.png";	}
	
?><!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js">
	<HEAD>
		<META charset="UTF-8">
		<meta name="twitter:card" content="summary_large_image" />
		<meta name="twitter:description" content="Registrations for the 2020 county committee cycle in the Bronx, Queens and Brooklyn have started. Registration for the 2021 county committee cycle in Manhattan and Staten Island have started. Get your nominating petition kit here! HOW DOES IT WORKS The County Committee is the most basic committee of the Democratic Party; its its backbone. The &hellip; Continue reading Rep My Block &rarr;" />
		<meta name="twitter:title" content="Rep My Block - Rep My Block" />
		<meta name="twitter:site" content="@RepMyBlock" />
		<meta name="twitter:image" content="https://static.repmyblock.nyc/pics/paste/PoliticalMachineKeepEngagementLow.jpg" />
		<meta name="twitter:creator" content="@RepMyBlock" />
		<TITLE>Rep My Block - Represent My Block - Nominate A Candidate</TITLE>
		<link rel="icon" href="/pics/favicon/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="/pics/favicon/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" type="text/css" href="/pics/icons/css/all.min.css" >		
		<link rel="stylesheet" type="text/css" href="/font/montserrat.css">
		<link rel="stylesheet" type="text/css" href="/css/Primer.css">		
	  <link rel="dns-prefetch" href="https://www.repmyblock.nyc">

<?php	if ($MobileDisplay == true) { ?>
		<!--- Mobile Check --->
		<link rel="stylesheet" type="text/css" href="/css/Mobile-RepMyBlock.css" />		
<?php 	} else { ?>
		<!--- Not Mobile Check --->
		<link rel="stylesheet" type="text/css" href="/css/RepMyBlock.css" />		
<?php } ?>		<link rel="stylesheet" type="text/css" href="/css/FrameWorks.css">		
	</HEAD>
	
  <body class="logged-in env-production emoji-size-boost min-width-lg page-account">
		<DIV class="header">
			<div class="header-left">
			  <a href="/" class="logo"><IMG SRC="<?= $imgtoshow ?>" class="header-logo"></a>
			</DIV>
		  <div class="header-right">
  	  	<a class="login" href="/contact/">CONTACT</a>
		  	<?php if ( $MenuLogin == "logged") { ?>
					 <a href="/signoff/?k=<?= $k ?>" class="login right<?php if ($BigMenu == "profile") { echo " active"; } ?>">LOGOUT</a>
				<?php } else { ?>
		    	<a href="/login/" class="login">LOGIN</a>
		    <?php } ?>
		  </DIV>
		</DIV> 
		
<?php 
	if ( ! empty($SystemUser_ID)) {
		$NewKToEncrypt = EncryptURL("SystemUser_ID=" . $SystemUser_ID); 
	}
?>

<?php /*
<nav class="d-flex" aria-label="Global">
  <a class="js-selected-navigation-item Header-link  mr-3" data-hotkey="g p" data-ga-click="Header, click, Nav menu - item:pulls context:user" aria-label="Pull requests you created" data-selected-links="/pulls /pulls/assigned /pulls/mentioned /pulls" href="/pulls">Pull requests</a>
  <a class="js-selected-navigation-item Header-link  mr-3" data-hotkey="g i" data-ga-click="Header, click, Nav menu - item:issues context:user" aria-label="Issues you created" data-selected-links="/issues /issues/assigned /issues/mentioned /issues" href="/issues">Issues</a>
  <div class="mr-3">
  	<a class="js-selected-navigation-item Header-link" data-ga-click="Header, click, Nav menu - item:marketplace context:user" data-octo-click="marketplace_click" data-octo-dimensions="location:nav_bar" data-selected-links=" /marketplace" href="/marketplace">Marketplace</a>      
	</div>
  <a class="js-selected-navigation-item Header-link  mr-3" data-ga-click="Header, click, Nav menu - item:explore" data-selected-links="/explore /trending /trending/developers /integrations /integrations/feature/code /integrations/feature/collaborate /integrations/feature/ship showcases showcases_search showcases_landing /explore" href="/explore">Explore</a>
</nav>
*/ ?>

<div class="navbar">
<?php if ( $MenuLogin == "logged") { ?>
  <a href="/lgd/profile/?k=<?= $NewKToEncrypt ?>" class="right<?php if ($BigMenu == "profile") { echo " active"; } ?>">PROFILE</a>
<?php /*  <a href="/get-involved/nominate/?k=<?= $NewKToEncrypt ?>"<?php if ($BigMenu == "nominate") { echo " class=\"active\""; } ?>>NOMINATE</a> */ ?>
  <a href="/lgd/voters/?k=<?= $NewKToEncrypt ?>"<?php if ($BigMenu == "represent") { echo " class=\"active\""; } ?>>REPRESENT</a>
  <a href="/about/?k=<?= $NewKToEncrypt ?>"<?php if ($BigMenu == "home") { echo " class=\"active\""; } ?>>ABOUT</a>
<?php } else { ?>
  <a href="/howto/" class="right<?php if ($BigMenu == "howto") { echo " active"; } ?>">HOW TO</a>
<?php /*    <a href="/get-involved/propose"<?php if ($BigMenu == "nominate") { echo " class=\"active\""; } ?>>NOMINATE</a> */ ?>
  <a href="/get-involved/interested/"<?php if ($BigMenu == "represent") { echo " class=\"active\""; } ?>>REPRESENT</a>
  <a href="/about/"<?php if ($BigMenu == "home") { echo " class=\"active\""; } ?>>ABOUT</a>
<?php } ?> 
</div>
