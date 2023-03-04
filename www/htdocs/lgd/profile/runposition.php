<?php
if ( ! empty ($k)) { $MenuLogin = "logged"; }  
$Menu = "profile";  
$BigMenu = "represent";	

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

if ( empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }	
if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
$Party = PrintParty($URIEncryptedString["UserParty"]);

if ( empty ($URIEncryptedString["Position"])) { 
	header("Location: /" . $k . "/ldg/profilecandidate");
	exit();
}

$rmb = new RepMyBlock();
//$rmbperson = $rmb->ReturnVoterIndex($URIEncryptedString["VotersIndexes_ID"]);
$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);	
$listpositions = $rmb->ListElectedPositions($rmbperson["DataState_Abbrev"]);

$DBTable = "ADED";
if (! empty ($rmbperson["SystemUserSelfDistrict_AD"])) {
	$MyLocalAD = $rmbperson["SystemUserSelfDistrict_AD"];
} else {
	$MyLocalAD = $rmbperson["DataDistrict_StateAssembly"];
}

if (! empty ($rmbperson["SystemUserSelfDistrict_ED"])) {
	$MyLocalED = $rmbperson["SystemUserSelfDistrict_ED"];
} else {
	$MyLocalED = $rmbperson["DataDistrict_Electoral"];
}
$EDAD = sprintf('%02d%03d', $MyLocalAD, $MyLocalED);


$listelection = $rmb->CandidateElection($DBTable, $EDAD, "2021-12-10", $rmbperson["Voters_RegParty"]);
WriteStderr($listelection, "List Election");


WriteStderr($rmbperson, "List Election");


// The addresses will need to be fixed as well.
$Address1 = $rmbperson["DataAddress_HouseNumber"] . " " . $rmbperson["DataStreet_Name"] . " - Apt " . $rmbperson["DataHouse_Apt"]; 
$Address2 = $rmbperson["DataCity_Name"] . ", " . $rmbperson["DataState_Abbrev"] . " " . $rmbperson["DataAddress_zipcode"];


if ( ! empty ($rmbperson["DataFirstName_Text"])) { $DisplayName = $rmbperson["DataFirstName_Text"] . " "; }

if ( ! empty ($rmbperson["DataMiddleName_Text"])) {
	if (strlen ($rmbperson["DataMiddleName_Text"]) > 1 ) {
		$DisplayName .= $rmbperson["DataMiddleName_Text"] . " ";
	} else {
		$DisplayName .= strtoupper($rmbperson["DataMiddleName_Text"]) . " ";
	}
}
if ( ! empty ($rmbperson["DataLastName_Text"])) { $DisplayName .= $rmbperson["DataLastName_Text"]; }

$PetitionData = array (	
									"Elections_ID" => $CurrentElectionID,
									"Voters_RegParty" => $rmbperson["Voters_RegParty"], 
									"TypeElection" => $DBTable,
									"TypeValue" => $EDAD,
									"County_ID" => $rmbperson["DataCounty_ID"],
									"ActiveTeam_ID" => $URIEncryptedString["ActiveTeam_ID"], 
									"AddressLine1" => $Address1, 
									"AddressLine2" => $Address2, 
									"CPrep_Party" => $rmbperson["Voters_RegParty"], 
									"FullName" => $DisplayName, 
									"SystemUser_ID"  => $URIEncryptedString["SystemUser_ID"], 
									"UniqNYSVoterID"  => $rmbperson["Voters_UniqStateVoterID"], 
									"Voters_ID" => $rmbperson["Voters_ID"], 
									
								);
WriteStderr($result, "PetitionData");	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/candidatelogic/NY_CreatePosition.php";	

// We need to add to the permission access to download petitions.
// PERM_MENU_DOWNLOADS			
$rmb->UpdateSystemPriv($URIEncryptedString["SystemUser_ID"], PERM_MENU_DOWNLOADS);			
header("Location: /" . CreateEncoded ( array( 
							"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
							"FirstName" => $URIEncryptedString["FirstName"], 
							"LastName" => $URIEncryptedString["LastName"],
							"VotersIndexes_ID" => $URIEncryptedString["VotersIndexe_ID"], 
							"UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
							"UserParty" => $URIEncryptedString["UserParty"]
))  . "/lgd/downloads/downloads");
exit();

print "<A HREF=\"https://dev-frontend-pdf.repmyblock.org/NY/e" . $finalresult["Candidate_ID"] . "/petition\">Check download Multipetition</A><BR>";
print "<A HREF=\"https://dev-frontend-pdf.repmyblock.org/NY/s" . $GetGroupID["CandidateSet_ID"] . "/petition\">Check download Multipetition</A>";

?>
