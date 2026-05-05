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
const PERM_MENU_OBJECTIONS = 32768;
const PERM_MENU_VENDORS = 65536;
const PERM_MENU_PRESS = 131072;
const PERM_MENU_AMBASSADOR = 262144;
const PERM_MENU_NGO = 524288;

function ordinal($number) {
  $ends = array('th','st','nd','rd','th','th','th','th','th','th');
  if ((($number % 100) >= 11) && (($number%100) <= 13))
      return $number. 'th';
  else
      return $number. $ends[$number % 10];
}

function numbertoalpha($number) {
    $alphabet = 'G7k2Lm0Zx9aQp1R4yTj8Vw5N6bHc3DSeWUFzXoJtCsYqKduhBfOlIrnMiPEgAv';
    $base = strlen($alphabet);

    if ($number < 0) {
        throw new Exception("Number must be non-negative");
    }

    $result = '';

    if ($number == 0) {
        $result = $alphabet[0];
    }

    while ($number > 0) {
        $remainder = $number % $base;
        $result = $alphabet[$remainder] . $result;
        $number = intdiv($number, $base);
    }

    return $result;
}

function alphatonumber($alpha) {
    $alphabet = 'G7k2Lm0Zx9aQp1R4yTj8Vw5N6bHc3DSeWUFzXoJtCsYqKduhBfOlIrnMiPEgAv';
    $base = strlen($alphabet);

    $number = 0;
    $length = strlen($alpha);

    for ($i = 0; $i < $length; $i++) {
        $char = $alpha[$i];
        $value = strpos($alphabet, $char);

        if ($value === false) {
            throw new Exception("Invalid character: $char");
        }

        $number = ($number * $base) + $value;
    }

    return $number;
}

function WriteStderr($data, $message = null, $stop = false) {

	global $Developping;
	
	if ($Developping) {
		$logFile = "/tmp/repmyblock.log";
		$prefix = date("Y-m-d H:i:s") . "\n";

		if (!empty($message)) {
		  $prefix .= $message . "\n";
		}

		if (is_array($data) || is_object($data)) {
		  $output = print_r($data, true);
		} else {
		  $output = (string)$data;
		  $output = preg_replace('/\/AAAA.*3D\//', '/[CRYPTED]/', $output);
		}

		$final = $prefix . $output . "\n";
		file_put_contents($logFile, $final, FILE_APPEND | LOCK_EX);

		if ($stop === true) {
		  exit();
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
    return date("F j<\\S\\U\\P>S</\\S\\U\\P>, Y", strtotime( $Date ));
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

function ToMysqlDate($date) {
  if (empty($date)) return null;
  try {
      return (new DateTime($date))->format('Y-m-d');
  } catch (Exception $e) {
      return null;
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

  if (!empty($VariableToPass)) {
    foreach ($VariableToPass as $var => $value) {

      if ($var != $VariableToRemove) {
        if (is_array($value)) {
          foreach ($value as $k => $v) {

            if ($v !== '' && $v !== null) {
              if (!empty($URLString)) { $URLString .= "&"; }
              $URLString .= $var . "[" . $k . "]=" . $v;

              if ($Developping == 1) {
                error_log("Create Encoded Var: {$var}[{$k}]\tValue: {$v}");
              }
            }
          }
        } else {
          if ($value !== '' && $value !== null) {
            if (!empty($URLString)) { $URLString .= "&"; }
            $URLString .= $var . "=" . rawurlencode($value);

            if ($Developping == 1) {
              error_log("Create Encoded Var: {$var}\tValue: {$value}");
            }
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
          error_log ("Create Encoded Var: $var\tValue: $value\n");  
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
    echo "<!-- Begin Purial Menu --->\n";
    echo "          <NAV class=\"UnderlineNav\">\n";
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

function DB_WorkCounty($CountyID) {
  $County = $this->GetCountyFromNYSCodes($CountyID);
  return $County["DataCounty_Name"];  
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
      return   $_SERVER['HTTP_REFERER'];
      break;
  }
  
  return   $_SERVER['HTTP_REFERER'];
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
    
  } else if(strlen($phoneNumber) == 10) {
   
    $areaCode = substr($phoneNumber, 0, 3);
    $nextThree = substr($phoneNumber, 3, 3);
    $lastFour = substr($phoneNumber, 6, 4);

    $phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
    
  } else if(strlen($phoneNumber) == 7) {
    
    $nextThree = substr($phoneNumber, 0, 3);
    $lastFour = substr($phoneNumber, 3, 4);

    $phoneNumber = $nextThree.'-'.$lastFour;
  }

  return $phoneNumber;
}

function isVerifValidEmail($email) {
  $email = trim($email);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { return false; }
  $domain = substr(strrchr($email, "@"), 1);
  return checkdnsrr($domain, "MX") || checkdnsrr($domain, "A") || checkdnsrr($domain, "AAAA");
}


#function str_starts_with(string $haystack, string $needle): bool {
#  return \strncmp($haystack, $needle, \strlen($needle)) === 0;
#}

#function str_ends_with(string $haystack, string $needle): bool {
#  return $needle === '' || $needle === \substr($haystack, - \strlen($needle));
#}

?>
