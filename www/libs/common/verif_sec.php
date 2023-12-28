<?php
// Variable that need to be set
$CalculatePHPSelf = "";
$BetaVersion = "";
$MapShow = 0;
$MobileDisplay = 0;
$Developping = 0;

require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";	

### This file is the SSL Key used to encrypt the _GET variable.
date_default_timezone_set('America/New_York'); 
require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/SSLKeys/SSLInsideKey.php";

$expuri = explode("/", substr($_SERVER["REQUEST_URI"],1));
if ( $expuri[0] == "howto" ) {
	if ($expuri[1] == "exp" && $expuri[2] == "index") {
		header("Location: " . $FrontEndWebsite . "/howto/training/steps/torun");
	}
	
	if ( count($expuri) == 2) {
		header("Location: " . $FrontEndWebsite . "/howto/training/steps/torun");
	}
}

// This is the code to make sure that url are good
if ( $_SERVER["HTTP_HOST"] != $_SERVER["SERVER_NAME"] ) {
	$exphost = explode(".", $_SERVER["HTTP_HOST"]);
	$expuri = explode("/", substr($_SERVER["REQUEST_URI"],1));

	if ( $exphost[0] != $expuri[0] ) {			
		if ( ! (str_starts_with($expuri[0], 'AAA') && str_ends_with($expuri[0], '%253D'))) {
			$expuri[0] = $exphost[0];
			$newurl = "";
			foreach ($expuri as $var) {
				$newurl .= "/" . $var;
			}
			header("Location: " . $newurl);
			exit();
		}	else {	
			foreach ($expuri as $var) {
				$newurl .= "/" . $var;
			}			
			header("Location: " . $FrontEndWebsite . $newurl);
			exit();
		}	
	}

}

$k = (! empty ($_GET["k"])) ? ((! empty ($_POST["k"])) ? $_POST["k"] : $_GET["k"]) : NULL;
$id = (! empty ($_GET["id"])) ? ((! empty ($_POST["id"])) ? $_POST["id"] : $_GET["id"]) : NULL;

$OverAllMicrotimeStart = microtime(true);
WriteStderr($OverAllMicrotimeStart, $_SERVER['DOCUMENT_URI'] . " ------------------------------------------------------------ Microtime");
WriteStderr($k, $_SERVER['DOCUMENT_URI'] . " Received K");

if ( ! empty ($k)) {
	$Decrypted_k = DecryptURL ( $k );
	parse_str ( $Decrypted_k, $URIEncryptedString);
	$k_raw = $k;
	$k = rawurlencode(rawurlencode($k));
	WriteStderr($Decrypted_k, $_SERVER['DOCUMENT_URI'] . " Decrypted K");
	WriteStderr($URIEncryptedString, $_SERVER['DOCUMENT_URI'] . " URIEncryptedString");
}


$LastTimeUser = (isset($URIEncryptedString["LastTimeUser"])) ? $URIEncryptedString["LastTimeUser"] : NULL ;

// Check the timestamp before moving on
$DEBUG["TimePassed"] = $LastTimeUser;
$DEBUG["TimeFromSystem"] = time();
$DEBUG["TimeDifference"] = time() - $DEBUG["TimePassed"];
$TimerToLoggoff = 36000000;

if ( (time() - $LastTimeUser ) > $TimerToLoggoff  && ! empty ($URIEncryptedString)) { 
	WriteStderr("I am in the Logoff in VerifSec\n");
	goto_signoff();
	exit();
}

// GetMy PHP SELF ... Need to remove the index.php
// _SERVER["PHP_SELF"]
if ($CalculatePHPSelf == 1) {
	preg_match("/(.*)?(\/[^\/]*\.php)$/", $_SERVER["PHP_SELF"], $matches);
	if ( empty ($matches)) {
		$CalculatedSelfPHP = rtrim($_SERVER["PHP_SELF"], '/') . '/';
	} else {
		$CalculatedSelfPHP = rtrim($matches[1], '/') . '/';
	}
}

/* --------- This is the end of the Verif Function ... the rest are functions --------- */
function EncryptURL($string = "") {  	
	global $PubKey;
  openssl_get_publickey($PubKey);

  $MyString = "LastTimeUser=" . time();

  if ( ! empty ($string)) {
  	$MyString .= "&" . $string;
  }
        
	$SizeMessage = strlen($MyString);
  $encpayload = "";
  $blocktext = "";

	$BlockSize = 245;

  $blockct = intval( $SizeMessage / $BlockSize )  + 1;
  if (( $SizeMessage % $BlockSize ) == 0 ) {
  	$blockct--;
  }  
  
  for ($loop = 0; $loop < $blockct; $loop++) {
    $blocktext = substr($MyString, $loop * $BlockSize, $BlockSize);    
    if ( ! openssl_public_encrypt($blocktext, $encblocktext, $PubKey)) {
    	while ($msg = openssl_error_string()) {
    		echo $msg . "<br />\n";
    	}
    }
    
    $encpayload .= $encblocktext;
  }
    
  $MyString = rawurlencode(base64_encode(pack ("Na*", $blockct, $encpayload)));
  WriteStderr($MyString, $_SERVER['DOCUMENT_URI'] . " Encrypted String");
  return $MyString;
}

function DecryptURL ($sealed) {
  // $sealed and $env_key are assumed to contain the sealed data
  // and our envelope key, both given to us by the sealer.
  global $PrivKey;
  openssl_get_privatekey ($PrivKey);
  $finaltext = "";
  
  if ($sealed[0] != "A" && $sealed[1] != "A" ) return;
  
  $arr = unpack('Nblockct/a*', base64_decode(rawurldecode($sealed)));
  $blockct = $arr['blockct'];
  $encpayload=$arr[1];
  $decmessage = "";
  $BlockSize = 256;
  
  for ($loop=0;$loop < $blockct;$loop++) {
    $blocktext = substr($encpayload, $loop * $BlockSize,  $BlockSize);
    
    if ( openssl_private_decrypt($blocktext, $decblocktext, $PrivKey) != 1) {
    	while ($msg = openssl_error_string()) {
    		echo $msg . "<br />\n";
    	}
			//header("Location: /error/?crd=1");
			exit();
    }
    $finaltext .= $decblocktext;
  }
  
  return($finaltext);
}

function WipeURLEncrypted($WhatToKeep = NULL, $WhatToRemove = NULL) {
	global $k, $URIEncryptedString;
	
	WriteStderr($URIEncryptedString, "Entering Wipe URL");	
	$NewURIEncryptedString["LastTimeUser"] = $URIEncryptedString["LastTimeUser"];
			
	if ( ! empty ($URIEncryptedString["SystemUser_ID"])) {
		$NewURIEncryptedString["SystemUser_ID"] = $URIEncryptedString["SystemUser_ID"];
	}
	
	if ( ! empty ($URIEncryptedString["SystemUser_Priv"])) {
		$NewURIEncryptedString["SystemUser_Priv"] = $URIEncryptedString["SystemUser_Priv"];
	}
	
	if ( ! empty ($WhatToKeep)) {
		foreach ($URIEncryptedString as $NewURI => $value) {
			foreach ($WhatToKeep as $var) {
				if ($var == $NewURI) {
					$NewURIEncryptedString[$var] = $value;			
				}
			}
		}
	}
		
	$k = CreateEncoded ( $NewURIEncryptedString );
	$URIEncryptedString = $NewURIEncryptedString;
	WriteStderr($URIEncryptedString, "Entering Wipe URL");	
}

function CreateThePassword ($Password) {
	// Create a string for the crypt
	// Create a ramdon 25 chars string for the seed.			
	$CharsSeed = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 7)), 0, 4);
	$CharsSeed .= time();
	$CharsSeed .= substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 7)), 0, 4);
	$CharsSeed = substr(md5($CharsSeed), 0, 16);
	return crypt($Password, '$6$rounds=5000$' . $CharsSeed . '$');
}

// Found this at 
// https://forums.digitalpoint.com/threads/how-to-using-php-to-get-ipv6-address.1949003/
function IPv4To6($Ip) {
  static $Mask = '::ffff:'; // This tells IPv6 it has an IPv4 address
  $IPv6 = (strpos($Ip, '::') === 0);
  $IPv4 = (strpos($Ip, '.') > 0);

  if (!$IPv4 && !$IPv6) return false;
  if ($IPv6 && $IPv4) $Ip = substr($Ip, strrpos($Ip, ':')+1); // Strip IPv4 Compatibility notation
  elseif (!$IPv4) return $Ip; // Seems to be IPv6 already?
  $Ip = array_pad(explode('.', $Ip), 4, 0);
  if (count($Ip) > 4) return false;
  for ($i = 0; $i < 4; $i++) if ($Ip[$i] > 255) return false;

  $Part7 = base_convert(($Ip[0] * 256) + $Ip[1], 10, 16);
  $Part8 = base_convert(($Ip[2] * 256) + $Ip[3], 10, 16);
  return $Mask.$Part7.':'.$Part8;
}
 
function remove_spaces($text) { 
  $text = str_replace(" ", "&nbsp;", $text);
  return $text;
}

function checked_match_found($var_one, $var_two, $checked_word = "CHECKED") {
	if ( $var_one == $var_two) {
		echo " " . $checked_word;
	}
}

function select_match_found($var_one, $var_two, $checked_word = "SELECTED") {
	if ( $var_one == $var_two) {
		echo " " . $checked_word;
	}
}

function LinkURLForDebug($string) {
	echo "<A HREF=\"" . $string . "\">Follow URL</A>\n";
}

function PrintDebugArray($ArrayToPrint, $Title = "") {

	if ( ! empty ($Title)) {
		echo "<B>" . $Title . "</B><BR>";
	}

	echo "<PRE>";
	print_r($ArrayToPrint);
	echo "</PRE>";
	
	if ( ! empty ($Title)) {
		echo "<HR ALIGN=LEFT WIDTH=40%>";
	}
}

function goto_signoff() {	
	header ("Location: /website/lgd/signoff");
	exit();
}
?>