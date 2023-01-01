<?php
//date_default_timezone_set('America/New_York'); 
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";

// The RMBClockInit variable is used by file that use the Merge function to create packets.
// It is used to block the reinitionalization of basic files that were already called.
if ( ! isset ($RMBBlockInit)) {
	require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/NY/petition_class.php';
	require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/script88/PDF_Code128.php';
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
	$db_NY_petition = new OutragedDems();
	$PageSize = "letter";
	$pdf_NY_petition = new PDF_NY_Petition('P','mm', $PageSize);
	$PetitionFrameName = "hano";
}

// Faut que je travaille avec K.
if (strlen($k < 20)) {
	preg_match('/([pse])(\d*)/i', $k, $matches, PREG_OFFSET_CAPTURE);
	switch ($matches[1][0]) {
		case 'p': case 'P': $CanPetitionSet_ID = intval($matches[2][0]); break;
		case 's': case 'S': $CandidateSet_ID = intval($matches[2][0]); break;
		case 'e': case 'E': $Candidate_ID = intval($matches[2][0]); break;
	}
} else {
	$CanPetitionSet_ID = trim($_GET["petid"]);
	$CandidatePetitionSet_ID = trim($_GET["setid"]);
	$WaterMarkVoid = trim($_GET["Watermark"]);
}

WriteStderr($URIEncryptedString, "PDF Petition");

$pdf_NY_petition->Watermark = "VOID - Do not use"; 
$WritenSignatureMonth = "March"; // date("F");
$Variable = "demo-CC";

// Setup for empty petition.
$pdf_NY_petition->WitnessName = "________________________________________"; 
$pdf_NY_petition->WitnessResidence = "_______________________________________________________";


$pdf_NY_petition->TodayDateText = "Date: " . date("F _________ , Y"); 
$pdf_NY_petition->TodayDateText = "Date: " . $WritenSignatureMonth . " _______ , " . date("Y");
$pdf_NY_petition->City = "____________"; 
$pdf_NY_petition->County = "________"; 
$DateForCounter = " ___ / ___ / " . date("Y");
$DateForCounter = date("m") . " / ____ / " . date("Y"); 

#$pdf_NY_petition->WitnessName = "Theo Chino Tavarez"; 
#$pdf_NY_petition->WitnessResidence = "640 Riverside Drive 10B, New York, NY 10031";
#$pdf_NY_petition->City = "New York"; 
#$pdf_NY_petition->County = "New York"; 

if (is_numeric($CanPetitionSet_ID)) { $Variable = "petid"; }
if (is_numeric($CandidateSet_ID)) { $Variable = "setid"; }	
if (is_numeric($Candidate_ID)) { $Variable = "person"; }
if (is_numeric($SystemUser_ID)) { $Variable = "person"; }

if ( ! empty ($URIEncryptedString)) {
	if (! empty ($URIEncryptedString["Candidate_ID"])) {
		$Candidate_ID = $URIEncryptedString["Candidate_ID"];
		$Variable = "person";
	}
	
	if ( ! empty ($URIEncryptedString["CandidateSet_ID"])) {
		$CandidateSet_ID = $URIEncryptedString["CandidateSet_ID"];
		$Variable = "setid";
	}
}
	
switch ($Variable) {
  case 'person';
  
	  if ( $URIEncryptedString["PendingBypass"] == "yes" ) {
	  	$result = $db_NY_petition->ListCandidatePetition($Candidate_ID);	  	
	  } else {
	  	$result = $db_NY_petition->ListCandidatePetition($Candidate_ID, "published");
	  	WriteStderr($result, "PDF Petition RESULT IN Person");
	  }
	  
		$result[0]["CandidateGroup_ID"] = 1;
	  
  	if ( ! empty ($result)) {
  		for ($i = 0; $i < count($result); $i++) { 	 		
	  		$result[$i]["CandidateSet_ID"] = 1;	
				$result[$i]["CandidateParty"] = PrintPartyAdjective($result[0]["Candidate_Party"]);
				$result[$i]["CandidatePetition_VoterCounty"] = $result[0]["DataCounty_Name"];
			}
			$pdf_NY_petition->BarCode = "P" . $Candidate_ID;
			$ElectionDate = PrintShortDate($result[0]["Elections_Date"]);
		}
		
		if ($result[0]["Candidate_Watermark"] == 'no') { $pdf_NY_petition->Watermark = NULL; }	
		else {
			$pdf_NY_petition->Watermark = "VOID - Do not use " . $result[0]["Candidate_Status"]; 
		}

		if ( $result[0]["Candidate_Status"] == "published" || $URIEncryptedString["PendingBypass"] == "yes") break;
		goto democc;
		break;
		
	case 'setid';
	 	if ( $URIEncryptedString["PendingBypass"] == "yes" ) {
	  	$result = $db_NY_petition->ListPetitionGroup($CandidateSet_ID); 	
	  } else {
	  	$result = $db_NY_petition->ListPetitionGroup($CandidateSet_ID, "published");
	  }
	  
	  WriteStderr($result, "Result Set ID");
	
		if ( ! empty ($result)) {
			for ($i = 0; $i < count($result); $i++) {
	  		$result[$i]["CandidateSet_ID"] = 1;
	  		if ( $result[0]["Candidate_Party"] == "BLK" ) {
	  			$pdf_NY_petition->PetitionType = "independent";
	  			$pdf_NY_petition->EmblemFontType = $result[0]["CandidatePartySymbol_Font"];
					$pdf_NY_petition->EmblemFontSize = $result[0]["CandidatePartySymbol_Size"];
					$pdf_NY_petition->PartyEmblem = $result[0]["CandidatePartySymbol_Char"];
					$result[$i]["CandidateParty"] = $result[0]["Candidate_FullPartyName"];				
	  		} else {
	  			$result[$i]["CandidateParty"] = PrintPartyAdjective($result[0]["Candidate_Party"]);	
	  		}
	  		
				$result[$i]["CandidatePetition_VoterCounty"] = $result[0]["DataCounty_Name"];
			}
			
			$pdf_NY_petition->BarCode = "S" . $CandidateSet_ID;
			$ElectionDate = PrintShortDate($result[0]["Elections_Date"]);		
			if ($result[0]["CandidateGroup_Watermark"] == 'no') { $pdf_NY_petition->Watermark = NULL; }	
		}
		
		if ( $result[0]["Candidate_Status"] == "published" || $URIEncryptedString["PendingBypass"] == "yes") break;
		goto democc;
		break;
							
	case 'petid';
		$result = $db_NY_petition->ListCandidatePetitionSet($CanPetitionSet_ID);
		if ( ! empty ($result)) {
			$result[0]["CandidateParty"] = PrintPartyAdjective($result[0]["CanPetitionSet_Party"]);
			$result[0]["CandidatePetition_VoterCounty"] = $result[0]["DataCounty_Name"];
			$pdf_NY_petition->BarCode = $result[0]["CanPetitionSet_ID"];
			$ElectionDate = PrintShortDate($result[0]["Elections_Date"]);
		}
		
		if ( $result[0]["Candidate_Status"] == "published" || $URIEncryptedString["PendingBypass"] == "yes") break;
		
	case 'demo-single':
		demosingle:
		$result[0]["CanPetitionSet_ID"] = 1;
		$result[0]["CandidateElection_Number"] = 1;
		$result[0]["CandidateElection_PositionType"] = "demo";
		$result[0]["Candidate_DispName"] = "Your name here";
		$result[0]["CandidateElection_PetitionText"] = "The election type here";
		$result[0]["Candidate_DispResidence"] = "Your address here";
		$result[0]["CandidateComRplce_FullName"] = "Committee to replace here";
		$result[0]["CandidateComRplce_Residence"] = "Address of committee person";
		$result[0]["CandidatePetition_VoterCounty"] = "A COUNTY NAME";
		$result[0]["CandidateParty"] = "Democratic";
		$pdf_NY_petition->Watermark = "Demo Petition / Not Valid";
		$pdf_NY_petition->BarCode = "Demo Petition";
		break;
	
	case 'demo-CC':
		democc:
		$result[0]["CanPetitionSet_ID"] = 1;
		$result[0]["CandidateElection_Number"] = 1;
		$result[0]["CandidateElection_PositionType"] = "party";
		$result[0]["Candidate_DispName"] = "Your name here\n";
		$result[0]["CandidateElection_PetitionText"] = "Member of the Democratic or Republican Party County Committee from the XXth election district in the XXth assembly district Your County, New York State";
		$result[0]["Candidate_DispResidence"] = "Your address here";
		$result[0]["CandidateComRplce_FullName"] = "Committee to replace here";
		$result[0]["CandidateComRplce_Residence"] = "Address of committee person";
		$result[0]["CandidatePetition_VoterCounty"] = "a New York City";
		$result[0]["CandidateParty"] = "Democratic or Republican";
		$pdf_NY_petition->Watermark = "Demo Petition / Not Valid";
		$pdf_NY_petition->BarCode = "Demo Petition";
		$pdf_NY_petition->DemoPrint = "true";
		break;
}

$pdf_NY_petition->county = $result[0]["CandidatePetition_VoterCounty"];
$pdf_NY_petition->party = $result[0]["CandidateParty"];
$pdf_NY_petition->ElectionDate =  PrintShortDate($result[0]["Elections_Date"]);

// This is for the Custom Data stuff
if ( ! empty ($URIEncryptedString["CustomData"] )) {
	$DateForCounter = $URIEncryptedString["CustomDataDate"]; 
	$pdf_NY_petition->WitnessName = $URIEncryptedString["CustomDataWitnessName"];
	$pdf_NY_petition->WitnessResidence = $URIEncryptedString["CustomDataWitnessResidence"];
	$pdf_NY_petition->City = $URIEncryptedString["CustomDataCity"];
	$pdf_NY_petition->County = $URIEncryptedString["CustomDataCounty"];
	//$pdf_NY_petition->County = $result[0]["CandidatePetition_VoterCounty"];
	$MyCustomAddress = $URIEncryptedString["CustomDataCustomAddress"];
	$MyCustomCounty = $URIEncryptedString["CustomDataCustomCounty"];
	$MyCustomCountyFontSize = $URIEncryptedString["CustomDataCountyFontSize"];
}

// This is to control the TOWN or COUNTY depending of where the petition
// is circulated.
switch ($pdf_NY_petition->county) {
	case "Bronx":
	case "New York":
	case "Richmond":
	case "Queens":
	case "Kings":
		$pdf_NY_petition->TypeOfTown = "County";
		break;

	default:
		$pdf_NY_petition->TypeOfTown = "Town";
		break;
}

$Petition_FileName = "";
if ( ! empty ($result[0]["Candidate_UniqNYSVoterID"])) {
	preg_match('/^NY0+(.*)/', $result[0]["Candidate_UniqNYSVoterID"], $UniqMatches, PREG_OFFSET_CAPTURE);
	$Petition_FileName .= "NY" . $UniqMatches[1][0] . "_";
}

$Petition_FileName .= "Petition";

if ( ! empty ($result[0]["CandidateElection_DBTable"])) {
	$Petition_FileName .= "_" . $result[0]["CandidateElection_DBTable"] . $result[0]["CandidateElection_DBTableValue"];
}

if ( ! empty ($result[0]["Candidate_DispName"])) {
	$Petition_FileName .= "_" . preg_replace('/[^a-z0-9]+/i', '_', trim($result[0]["Candidate_DispName"])) . "_";
} else {
	$Petition_FileName .= "_";
}

$Petition_FileName .= date("Ymd_Hi") . ".pdf";

if ( ! empty ($result)) {
	foreach ($result as $var) {
		if (! empty ($var)) {
			$PetitionData[$var["CandidateGroup_ID"]]["TotalPosition"] = $var["CandidateElection_Number"];
			$PetitionData[$var["CandidateGroup_ID"]]["PositionType"]	= $var["CandidateElection_PositionType"];
			$PetitionData[$var["CandidateGroup_ID"]]["CandidateName"]	= $var["Candidate_DispName"];
			$PetitionData[$var["CandidateGroup_ID"]]["CandidatePositionName"]	= $var["CandidateElection_PetitionText"];
			$PetitionData[$var["CandidateGroup_ID"]]["CandidateResidence"] = $var["Candidate_DispResidence"];
			if ( ! empty($var["CandidateComRplce_FullName"])) {					
				$PetitionData[$var["CandidateGroup_ID"]]["ComReplace_FullName"][$var["CandidateComRplce_ID"]] = $var["CandidateComRplce_FullName"];
				$PetitionData[$var["CandidateGroup_ID"]]["ComReplace_Residence"][$var["CandidateComRplce_ID"]] = $var["CandidateComRplce_Residence"];
			}
		}
	}
}

WriteStderr($PetitionData, "Petition Data");

$Counter = 1;
$TotalCandidates = 0;

$i = 0;
if ( ! empty ($PetitionData)) {
	foreach ( $PetitionData as $var => $key) {
		if ( ! empty ($var)) {
			if ( is_array($key)) {				
				$pdf_NY_petition->Candidate[$TotalCandidates] =  $key["CandidateName"];	
				$pdf_NY_petition->RunningFor[$TotalCandidates] = $key["CandidatePositionName"];
				$pdf_NY_petition->Residence[$TotalCandidates] = $key["CandidateResidence"];
				$pdf_NY_petition->PositionType[$TotalCandidates] = $key["PositionType"];
				
				if ( ! empty ($key["ComReplace_FullName"])) {
					$pdf_NY_petition->Appointments[$TotalCandidates] = "";
					$comma_first = 0;
					foreach ($key["ComReplace_FullName"] as $klo => $vir) {
						if ($comma_first == 1) {
							$pdf_NY_petition->Appointments[$TotalCandidates] .= ", ";
						}
						$pdf_NY_petition->Appointments[$TotalCandidates] .= $vir . ", " . $key["ComReplace_Residence"][$klo];						
						$comma_first = 1;
					}						
				}
				$TotalCandidates++;
			}
		}
	}
}

WriteStderr($TotalCandidates, "Total candidates");

$pdf_NY_petition->NumberOfCandidates = $TotalCandidates;

if ($pdf_NY_petition->NumberOfCandidates > 1) { 
	$pdf_NY_petition->PluralCandidates = "s"; 
	$pdf_NY_petition->PluralAcandidates = "";	
} else { 
	$pdf_NY_petition->PluralCandidates = "";
	$pdf_NY_petition->PluralAcandidates = "a";	
}

$pdf_NY_petition->RunningForHeading["electoral"] = "PUBLIC OFFICE" . strtoupper($pdf_NY_petition->PluralCandidates);
$pdf_NY_petition->RunningForHeading["party"] = "PARTY POSITION" . strtoupper($pdf_NY_petition->PluralCandidates);
$pdf_NY_petition->RunningForHeading["demo"] = "A PARTY POSITION OR A PUBLIC OFFICE" . strtoupper($pdf_NY_petition->PluralCandidates);
$pdf_NY_petition->CandidateNomination = "nomination of such party for public office";
// Add or the if both.	
$pdf_NY_petition->CandidateNomination .= " or for election to a party position of such party.";

// Need to fix that.

if ( $PageSize == "letter") {
	$NumberOfLines = 12 - $pdf_NY_petition->NumberOfCandidates;
	$pdf_NY_petition->BottonPt = 240.4;	
	$pdf_NY_petition->BottonPt = 232;
	//$pdf_NY_petition->BottonPt = 200;
	$Botton =  216.9;
		
} else if ( $PageSize = "legal") {
	$NumberOfLines = 23;
	$pdf_NY_petition->BottonPt = 236;
}

$pdf_NY_petition->AliasNbPages();
$pdf_NY_petition->SetTopMargin(8);
$pdf_NY_petition->SetLeftMargin(5);
$pdf_NY_petition->SetRightMargin(5);
$pdf_NY_petition->SetAutoPageBreak(1, 38);
$pdf_NY_petition->AddPage();

// This is the meat of the petition.	
$Counter = 0;

// Need to calculate the number of empty line.
$TotalCountName = count($Name);

$FrameState = "NY";
$FrameFunc = "version_" . $FrameState . "_" . $PetitionFrameName;

WriteStderr($FrameFunc, "Running the frame in State $FrameState");

require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/pdf_frames/' . $FrameState . '/' . $FrameFunc . '.php';
$FrameFunc($pdf_NY_petition, $InfoArray);

// This is to block the output if the file is called from file
if ( ! isset ($RMBBlockInit)) {
	$pdf_NY_petition->Output("I", $Petition_FileName);
}

?>

