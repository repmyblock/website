<?php
//date_default_timezone_set('America/New_York'); 		
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";	

if ( ! isset ($RMBBlockInit)) {
	require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/voterlist_class.php';
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";

	$db_RMB_voterlist = new OutragedDems(0);
	$PageSize = "letter";
	$pdf_RMB_walksheet = new PDF_RMB_VoterList('P','mm', $PageSize);
	
	// This is the date that drive the RMB File in libs/funcs/pdf_frames/version_rmb_<$WalkSheetFrameName>".php
	$WalkSheetFrameName = "2023";
}

WriteStderr($URIEncryptedString, "URIEncryptedString");
	
if ($URIEncryptedString["AD"] > 0 && $URIEncryptedString["ED"] > 0) {
	
	##$ReturnDistrictInfo = $db_RMB_voterlist->FindADEDFromDistrict($URIEncryptedString["DataDistrict_ID"]);
	##WriteStderr($ReturnDistrictInfo, "ReturnDistrictInfo");

	$DataQuery = array("AD" => intval($URIEncryptedString["AD"]), "ED" => intval($URIEncryptedString["ED"]));
	if ($URIEncryptedString["Party"] != "ALL") { $DataQuery["PT"] = $URIEncryptedString["Party"]; }
	
	$voters = $db_RMB_voterlist->SearchVotersFile($DataQuery);										
	
	$PreparedFor = $URIEncryptedString["PreparedFor"];
	
	$WalkSheetUser["CandidateElection_PetitionText"] = "County Committee";
	$WalkSheetUser["Elections_Date"] = "2023-06-27";
	
	$ElectionDate = PrintShortDate($WalkSheetUser["Elections_Date"]);

	$WalkSheetUser["CandidateElection_DBTable"] = "ADED";
	$WalkSheetUser["CandidateElection_DBTableValue"] = sprintf("%2d%03d", $DataQuery["AD"], $DataQuery["ED"]);			
	$WalkSheetUser["Candidate_ID"] = $URIEncryptedString["Party"] . $URIEncryptedString["SystemID"];
	
	WriteStderr(count($voters), "The number of voters found in the database");
			
} else {

	$WalkSheetUser = $db_RMB_voterlist->ListCandidatePetition($URIEncryptedString["Candidate_ID"]);
	$WalkSheetUser = $WalkSheetUser[0];
	
	WriteStderr($WalkSheetUser, "WalkSheetUser");
	/*
		For Data Query
			case "AD" => "AssemblyDistr 
			case "ED" => "ElectDistr 
			case "CD" => "CountyCode 
			case "LG" => "LegisDistr 
			case "TW" => "TownCity  
			case "WD" => "Ward 
			case "CG" => "CongressDistr 
			case "SD" => "SenateDistr 
			case "PT" => "EnrollPolParty
  */
	
	preg_match('/(\d\d)(\d\d\d)/', $WalkSheetUser["CandidateElection_DBTableValue"], $Keywords);		
	$DataQuery = array("AD" => intval($Keywords[1]), "ED" => intval($Keywords[2]), 
											"PT" => $WalkSheetUser["CandidateElection_Party"]);
	$voters = $db_RMB_voterlist->SearchVotersFile($DataQuery);

	$PreparedFor = $WalkSheetUser["Candidate_DispName"];
	$ElectionDate = PrintShortDate($WalkSheetUser["Elections_Date"]);
}

$FileTitle = preg_replace('/[^a-zA-Z0-9]/', '', $PreparedFor);
$Today = date("Ymd_Hi");
$WalkSheet_FileName = "WalkSheet_" . $FileTitle . "_" . $Today . "_" . $WalkSheetUser["CandidateElection_DBTable"] . 
											$WalkSheetUser["CandidateElection_DBTableValue"] . ".pdf";

if (! empty ($voters)) {
	foreach ($voters as $person) {
		if ( ! empty ($person)) {
			$FixedAddress = preg_replace('!\s+!', ' ', $person["DataStreet_Name"] );
			$FixedApt = strtoupper(preg_replace('!\s+!', '', $person["DataHouse_Apt"] ));
			$Address[$FixedAddress][$person["DataAddress_HouseNumber"]]["PrintAddress"] = 
										ucwords(strtolower(trim($person["DataAddress_HouseNumber"] . " " . 
										$person["DataStreet_Name"] )));
			$Address[$FixedAddress][$person["DataAddress_HouseNumber"]]
							[$FixedApt][$person["Voters_Status"]]
							[$person["VotersIndexes_UniqStateVoterID"]] =	$person["DataFirstName_Text"] . " " . 
																														$person["DataMiddleName_Text"] . " " . 
																														$person["DataLastName_Text"];
								
			// The reason for this is that the CandidatePetition_ID is unique enough.
      $Gender[$person["VotersIndexes_UniqStateVoterID"]] = $person["Voters_Gender"];
  		$interval = date_diff(date_create(date('Y-m-d')), date_create($person["VotersIndexes_DOB"]));    		
  		$Age[$person["VotersIndexes_UniqStateVoterID"]] = $interval->y;
		}	
	}
}

$InfoArray["Address"] = $Address;
#WriteStderr($Gender, "Address Array");

$PageSize = "letter";

$RestOfLine = "";
$pdf_RMB_walksheet->Text_PubDate_XLoc = 153;
if ( $WalkSheetUser["CandidateElection_DBTable"] = "ADED") {
	preg_match('/(\d\d)(\d\d\d)/', $WalkSheetUser["CandidateElection_DBTableValue"], $Keywords);
	$RestOfLine = " AD: " . intval($Keywords[1]) . " ED: " . intval($Keywords[2]);
	$pdf_RMB_walksheet->Text_PubDate_XLoc = 133;
}

$pdf_RMB_walksheet->Text_PubDate = date("M j, Y \a\\t g:i a") . $RestOfLine;
$pdf_RMB_walksheet->Text_CandidateName = $PreparedFor;
$pdf_RMB_walksheet->Text_ElectionDate = $ElectionDate;
$pdf_RMB_walksheet->Text_PosType = $WalkSheetUser["CandidateElection_PositionType"];
$pdf_RMB_walksheet->Text_Party = $WalkSheetUser["CandidateElection_Party"];
$pdf_RMB_walksheet->Text_PosText = $WalkSheetUser["CandidateElection_Text"];
$pdf_RMB_walksheet->Text_PosPetText = $WalkSheetUser["CandidateElection_PetitionText"];
$pdf_RMB_walksheet->Text_DistricType = $WalkSheetUser["CandidateElection_DBTable"];
$pdf_RMB_walksheet->Text_DistricHeading = $WalkSheetUser["CandidateElection_DBTableValue"];
$pdf_RMB_walksheet->Text_PetitionSetID = $WalkSheetUser["CandidatePetitionSet_ID"];
 
$pdf_RMB_walksheet->LeftText = $pdf_RMB_walksheet->Text_Party . " CanID:" . $WalkSheetUser["Candidate_ID"];
$pdf_RMB_walksheet->RightText =  $pdf_RMB_walksheet->Text_DistricType . ":" . $pdf_RMB_walksheet->Text_DistricHeading;

// Insert the logo:
if ( $PageSize == "letter") {
	$NumberOfLines = 13; $pdf_RMB_walksheet->BottonPt = 10.4; 
} else if ( $PageSize = "legal") {
	$NumberOfLines = 23; $pdf_RMB_walksheet->BottonPt = 236; 
}

$pdf_RMB_walksheet->AliasNbPages();
$pdf_RMB_walksheet->SetTopMargin(8);
$pdf_RMB_walksheet->SetLeftMargin(5);
$pdf_RMB_walksheet->SetRightMargin(5);
$pdf_RMB_walksheet->SetAutoPageBreak(1, 10);
$pdf_RMB_walksheet->AliasNbPages();
$pdf_RMB_walksheet->AddPage();

$FrameFunc = "version_rmb_" . $WalkSheetFrameName;

WriteStderr($FrameFunc, "Running the frame in State $FrameState");

require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/pdf_frames/rmb/' . $FrameFunc . '.php';
$FrameFunc($pdf_RMB_walksheet, $InfoArray, $Gender, $Age);
	
// This is to block the output if the file is called from file
if ( ! isset ($RMBBlockInit)) {
	$pdf_RMB_walksheet->Output("I", $WalkSheet_FileName);
}

?>

