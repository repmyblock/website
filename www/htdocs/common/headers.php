<?php
	if ( preg_match('/Mobile/', $_SERVER['HTTP_USER_AGENT'])) { $MobileDisplay = true; }
	//$MobileDisplay = true; 

	WriteStderr($k,"Header K");
	WriteStderr($URIEncryptedString["SystemUser_ID"],"Header SystemID");
	

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
		$logourl = "/" . $middleuri . "/exp/index";
	}
	
	// This is the image
	if ( empty ($imgtoshow )) {	$imgtoshow = "/images/RepMyBlock.png"; }	
		
	if ( empty ($HeaderTwitter)) {
		$HeaderTwitterTitle = "Rep My Block - Rep My Block";
		$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/paste/PoliticalMachineKeepEngagementLow.jpg";
		$HeaderTwitterDesc = "Registrations for the 2023 Citywide Republican and Democratic county committee. Get your nominating petition kit here! The County Committee is the most basic committee of the Democratic and Republican Parties; it's their backbone. The &hellip; Continue reading Rep My Block &rarr;";
	}

	if (empty ($HeaderOGDescription)) {
		$HeaderOGDescription = "Represent My Block at the County Committee";
	}
	
?><!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js">
	<HEAD>
		<META charset="UTF-8">
		<meta name="twitter:card" content="summary_large_image" />
		<meta name="twitter:description" content="<?= $HeaderTwitterDesc ?>" />
		<meta name="twitter:title" content="<?= $HeaderTwitterTitle ?>" />
		<meta name="twitter:site" content="@RepMyBlock" />
		<meta name="twitter:image" content="<?= $HeaderTwitterPicLink ?>" />
		<meta name="twitter:creator" content="@RepMyBlock" />
		<meta name="Description" CONTENT="A website to prepare political state nominating petitions to run for party and elected office.">
		<TITLE>Rep My Block - Represent My Block at the County Committee</TITLE>

		<meta name="Title" content="County Committee">
		<meta property="og:title" content="County Committee"/>
		<meta property="og:url" content="https://<?= $_SERVER['HTTP_HOST'] ?><?= $_SERVER['REQUEST_URI'] ?>">
		<meta property="og:description" content="<?= $HeaderOGDescription ?>">
		<meta property="og:type" content="article">
		<link rel="image_src" href="https://www.repmyblock.org/images/RepMyBlock.png" />
		<meta property="og:image" content="https://www.repmyblock.org/images/RepMyBlock.png" />
		<meta property="og:site_name" content="Rep My Block"/>
  
		<link rel="icon" href="/images/favicon/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="/images/favicon/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" type="text/css" href="/images/icons/css/all.min.css" >		
		<link rel="stylesheet" type="text/css" href="/css/font_montserrat.css">
		<link rel="stylesheet" type="text/css" href="/css/Primer.css">		
<?php if ($MapShow == true) { ?>
		<link rel="stylesheet" href="/javascript/ol/openlayer/ol.css" type="text/css">
<?php } ?>
	  <link rel="dns-prefetch" href="https://www.repmyblock.org">

<?php	if ($MobileDisplay == true) { ?>
		<!--- Mobile Check --->
		<link rel="stylesheet" type="text/css" href="/css/Mobile-RepMyBlock.css" />		
<?php 	} else { ?>
		<!--- Not Mobile Check --->
		<link rel="stylesheet" type="text/css" href="/css/RepMyBlock.css" />		
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
		<DIV class="header">
			<div class="header-left">
			  <a href="<?= $logourl ?>" class="logo"><IMG SRC="<?= $imgtoshow ?>" class="header-logo"></a>
			</DIV>
		  <div class="header-right">
		  	<?php if ( $MenuLogin == "logged") { ?>
			  	<a class="login" href="/<?= $k ?>/exp/contact/contact">CONTACT</a>
					<a href="/<?= $k ?>/lgd/signoff" class="login right<?php if ($BigMenu == "profile") { echo " active"; } ?>">LOGOUT</a>
				<?php } else { ?>
			  	<a class="login" href="/<?= $middleuri ?>/exp/register/register">REGISTER</a>
		    	<a href="/<?= $middleuri ?>/exp/login/login" class="login">LOGIN</a>
		    <?php } ?>
		  </DIV>
		</DIV>
		
		<div class="navbar">
		<?php if ( $MenuLogin == "logged") { ?>
		  <a href="/<?= $k ?>/lgd/profile/user" class="right<?php if ($BigMenu == "profile") { echo " active"; } ?>">PROFILE</a>
		  <a href="/<?= $k ?>/training/steps/torun"<?php if ($BigMenu == "represent") { echo " class=\"active\""; } ?>>REPRESENT</a>
		  <a href="/<?= $k ?>/exp/toplinks/about"<?php if ($BigMenu == "about") { echo " class=\"active\""; } ?>>ABOUT</a>
		<?php } else { ?>
		 	<a  href="/<?= $middleuri ?>/exp/contact/contact" class="right<?php if ($BigMenu == "contact") { echo " active"; } ?>">CONTACT</a>
		  <a href="/<?= $middleuri ?>/training/steps/torun" class="right<?php if ($BigMenu == "howto") { echo " active"; } ?>">HOW TO</a>
		  <a href="/<?= $middleuri ?>/exp/toplinks/about"<?php if ($BigMenu == "about") { echo " class=\"active\""; } ?>>ABOUT</a>
		<?php } ?>
		</div><?php WriteStderr($middleuri,"Middle URI at the end of header"); ?>
		