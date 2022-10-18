<?php
  if ( preg_match('/Mobile/', $_SERVER['HTTP_USER_AGENT'])) { $MobileDisplay = true; }
  //$MobileDisplay = true; 

  if ( ! empty ($k) && ($URIEncryptedString["SystemUser_ID"] > 0 ||
                        $URIEncryptedString["SystemUser_ID"] == "TMP")) { 
    $MenuLogin = "logged"; 
    $middleuri = rawurlencode($k);  
    $logourl = "/" . $k . "/lgd/summary/summary";
  } else {
    if ( empty ($URIEncryptedString) && empty ($middleuri) && ! empty ($k)) {
      $middleuri = $k;
    }
    if (empty ($middleuri)) { $middleuri = "web"; };
    $logourl = "/" . $middleuri . "/exp/index";
  }
  if ( empty ($imgtoshow )) {  $imgtoshow = "/images/RepMyBlock.png"; }  
  
  if ( empty ($HeaderTwitter)) {
    $HeaderTwitterPicLink = "https://static.repmyblock.org/pics/paste/PoliticalMachineKeepEngagementLow.jpg";
    $HeaderTwitterDesc = "Registrations for the 2023 Citywide Republican and Democratic county committee. Get your nominating petition kit here! The County Committee is the most basic committee of the Democratic and Republican Parties; its their backbone. The &hellip; Continue reading Rep My Block &rarr;";
  }
  
?><!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js">
  <HEAD>
    <META charset="UTF-8">
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="<?= $HeaderTwitterDesc ?>" />
    <meta name="twitter:title" content="Rep My Block - Rep My Block" />
    <meta name="twitter:site" content="@RepMyBlock" />
    <meta name="twitter:image" content="<?= $HeaderTwitterPicLink ?>" />
    <meta name="twitter:creator" content="@RepMyBlock" />
    <meta name="Description" CONTENT="A website to prepare political state nominating petitions to run for party and elected office.">
    
    <TITLE>Rep My Block - Represent My Block</TITLE>
    
    <link rel="icon" href="/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/images/icons/css/all.min.css" >    
    <link rel="stylesheet" type="text/css" href="/css/font_montserrat.css">
    <link rel="stylesheet" type="text/css" href="/css/Primer.css">    
<?php if ($MapShow == true) { ?>
    <link rel="stylesheet" href="/javascript/ol/openlayer/ol.css" type="text/css">
<?php } ?>
    <link rel="dns-prefetch" href="https://www.repmyblock.org">

<?php  if ($MobileDisplay == true) { ?>
    <!--- Mobile Check --->
    <link rel="stylesheet" type="text/css" href="/css/Mobile-RepMyBlock.css" />    
<?php   } else { ?>
    <!--- Not Mobile Check --->
    <link rel="stylesheet" type="text/css" href="/css/RepMyBlock.css" /><?php } ?>    
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
  
  <BODY class="">

    <DIV class="header">
      <DIV class="header-left">
        <A  class="logo" href="<?= $logourl ?>"><IMG class="header-logo" SRC="<?= $imgtoshow ?>"></A>
      </DIV>
      <DIV class="header-right">
        <?php if ( $MenuLogin == "logged") { ?><A class="login" href="/<?= $k ?>/exp/contact/contact">CONTACT</A>
        <A class="login right<?php if ($BigMenu == "profile") { echo " active"; } ?>" href="/<?= $k ?>/lgd/signoff">LOGOUT</A>
<?php } else { ?><A class="login" href="/<?= $middleuri ?>/exp/register/register">REGISTER</a>
        <A class="login" href="/<?= $middleuri ?>/exp/login/login">LOGIN</a><?php } ?>
      </DIV>
    </DIV>

    <DIV class="navbar">
      <?php if ( $MenuLogin == "logged") { ?><A class="right<?php if ($BigMenu == "profile") { echo " active"; } ?>" href="/<?= $k ?>/lgd/profile/user">PROFILE</a>
      <A<?php if ($BigMenu == "represent") { echo " class=\"active\""; } ?> href="/<?= $k ?>/training/steps/torun">REPRESENT</a>
      <A<?php if ($BigMenu == "about") { echo " class=\"active\""; } ?> href="/<?= $k ?>/exp/toplinks/about">ABOUT</a>
<?php } else { ?><A  href="/<?= $middleuri ?>/exp/contact/contact" class="right<?php if ($BigMenu == "contact") { echo " active"; } ?>">CONTACT</a>
      <A class="right<?php if ($BigMenu == "howto") { echo " active"; } ?>" href="/<?= $middleuri ?>/training/steps/torun" >HOW TO</a>
      <A<?php if ($BigMenu == "about") { echo " class=\"active\""; } ?> href="/<?= $middleuri ?>/exp/toplinks/about">ABOUT</a>
    <?php } ?>
    </DIV>

