<?php
const PERM_SUPERUSER = 4294967295;
const PERM_MENU_PROFILE = 1;
const PERM_MENU_SUMMARY = 2;
const PERM_MENU_DISTRICT = 4;
const PERM_MENU_PETITIONS = 8;
const PERM_MENU_VOTERS = 16;
const PERM_MENU_TEAM = 32;
const PERM_MENU_MESSAGES = 64;
const PERM_MENU_DOWNLOADS = 128;
const PERM_MENU_PLEDGES = 256;
const PERM_ADMIN_MENU = 512;
const PERM_ADMIN_RAWDB = 1024;
const PERM_ADMIN_ASSIGNPRIV = 2048;
const PERM_MENU_DOCU = 4096;
const PERM_MENU_WALKSHEET = 8192;
const PERM_OPTION_ALLPOS = 16384;

function ordinal($number) {
  $ends = array('th','st','nd','rd','th','th','th','th','th','th');
  if ((($number % 100) >= 11) && (($number%100) <= 13))
      return $number. 'th';
  else
      return $number. $ends[$number % 10];
}

function WriteStderr($Data, $Message = "") {	
	global $Developping;

	// if using NGNIX + FPM, check your
	// /var/log/php/ftp-error.log file and not web error.log

	// Need to save the information
	if ( $Developping == 1) {	
		if ( ! empty ($Message)) {

			if (is_array($Data)) {
				if ( empty ($Data)) {
					error_log($Message . ": Empty array");
				} else {
					error_log($Message . ": " . print_r($Data, 1));
				}
			} else {
				$Data = preg_replace('/\/AAAA.*3D\//', '/[CRYPTED]/', $Data);
				error_log($Message . ": " . $Data);
			}

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
		return date("m.d.Y", strtotime( $Date ));
	}
}

function PrintNormalDate($Date) {
	if ( ! empty ($Date)) {
		return date("m / d / Y", strtotime( $Date ));
	}
}

function PrintDateTime($Date) {
	if ( ! empty ($Date)) {
		return date("m.d.y h:i a", strtotime( $Date ));
	}
}

function PrintOnDateTime($Date) {
	if ( ! empty ($Date)) {
		return date("\o\\n m.d.y \a\\t h:i a", strtotime( $Date ));
	}
}


function PrintShortTime($Date) {
	if ( ! empty ($Date)) {
		return date("h:i a", strtotime( $Date ));
	}
}

function PrintParty($Party) {
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

function PrintPartyAdjective($Party) {
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

function MergeEncode($VariableToPass, $VariableToRemove = "LastTimeUser") {
	global $Developping;
	global $URIEncryptedString;

	$URLString = "";
	$VariableToPass = array_replace($URIEncryptedString, $VariableToPass);

	if ( ! empty ($VariableToPass)) {
		foreach ($VariableToPass as $var => $value) {
			if ($var != $VariableToRemove) {
				if ( ! empty ($value)) {
					if (! empty($URLString)) { $URLString .= "&"; }
					$URLString .= $var . "=" . $value;
					if ( $Developping == 1) {	
						error_log ("Create Encoded Var: $var\tValue: $value");
					}
				}
			}
		}
	}

	WriteStderr($URLString, "URLString");
	return rawurlencode(EncryptURL($URLString));
}

function CreateEncoded($VariableToPass, $VariableToRemove = "") {
	global $Developping;
	$URLString = "";

	if ( ! empty ($VariableToPass)) {
		foreach ($VariableToPass as $var => $value) {
			if ( ! empty ($value)) {
				if (! empty($URLString)) { $URLString .= "&"; }
				$URLString .= $var . "=" . $value;
				if ( $Developping == 1) {
					error_log ("Create Encoded Var: $var\tValue: $value");	
				}
			}
		}		
	}
	
	WriteStderr($URLString, "URLString");
	return rawurlencode(EncryptURL($URLString));
}

function PrintVerifMenu($VerifEmail = true, $VerifVoter = true) {
	if ($VerifEmail == true) { 
		include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_emailverif.php";
	} else if ($VerifVoter == true) {
		include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_voterinfo.php";
	}
}

function PlurialMenu($k, $menusarray) {
	if ( ! empty ($menusarray)) {
		echo "\n          <!-- Begin Purial Menu --->\n";
		echo "          <NAV class=\"UnderlineNav pt-1 mb-0\">\n";
		echo "            <DIV class=\"UnderlineNav-body\">\n";
		foreach ($menusarray as $var) {		
			if ( $_SERVER["PHP_SELF"] == "/lgd/" . $var["url"] . ".php" ) { $selected = " selected"; } else { $selected = ""; }			
			echo "              <A class=\"mobilemenu UnderlineNav-item" .  $selected . "\" href=\"/" . $var["k"] . "/lgd/" . $var["url"] . "\">" . $var["text"] . "</a>\n";
		}
		echo "            </DIV>\n";
		echo "          </NAV>\n";
		echo "          <!-- End Purial Menu --->\n";
	}
}

function DB_ReturnFullName($vor) {
	$FullName = $vor["Raw_Voter_FirstName"] . " ";
	if ( ! empty ($vor["Raw_Voter_MiddleName"])) { $FullName .= substr($vor["Raw_Voter_MiddleName"], 0, 1) . ". "; }
	$FullName .= $vor["Raw_Voter_LastName"] ." ";
	if ( ! empty ($vor["Raw_Voter_Suffix"])) { $FullName .= $vor["Raw_Voter_Suffix"]; }				
	$FullName = ucwords(strtolower($FullName));
	return $FullName;
}	

function DB_WorkCounty($CountyID) {
	$County = $this->GetCountyFromNYSCodes($CountyID);
	return $County["DataCounty_Name"];	
}

function DB_ReturnAddressLine1($vor, $apt = 1) {
	$Address_Line1 = "";
	if ( ! empty ($vor["Raw_Voter_ResHouseNumber"])) { $Address_Line1 .= $vor["Raw_Voter_ResHouseNumber"] . " "; }		
	if ( ! empty ($vor["Raw_Voter_ResFracAddress"])) { $Address_Line1 .= $vor["Raw_Voter_ResFracAddress"] . " "; }		
	if ( ! empty ($vor["Raw_Voter_ResPreStreet"])) { $Address_Line1 .= $vor["Raw_Voter_ResPreStreet"] . " "; }		
	$Address_Line1 .= $vor["Raw_Voter_ResStreetName"] . " ";
	if ( ! empty ($vor["Raw_Voter_ResPostStDir"])) { $Address_Line1 .= $vor["Raw_Voter_ResPostStDir"] . " "; }		
	if ( ! empty ($vor["Raw_Voter_ResApartment"]) && $apt == 1) { $Address_Line1 .= "- Apt. " . $vor["Raw_Voter_ResApartment"]; }
	$Address_Line1 = preg_replace('!\s+!', ' ', $Address_Line1 );
	return $Address_Line1;
}

function DB_ReturnAddressLine2($vor) {
	$Address_Line2 = $vor["Raw_Voter_ResCity"] . ", NY " . $vor["Raw_Voter_ResZip"];
  return $Address_Line2;
}

function PrintReferer($order = 0) {
	WriteStderr($_SERVER["HTTP_REFERER"], "HTTP_REFERER");

	switch ($order) {
		case '1':
			$keywords = preg_split("/\//", $_SERVER['HTTP_REFERER']);
			WriteStderr($keywords , "Rest for Referer");
			return $keywords;
			break;
			
		default:
			return 	$_SERVER['HTTP_REFERER'];
			break;
	}
	
	return 	$_SERVER['HTTP_REFERER'];
}

function MatchPriviledges($TotalPriv, $PrivToCheck) {	
	return ((intval($PrivToCheck) & intval($TotalPriv)) != 0);
}

function FormatPhoneNumber($phoneNumber) {
    $phoneNumber = preg_replace('/[^0-9]/','',$phoneNumber);

    if(strlen($phoneNumber) > 10) {
        $countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
        $areaCode = substr($phoneNumber, -10, 3);
        $nextThree = substr($phoneNumber, -7, 3);
        $lastFour = substr($phoneNumber, -4, 4);

        $phoneNumber = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($phoneNumber) == 10) {
        $areaCode = substr($phoneNumber, 0, 3);
        $nextThree = substr($phoneNumber, 3, 3);
        $lastFour = substr($phoneNumber, 6, 4);

        $phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($phoneNumber) == 7) {
        $nextThree = substr($phoneNumber, 0, 3);
        $lastFour = substr($phoneNumber, 3, 4);

        $phoneNumber = $nextThree.'-'.$lastFour;
    }

    return $phoneNumber;
}

function str_starts_with(string $haystack, string $needle): bool {
	return \strncmp($haystack, $needle, \strlen($needle)) === 0;
}

function str_ends_with(string $haystack, string $needle): bool {
	return $needle === '' || $needle === \substr($haystack, - \strlen($needle));
}
?>
