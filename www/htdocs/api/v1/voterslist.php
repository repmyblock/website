<?php
	$BigMenu = "profile";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_apiv1.php";
	$r = new api_v1();
	$cleanString = preg_replace("/[^a-zA-Z0-9]/", "", $k);

	WriteStderr($k, "k");

	$DataSearch = array("AD" => "71", "ED" => "47");
	$resultSurvey = $r->SearchVotersFile($DataSearch);
	WriteStderr($resultSurvey, "VoterList");
	// Convert the array to JSON format
	print json_encode($resultSurvey);
?>

