<?php

function WriteStderr($Data) {
	// Need to save the information
	$STDERR = fopen('php://stderr', 'w+');
	
	fwrite($STDERR, "\n");
	fwrite($STDERR, print_r($Data, 1));
	fwrite($STDERR, "\n");
	
	fclose($STDERR);		
}

function PrintRandomText($length = 9) {
  
  $alpha = "abcdefghijklmnopqrstuvwxyz";
	$alpha_upper = strtoupper($alpha);
	$numeric = "0123456789";
	$special = ".-+=_,!@$#*%<>[]{}";
	$chars = "";
 
	if (isset($_POST['length'])){
    // if you want a form like above
    if (isset($_POST['alpha']) && $_POST['alpha'] == 'on') $chars .= $alpha;
    if (isset($_POST['alpha_upper']) && $_POST['alpha_upper'] == 'on') $chars .= $alpha_upper;
    if (isset($_POST['numeric']) && $_POST['numeric'] == 'on') $chars .= $numeric;
    if (isset($_POST['special']) && $_POST['special'] == 'on') $chars .= $special;
    $length = $_POST['length'];
	} else {
    // default [a-zA-Z0-9]{9}
    $chars = $alpha . $alpha_upper . $numeric;
	}
 
	$len = strlen($chars);
	$pw = '';
 
	for ($i=0;$i<$length;$i++)
  	$pw .= substr($chars, rand(0, $len-1), 1);
 
	// the finished password
	return str_shuffle($pw); 
}

function PrintShortDate($Date) {
	if ( ! empty ($Date)) {
		return date("F jS, Y", strtotime( $Date ));
	}
}

function PrintThreeDigits($Date) {
	if ( ! empty ($Date)) {
		return date("m/d/Y", strtotime( $Date ));
	}
}

function PrintPartyAdjective($Party) {
	switch($Party) {
		case 'DEM': return "Democratic"; break;
		case 'REP': return "Republican"; break;
		case 'BLK': return "No party"; break;
		case 'CON': return "Conservatives"; break;
		case 'IND': return "Independence"; break;
		case 'WOR': return "Working Families"; break;
		case 'GRE': return "Green"; break;
		case 'LBT': return "Libertarian"; break;
		case 'OTH': return "Other"; break;
		case 'WEP': return "Women\'s Equality"; break;
		case 'REF': return "Reform"; break;
		case 'SAM': return "SAM"; break;
	}
}
?>
