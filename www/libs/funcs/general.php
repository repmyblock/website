<?php

function ordinal($number) {
  $ends = array('th','st','nd','rd','th','th','th','th','th','th');
  if ((($number % 100) >= 11) && (($number%100) <= 13))
      return $number. 'th';
  else
      return $number. $ends[$number % 10];
}

function WriteStderr($Data, $Message = "") {
	 global $Developping;
	 
	// Need to save the information
	if ( $Developping == 1) {
		if ( ! empty ($Message)) {
			error_log($Message . ": " . print_r($Data, 1));
		} else {
			error_log("Write Std Error: " . print_r($Data, 1));
		}
	}
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

function PrintDate($Date) {
	if ( ! empty ($Date)) {
		return date("m.d.y", strtotime( $Date ));
	}
}

function PrintShortTime($Date) {
	if ( ! empty ($Date)) {
		return date("h:i a", strtotime( $Date ));
	}
}

function NewYork_PrintParty($Party) {
	switch($Party) {
		case 'DEM': return "Democrat"; break;
		case 'REP': return "Republican"; break;
		case 'BLK': return "No party"; break;
		case 'CON': return "Conservatives"; break;
		case 'IND': return "Independence Party"; break;
		case 'WOR': return "Working Families"; break;
		case 'GRE': return "Green"; break;
		case 'LBT': return "Libertarian"; break;
		case 'OTH': return "Other"; break;
		case 'WEP': return "Women\'s Equality Party"; break;
		case 'REF': return "Reform"; break;
		case 'SAM': return "SAM"; break;
	}
}

function NewYork_PrintPartyAdjective($Party) {
	switch($Party) {
		case 'DEM': return "Democratic"; break;
		case 'REP': return "Republican"; break;
		case 'BLK': return "No party"; break;
		case 'CON': return "Conservatives"; break;
		case 'IND': return "Independence Party"; break;
		case 'WOR': return "Working Families"; break;
		case 'GRE': return "Green"; break;
		case 'LBT': return "Libertarian"; break;
		case 'OTH': return "Other"; break;
		case 'WEP': return "Women\'s Equality Party"; break;
		case 'REF': return "Reform"; break;
		case 'SAM': return "SAM"; break;
	}
}

function ParseEDAD ($string) {
	preg_match('/(\d\d)(\d\d\d)/', $string, $Keywords);		
	return sprintf('AD %02d / ED %03d', $Keywords[1], $Keywords[2]);
}

function CreateEncoded($VariableToPass, $VariableToRemove = "") {
	$URLString = "";
	
	if ( ! empty ($VariableToPass)) {
		foreach ($VariableToPass as $var => $value) {
			if ( ! empty ($value)) {
				if (! empty($URLString)) { $URLString .= "&"; }
				$URLString .= $var . "=" . $value;
				error_log ("Create Encoded Var: $var\tValue: $value");	
			}
		}		
	}
	
	WriteStderr($URLString, "URLString");
	return rawurlencode(EncryptURL($URLString));
}

function PrintVerifMenu($VerifEmail = true, $VerifVoter = true) {
	if ($VerifEmail == true) { 
		include $_SERVER["DOCUMENT_ROOT"] . "/common/warnings_emailverif.php";
	} else if ($VerifVoter == true) {
		include $_SERVER["DOCUMENT_ROOT"] . "/common/warnings_voterinfo.php";
	}
}

function PlurialMenu($k, $menusarray) {
	
	if ( ! empty ($menusarray)) {
		echo "<nav class=\"UnderlineNav pt-1 mb-4\">\n";
		echo "  <div class=\"UnderlineNav-body\">\n";
		foreach ($menusarray as $var) {
			if ( $_SERVER["PHP_SELF"] == "/lgd/" . $var["url"] . ".php" ) { $selected = " selected"; } else { $selected = ""; }			
			echo "    <a href=\"/lgd/"  . $var["k"] . "/" . $var["url"] . "\" class=\"mobilemenu UnderlineNav-item" .  $selected . "\">" . $var["text"] . "</a>\n";
		}
		echo "</div>\n";
		echo "</nav>\n";
	}
	
}


?>
