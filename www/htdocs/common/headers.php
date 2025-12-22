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
    
    if ( ! empty ($BrandLink)) { $logourl = $BrandLink; }
  }  
  
  $HTMLDesc = "Rep My Block is your starting point to run The starting point on how to run for office with no money by running for District Leader, County Committee and Precinct Officer.";
  $HTMLTitle = "Rep My Block - The starting point on how to run for office with no money by running for District Leader, County Committee and Precinct Officer.";
  
  // This is the image
  if ( empty ($imgtoshow )) {  $imgtoshow = "/images/RepMyBlock.png"; }  

  if (empty ($HeaderTwitterSite)) {  $HeaderTwitterSite = "@RepMyBlock"; }
  if (empty ($HeaderTwitterCreator)) {  $HeaderTwitterCreator = "@RepMyBlock"; }
    
  if (empty ($HeaderTwitter)) {
    $HeaderTwitterTitle = "Rep My Block - Rep My Block";
    $HeaderTwitterPicLink = $FrontEndStatic . "/pics/paste/PoliticalMachineKeepEngagementLow.jpg";
    $HeaderTwitterDesc = "Registrations for the 2024 Queens, Brooklyn and Bronx Democratic and 2025 Citywide Republican county committee. Get your nominating petition kit here! The County Committee is the most basic committee of the Democratic and Republican Parties; it's their backbone. The &hellip; Continue reading Rep My Block &rarr;";
  }

  if (empty ($HeaderOGTitle)) {  $HeaderOGTitle = "County Committee"; }
  if (empty ($HeaderOGDescription)) {  $HeaderOGDescription = "Represent My Block at the County Committee"; }
  if (empty ($HeaderOGImage)) { 
    $HeaderOGImage = $FrontEndWebsite . "/images/RepMyBlock.png"; 
    $HeaderOGImageWidth = "99";
    $HeaderOGImageHeight = "71";
  }

	/* Logo in SGV in comment
		$LogoImgSVG = "data:image/svg+xml;utf8,<svg version='1.2' baseProfile='tiny' id='Rep_My" . 
		"_Block_Logo' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xl" . 
		"ink' x='0px' y='0px' viewBox='0 0 181 140' overflow='visible' xml:space='preserve'><g>" . 
		"<polygon fill='%23FFFFFF' points='144.2,121.9 14.4,121.9 59.8,26 169.1,6.8'/><polygon " .
		"fill='%23ED2B61' points='89.5,95.4 7.9,95.4 34.8,35.5 99.5,26.8'/><polygon fill='%2317" .
		"307D' points='115.9,45.5 131.6,45.5 129.5,50.6 119.5,50.6 117.9,54.3 127.3,54.3 125.2," .
		"59.4 115.8,59.4 114.1,63.5 124.8,63.5 122.2,68.6 106.1,68.6'/><g><path fill='%2317307D" .
		"' d='M136.9,56.1h2.5c1.2,0,2.2-0.2,2.9-0.7c0.7-0.5,1.2-1.2,1.6-2.2c0.4-1,0.4-1.7,0.1-2" .
		".1	c-0.3-0.5-1.1-0.7-2.3-0.7h-2.5L136.9,56.1z M135.5,45.5h8.2c1.7,0,3.1,0.2,4,0.6c1,0." .
		"4,1.7,1,2,1.7c0.4,0.7,0.5,1.5,0.4,2.4 c-0.1,0.9-0.4,1.9-0.8,3c-0.4,1.1-1,2.1-1.6,3c-0." .
		"7,1-1.5,1.8-2.5,2.5c-1,0.7-2.1,1.3-3.4,1.7c-1.3,0.4-2.8,0.6-4.5,0.6h-2.6	l-3.1,7.5H126" .
		"L135.5,45.5z'/></g><polygon fill='%2317307D' points='106.2,95.4 111.6,82.8 102.2,95.4 " .
		"97.8,95.4 99.2,82.7 93.7,95.4 88.1,95.4 98,72.4 105,72.4 103.3,87.8 114.6,72.4 121.6,7" .
		"2.4 112,95.4'/><polygon fill='%2317307D' points='128.8,72.4 129.2,81.2 136.9,72.4 143." .
		"3,72.4 130.1,86.5 126.4,95.4 120.3,95.4 124,86.5 122.3,72.4'/><g><path fill='%2317307D" .
		"' d='M22.4,117.2h3.4c1.3,0,2.3-0.2,3-0.7c0.7-0.5,1.2-1.1,1.6-1.9c0.4-0.8,0.4-1.4,0.2-1" .
		".8	c-0.3-0.4-1-0.6-2.2-0.6h-3.6L22.4,117.2z M26.8,107.7h3.3c1.1,0,1.9-0.2,2.4-0.5c0.5-" .
		"0.4,1-0.9,1.3-1.6c0.3-0.7,0.4-1.3,0.1-1.6 c-0.3-0.3-1-0.5-2.2-0.5h-3L26.8,107.7z M25.2" .
		",98.8h9.5c1.6,0,2.8,0.2,3.7,0.5c0.9,0.3,1.5,0.7,1.9,1.3c0.4,0.5,0.5,1.2,0.5,1.9 c-0.1," .
		"0.7-0.3,1.5-0.7,2.3c-0.5,1-1.1,2-1.9,2.8c-0.8,0.8-1.8,1.5-3.1,2.1c1,0.6,1.5,1.4,1.6,2." .
		"3c0.1,0.9-0.1,1.9-0.7,3.1 c-0.4,0.9-1,1.8-1.6,2.6c-0.7,0.8-1.5,1.6-2.5,2.2c-1,0.6-2.1," .
		"1.1-3.4,1.5c-1.3,0.4-2.8,0.5-4.4,0.5h-9.7L25.2,98.8z'/></g><polygon fill='%2317307D' p" .
		"oints='45.3,98.8 51.4,98.8 43.4,116.6 53.6,116.6 50.7,121.9 34.8,121.9'/><g><path fill" .
		"='%2317307D' d='M104.1,113.5c-0.6,1.3-1.4,2.5-2.3,3.5c-0.9,1.1-2,2-3.1,2.9c-1.2,0.8-2." .
		"5,1.4-3.9,1.9 c-1.4,0.5-3,0.7-4.6,0.7c-1.9,0-3.4-0.3-4.5-0.9c-1.1-0.6-1.9-1.4-2.4-2.5c" .
		"-0.4-1.1-0.6-2.3-0.4-3.8c0.2-1.5,0.7-3.1,1.4-4.9	c0.8-1.8,1.7-3.5,2.8-5c1.1-1.5,2.3-2." .
		"8,3.7-3.9c1.4-1.1,2.9-1.9,4.5-2.5c1.6-0.6,3.4-0.9,5.2-0.9c2.8,0,4.7,0.7,5.7,2.1 c1,1.4" .
		",1.2,3.4,0.5,6l-6.4,0.7c0.1-0.5,0.2-1,0.2-1.4s-0.1-0.8-0.2-1.1c-0.2-0.3-0.4-0.6-0.8-0." .
		"7c-0.3-0.2-0.8-0.3-1.4-0.3	c-2.9,0-5.3,2.2-7.2,6.7c-0.5,1.2-0.9,2.3-1,3.2c-0.2,0.9-0.2" .
		",1.6,0,2.1c0.2,0.5,0.5,0.9,0.9,1.2c0.4,0.2,1,0.4,1.7,0.4	c2.3,0,4.1-1.2,5.4-3.7H104.1z" .
		"'/></g><polygon fill='%2317307D' points='121.4,107.6 123.7,121.9 117,121.9 115.6,111.9" .
		" 112.2,114.5 109.2,121.9 103,121.9 112.6,98.8 118.7,98.8 115.2,107.2 125.6,98.8 132.2," .
		"98.8'/><g><path fill='%2317307D' d='M97,55.8h2.9c1.2,0,2.1-0.2,2.8-0.7s1.2-1.2,1.6-2.1" .
		"c0.4-0.9,0.4-1.5,0.1-2c-0.3-0.5-1.1-0.7-2.3-0.7h-2.7 L97,55.8z M110.2,52.8c-0.6,1.5-1." .
		"5,2.7-2.5,3.9c-1,1.1-2.2,2-3.7,2.7l2.4,9.2h-6.3l-2-7.9h-3.2l-3.5,7.9h-5.7l10.2-23h8.7 " .
		"c1.7,0,3,0.2,4,0.6c1,0.4,1.6,1,2,1.6c0.4,0.7,0.5,1.5,0.4,2.3C110.9,51,110.6,51.9,110.2" .
		",52.8'/></g><polygon fill='%23ED2B61' points='52.8,121.9 78.9,121.9 87.5,98.8 61.3,98." .
		"8'/></g></svg>";
	*/

?><!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js">
  <HEAD>
    <meta charset="UTF-8">
    <link rel="dns-prefetch" href="<?= $FrontEndWebsite ?>">
<?php if ("https://" . $_SERVER['HTTP_HOST'] != $FrontEndWebsite && ! preg_match('/brand/', $_SERVER['SCRIPT_NAME'])) { ?><meta name="robots" content="noindex"><?php } ?>
<?php if ($MenuLogin != "logged") { ?>
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:description" content="<?= $HeaderTwitterDesc ?>">
    <meta name="twitter:title" content="<?= $HeaderTwitterTitle ?>">
    <meta name="twitter:site" content="<?= $HeaderTwitterSite ?>">
    <meta name="twitter:image" content="<?= $HeaderTwitterPicLink ?>">
    <meta name="twitter:creator" content="<?= $HeaderTwitterCreator ?>">
    
    <meta property="og:title" content="<?= $HeaderOGTitle ?>">
    <meta property="og:url" content="https://<?= $_SERVER['HTTP_HOST'] ?><?= $_SERVER['REQUEST_URI'] ?>">
    <meta property="og:description" content="<?= $HeaderOGDescription ?>">
    <meta property="og:type" content="webiste">
    <meta property="og:image" content="<?= $HeaderOGImage ?>">    
    <meta property="og:image:width" content="<?= $HeaderOGImageWidth ?>">  
    <meta property="og:image:height" content="<?= $HeaderOGImageHeight ?>">
    <meta property="og:site_name" content="Rep My Block">
    
    <meta name="Description" content="<?= $HTMLDesc ?>">
    <meta name="Title" content="<?= $HTMLTitle ?>">
    
    <link rel="image_src" href="<?= $FrontEndWebsite ?>/images/RepMyBlock.png">
<?php } ?>    
    <link rel="icon" href="/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/images/icons/css/all.min.css" >    
    <link rel="stylesheet" type="text/css" href="/css/font_montserrat.css">

<?php  if ($MobileDisplay == true) { ?>
    <!--- Check Mobile --->
    <link rel="stylesheet" type="text/css" href="/css/RepMyBlock_Mobile.css">    
<?php } else { ?>
    <!--- Check Desktop --->
    <link rel="stylesheet" type="text/css" href="/css/RepMyBlock_Desktop.css">    
<?php } ?>
<?php if ($VideoOnHtml == true) { ?>
    <link rel="stylesheet" type="text/css" href="/css/video.css">
<?php } ?>
<?php if ($MapShow == true) { ?>
    <link rel="stylesheet" href="/javascript/ol/openlayer/ol.css" type="text/css">
    <style>
    .map {
      height: 400px;
      width: 100%;
    }
  </style>
  <script LANGUAGE="javascript" src="/javascript/ol/openlayer/ol.js"></script>
<?php } ?>
    <TITLE>Rep My Block - The starting point on how to run for office with no money by running for District Leader, County Committee and Precinct Officer.</TITLE>
  </HEAD>
  
  <BODY>
    <DIV class="header">
      <div class="header-logo">
        <a href="<?= $logourl ?>" <?php 
          if ( ! empty ($BrandTargetName)) { ?> TARGET="<?= $BrandTargetName ?>"<?php } 
        ?>><img src="/images/RepMyBlock.svg" alt="Rep My Block"></A>
      </DIV>  
    
      <DIV class="header-text">
        <div class="header-top">
<?php if ( $MenuLogin == "logged") { ?>
          <a class="login" href="/<?= $k ?>/user/contact">CONTACT</a>
          <a href="/<?= $k ?>/lgd/signoff" class="<?php if ($BigMenu == "profile") { echo " active"; } ?>">LOGOUT</a>
<?php } else { ?>
       	  <a class="login" href="/<?= $middleuri ?>/register/user">REGISTER</a>
          <a href="/<?= $middleuri ?>/user/login" class="login">LOGIN</a>
<?php } ?>
       	</DIV>
          
        <div class="header-bottom"><?php
        	if ( $MenuLogin == "logged") {
        ?> 
          <a href="/<?= $k ?>/toplinks/about"<?php if ($BigMenu == "about") { echo " class=\"active\""; } ?>>ABOUT</a>
          <a href="/<?= $k ?>/training/steps/torun"<?php if ($BigMenu == "represent") { echo " class=\"active\""; } ?>>REPRESENT</a>
          <a href="/<?= $k ?>/lgd/profile/user" class="<?php if ($BigMenu == "profile") { echo " active"; } ?>">PROFILE</a><?php 
          } else {
        ?>
          
          <a href="/<?= $middleuri ?>/toplinks/about"<?php if ($BigMenu == "about") { echo " class=\"active\""; } ?>>ABOUT</a>
          <a href="/<?= $middleuri ?>/training/steps/torun" class="right<?php if ($BigMenu == "howto") { echo " active"; } ?>">HOW TO</a>
          <a href="/<?= $middleuri ?>/user/contact" class="right<?php if ($BigMenu == "contact") { echo " active"; } ?>">CONTACT</a>
        <?php }
       ?></div>  
      </DIV>
    </DIV>