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
	$DataSearch = array("AD" => $matches[1], "ED" => $matches[2]);
	WriteStderr($DataSearch, "Dataseach");
	
	$resultSurvey = $r->SearchVotersFile($DataSearch);
	WriteStderr($resultSurvey, "VoterList");
	// Convert the array to JSON format
	print json_encode($resultSurvey);
?>

