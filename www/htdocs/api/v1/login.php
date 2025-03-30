<?php
	$BigMenu = "profile";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_apiv1.php";
	$r = new api_v1();
	$cleanString = preg_replace("/[^a-zA-Z0-9]/", "", $k);

	if (preg_match('/^\d{5,6}$/', $cleanString)) {
		if (strlen($cleanString) == 5) {
	  	preg_match('/^(\d{2})(\d{3})$/', $cleanString, $matches);
		} else {
	  	preg_match('/^(\d{3})(\d{3})$/', $cleanString, $matches);
		}
	}	

/*	
	case "AD": $sqlquery .= "DataDistrict_StateAssembly = :AD"; $sql_vars["AD"] = $Search; break;
  			case "ED": $sqlquery .= "DataDistrict_Electoral = :ED"; $sql_vars["ED"] = $Search; break;
  			case "CD": $sqlquery .= "CountyCode = :CD"; $sql_vars["CD"] = $Search; break;
  			case "LG": $sqlquery .= "LegisDistr = :LG"; $sql_vars["LG"] = $Search; break;
  			case "TW": $sqlquery .= "TownCity = :TW"; $sql_vars["TW"] = $Search; break;
  			case "WD": $sqlquery .= "Ward = :WD"; $sql_vars["WD"] = $Search; break;
  			case "CG": $sqlquery .= "CongressDistr = :CG"; $sql_vars["CG"] = $Search; break;
  			case "SD": $sqlquery .= "SenateDistr = :SD"; $sql_vars["SD"] = $Search; break;
  			case "PT": $sqlquery .= "Voters_RegParty = :PT"; $sql_vars["PT"] = $Search; break;
  			case "VI": $sqlquery .= "Voters_ID = :VI"; $sql_vars["VI"] = $Search; break;
	*/
	
	$DataSearch = array("AD" => $matches[1], "ED" => $matches[2]);
	WriteStderr($DataSearch, "Dataseach");
	
	$resultSurvey = $r->SearchVotersFile($DataSearch);
	WriteStderr($resultSurvey, "VoterList");
	// Convert the array to JSON format
	print json_encode($resultSurvey);
?>

