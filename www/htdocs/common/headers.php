<?php
	error_reporting(E_ERROR | E_PARSE);
	if ( preg_match('/Mobile/', $_SERVER['HTTP_USER_AGENT'])) { $MobileDisplay = true; }
	//$MobileDisplay = true; 
	if ( ! empty ($k) && $URIEncryptedString["SystemUser_ID"] > 0 ) { 
		$MenuLogin = "logged"; 
		$middleuri = rawurlencode($k);	
	} else {
		$middleuri = "website";
	}
	
	if ( empty ($imgtoshow )) {	$imgtoshow = "/images/RepMyBlock.png"; }		
	if ( empty ($TwitterImage)) { $TwitterImage = "https://static.repmyblock.nyc/pics/paste/PoliticalMachineKeepEngagementLow.jpg"; }
	if ( empty ($TwitterDesc)) { $TwitterDesc = "Registrations for the 2021 Citywide Republican county committee and 2021 Manhattan and Staten Island Democratic county committee have started. Get your nominating petition kit here! The County Committee is the most basic committee of the Democratic and Republican Parties; its their backbone. The &hellip; Continue reading Rep My Block &rarr;"; }
		
?><!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js">
	<HEAD>
		<META charset="UTF-8">
		<meta name="twitter:card" content="summary_large_image" />
		<meta name="twitter:description" content= "<?= $TwitterDesc ?>"/>
		<meta name="twitter:title" content="Rep My Block - Rep My Block" />
		<meta name="twitter:site" content="@RepMyBlock" />
		<meta name="twitter:image" content="<?= $TwitterImage ?>" />
		<meta name="twitter:creator" content="@RepMyBlock" />
		<TITLE>Rep My Block - Represent My Block - Nominate A Candidate</TITLE>
		<link rel="icon" href="/images/favicon/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="/images/favicon/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" type="text/css" href="/images/icons/css/all.min.css" >		
		<link rel="stylesheet" type="text/css" href="/css/font_montserrat.css">
		<link rel="stylesheet" type="text/css" href="/css/Primer.css">		
<?php if ($MapShow == true) { ?>
		<link rel="stylesheet" href="/javascript/ol/openlayer/ol.css" type="text/css">
<?php } ?>
	  <link rel="dns-prefetch" href="https://www.repmyblock.nyc">

<?php	if ($MobileDisplay == true) { ?>
		<!--- Mobile Check --->
		<link rel="stylesheet" type="text/css" href="/css/Mobile-RepMyBlock.css" />		
<?php 	} else { ?>
		<!--- Not Mobile Check --->
		<link rel="stylesheet" type="text/css" href="/css/RepMyBlock.css" />		
<?php } ?>		<link rel="stylesheet" type="text/css" href="/css/FrameWorks.css">		


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
		<DIV class="header">
			<div class="header-left">
			  <a href="/" class="logo"><IMG SRC="<?= $imgtoshow ?>" class="header-logo"></a>
			</DIV>
		  <div class="header-right">
  	  	<a class="login" href="/exp/<?= $middleuri ?>/contact">CONTACT</a>
		  	<?php if ( $MenuLogin == "logged") { ?>
					 <a href="/lgd/<?= $middleuri ?>/signoff" class="login right<?php if ($BigMenu == "profile") { echo " active"; } ?>">LOGOUT</a>
				<?php } else { ?>
		    	<a href="/exp/<?= $middleuri ?>/login" class="login">LOGIN</a>
		    <?php } ?>
		  </DIV>
		</DIV>
		
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
  <a href="/lgd/<?= $middleuri ?>/profile" class="right<?php if ($BigMenu == "profile") { echo " active"; } ?>">PROFILE</a>
<?php /*  <a href="/exp/<?= $middleuri ?>/nominate"<?php if ($BigMenu == "nominate") { echo " class=\"active\""; } ?>>NOMINATE</a> */ ?>
  <a href="/lgd/<?= $middleuri ?>/voters"<?php if ($BigMenu == "represent") { echo " class=\"active\""; } ?>>REPRESENT</a>
  <a href="/exp/<?= $middleuri ?>/about"<?php if ($BigMenu == "home") { echo " class=\"active\""; } ?>>ABOUT</a>
<?php } else { ?>
  <a href="/exp/<?= $middleuri ?>/howto" class="right<?php if ($BigMenu == "howto") { echo " active"; } ?>">HOW TO</a>
<?php /*    <a href="/exp/<?= $middleuri ?>/propose"<?php if ($BigMenu == "nominate") { echo " class=\"active\""; } ?>>NOMINATE</a> */ ?>
  <a href="/exp/<?= $middleuri ?>/interested"<?php if ($BigMenu == "represent") { echo " class=\"active\""; } ?>>REPRESENT</a>
  <a href="/exp/<?= $middleuri ?>/about"<?php if ($BigMenu == "home") { echo " class=\"active\""; } ?>>ABOUT</a>
<?php } ?> 
</div>
