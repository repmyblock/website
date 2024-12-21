<?php
	$BigMenu = "profile";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_survey.php";
	$r = new survey();
	$cleanString = preg_replace("/[^a-zA-Z0-9]/", "", $k);
	$resultSurvey = $r->ListSurveyFromAPI($cleanString);
	WriteStderr($resultSurvey, "Result Survey");
	// Convert the array to JSON format
	print json_encode($resultSurvey);
?>


