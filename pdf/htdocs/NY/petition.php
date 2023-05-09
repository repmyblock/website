<?php
//date_default_timezone_set('America/New_York'); 

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";

// The RMBClockInit variable is used by file that use the Merge function to create packets.
// It is used to block the reiitionalization of basic files that were already called.

$PDFOptions["SigMonth"] = date("F");
$PDFOptions["DateForCounter"] = "/     / " . date("Y");
$PDFOptions["DateForWitness"] = "______________________";
$PDFOptions["WitnessName"] = "________________________________________"; 
$PDFOptions["WitnessResidence"] = "_______________________________________________________";
$PDFOptions["City"] = "____________"; 
$PDFOptions["County"] = "________"; 

if ( ! isset ($RMBBlockInit)) {
	require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/NY/petition_class.php';
	require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/script88/PDF_Code128.php';
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
	
	$StrPos = strpos($_SERVER['REQUEST_URI'], "?") + 1;
	if ($StrPos > 1) $Options = explode("/", substr($_SERVER['REQUEST_URI'], $StrPos));

	$db_NY_petition = new OutragedDems();
	$PageSize = "letter";
	$PetitionFrameName = "hano";
	
	// This is to pass option to the petition.
	if ( ! empty ($Options)) {
		foreach ($Options as $var) {
			$splitvar = explode(":", $var);
			switch ($splitvar[0]) {
				case 'frame':	$PetitionFrameName = $splitvar[1]; break;
				case 'pgsz': 
					$PageSize = $splitvar[1];
					preg_match('/(\d{1,})[xX](\d{1,})/', $splitvar[1], $matches, PREG_OFFSET_CAPTURE);
					if ( ! empty ($matches[0]) ) {
						$PageSize = array( $matches[2][0], $matches[1][0] );
					} 
					break;	
				case 'sigmonth': $PDFOptions["SigMonth"] = urldecode($splitvar[1]); break;
				case 'filldate': $PDFOptions["DateForCounter"] = date("m") . " / __ / " . date("Y"); break;
				case 'witnessdate': $PDFOptions["DateForWitness"] = $PDFOptions["SigMonth"] . " _______ , " . date("Y");
				case 'witnessname': $PDFOptions["WitnessName"] = urldecode($splitvar[1]); break;
				case 'witnessaddress': $PDFOptions["WitnessAddress"] = urldecode($splitvar[1]); break;
				case 'witnesscity': $PDFOptions["WitnessCity"] = urldecode($splitvar[1]); break;
				case 'witnesscounty': $PDFOptions["WitnessCounty"] = urldecode($splitvar[1]); break;
				case 'fillcounty': $PDFOptions["FillCounty"] = urldecode($splitvar[1]); break; 
				case 'witnesstype': $PDFOptions["WitnessType"] = $splitvar[1]; break;
			}
		}
	}
	
	$pdf_NY_petition = new PDF_NY_Petition('P','mm', $PageSize);	
}

// Faut que je travaille avec K.
$SizeK = strlen($k);

if ($SizeK == 12) {
	$result = $db_NY_petition->ListPetitionGroup($k);
	
	if ( empty($result)) {
		$Variable = "demo-CC";
	}
	
} else if ( ! empty ($URIEncryptedString)) {
		
	if (! empty ($URIEncryptedString["Candidate_ID"])) {
		$Candidate_ID = $URIEncryptedString["Candidate_ID"];
		$Variable = "person";
	}
	
	if ( ! empty ($URIEncryptedString["CandidateSet_ID"])) {
		$CandidateSet_ID = $URIEncryptedString["CandidateSet_ID"];
		$Variable = "setid";
	}
	
	if ( $URIEncryptedString["Voters_ID"] > 0 && $URIEncryptedString["ElectionPosition_ID"] > 0) {
		$Variable = "onthefly";
	}
} else {
	$Variable = "demo-CC";
}

WriteStderr($URIEncryptedString, "PDF Petition");
WriteStderr($Variable, "Variable");

$pdf_NY_petition->Watermark = "VOID - Do not use"; 

// Setup for empty petition.
$pdf_NY_petition->WitnessName = $PDFOptions["WitnessName"];
$pdf_NY_petition->WitnessResidence = $PDFOptions["WitnessAddress"];
$pdf_NY_petition->TodayDateText = "Date: " . $PDFOptions["DateForWitness"];
$pdf_NY_petition->City = $PDFOptions["WitnessCity"];
$pdf_NY_petition->County = $PDFOptions["WitnessCounty"];
$pdf_NY_petition->AutoFillCounty = $PDFOptions["FillCounty"];

switch ($Variable) {
	case 'onthefly';
	
		$VoterResult = $db_NY_petition->SearchVotersFile(array("VI" => $URIEncryptedString["Voters_ID"]));
		WriteStderr($VoterResult, "PDF Petition RESULT IN Person");
		
		$EDAD = sprintf('%02d%03d', $VoterResult[0]["DataDistrict_StateAssembly"], $VoterResult[0]["DataDistrict_Electoral"]);
		
		$MySQLDate = "2023-06-27";
		$result[0]["Elections_Date"] = PrintShortDate($MySQLDate);
		$result[0]["CandidateParty"] = PrintPartyAdjective($VoterResult[0]["Voters_RegParty"]);
	
		$PositionInformation = $db_NY_petition->FindElection("ADED", $EDAD, $VoterResult[0]["Voters_RegParty"], $MySQLDate);
		WriteStderr($PositionInformation, "Party Position Information");
		
		if ( empty ($PositionInformation)) {
			$result[0]["CandidateElection_PetitionText"] = "Member of the " . $VoterResult[0]["DataCounty_Name"] . " " .$result[0]["CandidateParty"] . 
																" Party County Committee from the " . 
																ordinal($VoterResult[0]["DataDistrict_Electoral"]) .  " election district in the " .
																ordinal($VoterResult[0]["DataDistrict_StateAssembly"]) . " assembly district";
		} else {
			$result[0]["CandidateElection_PetitionText"] = $PositionInformation["CandidateElection_PetitionText"];
		}

		$result[0]["Candidate_DispName"] = $VoterResult[0]["DataFirstName_Text"] . " ";
		if ( ! empty ($VoterResult[0]["DataMiddleName_Text"])) {
			if ( strlen($VoterResult[0]["DataMiddleName_Text"]) > 1 ) {
				$result[0]["Candidate_DispName"].= $VoterResult[0]["DataMiddleName_Text"] . " ";
			} else {
				$result[0]["Candidate_DispName"] .= $VoterResult[0]["DataMiddleName_Text"] . ". ";
			}
		}
    $result[0]["Candidate_DispName"] .= $VoterResult[0]["DataLastName_Text"];
    
    $result[0]["Candidate_DispResidence"] = "";
    if ( ! empty ($VoterResult[0]["DataAddress_HouseNumber"])) { $result[0]["Candidate_DispResidence"] .= $VoterResult[0]["DataAddress_HouseNumber"] . " "; }
    if ( ! empty ($VoterResult[0]["DataAddress_FracAddress"])) { $result[0]["Candidate_DispResidence"] .= $VoterResult[0]["DataAddress_FracAddress"] . " "; }
    if ( ! empty ($VoterResult[0]["DataAddress_PreStreet"])) { $result[0]["Candidate_DispResidence"] .= $VoterResult[0]["DataAddress_PreStreet"] . " "; }
    if ( ! empty ($VoterResult[0]["DataStreet_Name"])) { $result[0]["Candidate_DispResidence"] .= $VoterResult[0]["DataStreet_Name"] . " "; }    
    if ( ! empty ($VoterResult[0]["DataAddress_PostStreet"])) {	$result[0]["Candidate_DispResidence"] .= $VoterResult[0]["DataAddress_PostStreet"] . " "; }
    
    $tire = "- ";
    if ( ! empty ($VoterResult[0]["DataHouse_Type"])) { $result[0]["Candidate_DispResidence"] .= $tire . $VoterResult[0]["DataHouse_Type"] . " ";	$tire = ""; }
   	if ( ! empty ($VoterResult[0]["DataHouse_Apt"])) { $result[0]["Candidate_DispResidence"] .= $tire . $VoterResult[0]["DataHouse_Apt"] . " "; }
    
    $result[0]["Candidate_DispResidence"] = rtrim($result[0]["Candidate_DispResidence"]) . "\n" . $VoterResult[0]["DataCity_Name"] . ", " . 
    																					$VoterResult[0]["DataState_Abbrev"] . " " . $VoterResult[0]["DataAddress_zipcode"];
   
		$result[0]["CanPetitionSet_ID"] = 1;
		$result[0]["CandidateElection_Number"] = 1;
		$result[0]["CandidateElection_PositionType"] = "party";
		$result[0]["CandidatePetition_VoterCounty"] = $VoterResult[0]["DataCounty_Name"];
		$result[0]["DataCounty_Name"] = $VoterResult[0]["DataCounty_Name"];
		$result[0]["CandidateGroup_ID"] = 1;
		$result[0]["CandidateGroup_Party"] = $VoterResult[0]["Voters_RegParty"];
				
		$pdf_NY_petition->Watermark = "Demo Petition / Not Valid";
		$pdf_NY_petition->BarCode = "Demo Petition";
		#$pdf_NY_petition->DemoPrint = "true";

	break;
			
	case 'setid';
	 	if ( $URIEncryptedString["PendingBypass"] == "yes" ) {
	  	$result = $db_NY_petition->ListPetitionGroup($CandidateSet_ID); 	
	  } else {
	  	$result = $db_NY_petition->ListPetitionGroup($CandidateSet_ID, "published");
	  }
	
	 
		if ( ! empty ($result)) {
			for ($i = 0; $i < count($result); $i++) {
	  		$result[$i]["CandidateSet_ID"] = 1;
	  		if ( $result[0]["Candidate_Party"] == "BLK" ) {
	  			$PDFOptions["WitnessType"] = "independent";
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
		
	case 'demo-CC':
		democc:
		$result[0]["CanPetitionSet_ID"] = 1;
		$result[0]["CandidateElection_Number"] = 1;
		$result[0]["CandidateElection_PositionType"] = "party";
		$result[0]["CandidateName"] = "Your name here\n";
		$result[0]["CandidatePositionName"] = "Member of the Democratic or Republican Party County Committee from the XXth election district in the XXth assembly district Your County, New York State";
		$result[0]["CandidateResidence"] = "Your address here";
		$result[0]["CandidateComRplce_FullName"] = "Committee to replace here";
		$result[0]["CandidateComRplce_Residence"] = "Address of committee person";
		$result[0]["CandidatePetition_VoterCounty"] = "a New York City";
		$result[0]["CandidateParty"] = "Democratic or Republican";
		$result[0]["Elections_Date"] = "on a certain date";
				
		$pdf_NY_petition->Watermark = "Demo Petition / Not Valid";
		$pdf_NY_petition->BarCode = "Demo Petition";
		$pdf_NY_petition->DemoPrint = "true";
		break;
}


if ( $result[0]["Candidate_Party"] == "BLK" ) {
	$PDFOptions["WitnessType"] = "independent";
	$pdf_NY_petition->party = $result[0]["Candidate_FullPartyName"];				
	
	if ( ! empty ($result[0]["Candidate_DisplayMap"])) {
		$pdf_NY_petition->EmblemImagePath = $result[0]["Candidate_DisplayMap"];

	} else {
		$pdf_NY_petition->EmblemFontType = $result[0]["CandidatePartySymbol_Font"];
		$pdf_NY_petition->EmblemFontSize = $result[0]["CandidatePartySymbol_Size"];
		$pdf_NY_petition->PartyEmblem = $result[0]["CandidatePartySymbol_Char"];

	}
	
} else {
	$pdf_NY_petition->party = PrintPartyAdjective($result[0]["CandidateGroup_Party"]);
}

$pdf_NY_petition->PetitionType = $PDFOptions["WitnessType"];
$pdf_NY_petition->county = $result[0]["DataCounty_Name"];
$pdf_NY_petition->ElectionDate =  PrintShortDate($result[0]["Elections_Date"]);
$pdf_NY_petition->AutoFillDate = $PDFOptions["DateForCounter"];
$pdf_NY_petition->BarCode = "S" . $result[0]["CandidateSet_ID"];
if ($result[0]["CandidateGroup_Watermark"] == 'no') { $pdf_NY_petition->Watermark = NULL; }	
//$pdf_NY_petition->Watermark = NULL;

if ( $Variable == "onthefly") { 
		$pdf_NY_petition->Watermark = "Demo Petition / Not Valid";
		$pdf_NY_petition->BarCode = "Demo Petition";
}

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
		#$pdf_NY_petition->AutoFillCounty = "BX";
		$pdf_NY_petition->AutoFillCity = "Bronx, NY";
		$pdf_NY_petition->TypeOfTown = "County";
		$pdf_NY_petition->ShowApt = true;
		break;
		
	case "New York":
		#$pdf_NY_petition->AutoFillCounty = "NY";
		$pdf_NY_petition->AutoFillCity = "New York, NY";
		$pdf_NY_petition->TypeOfTown = "County";
		$pdf_NY_petition->ShowApt = true;
		break;
		
	case "Richmond":
		#$pdf_NY_petition->AutoFillCounty = "RH";
		$pdf_NY_petition->AutoFillCity = "Staten Island, NY";
		$pdf_NY_petition->TypeOfTown = "County";
		$pdf_NY_petition->ShowApt = true;
		break;
		
	case "Queens":
		#$pdf_NY_petition->AutoFillCounty = "QN";
		$pdf_NY_petition->AutoFillCity = "Queens, NY";
		$pdf_NY_petition->TypeOfTown = "County";
		$pdf_NY_petition->ShowApt = true;
		break;

	case "Kings":
		#$pdf_NY_petition->AutoFillCounty = "KG";
		$pdf_NY_petition->AutoFillCity = "New York, NY";
		$pdf_NY_petition->TypeOfTown = "County";
		$pdf_NY_petition->ShowApt = true;
		break;
		
	case "Nassau":
		$pdf_NY_petition->AutoFillCity = ", NY";
		$pdf_NY_petition->TypeOfTown = "Town";
		$pdf_NY_petition->ShowApt = false;
		break;

	default:
		$pdf_NY_petition->TypeOfTown = "Town";
		$pdf_NY_petition->ShowApt = true;
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

WriteStderr($result, "Result Before CandidateGroups_ID");

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
	$pdf_NY_petition->BottonPt = 216;
	$Botton =  216.9;
		
} else if ( $PageSize = "legal") {
	$NumberOfLines = 100 - $pdf_NY_petition->NumberOfCandidates;
	$pdf_NY_petition->BottonPt = 290;
	$Botton =  260.9;
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

