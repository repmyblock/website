<?php
//date_default_timezone_set('America/New_York'); 

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/voterlist_class.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/NY/petition_class.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/script88/PDF_Code128.php';


$DB_Type = "DBRaw";

$r = new OutragedDems();
$PageSize = "letter";
$pdfPetition = new PDF_Petition('P','mm', $PageSize);
$pdfVoterList = new PDF_VoterList('P', 'mm', $PageSize);


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

$pdfPetition->Watermark = "VOID - Do not use"; 
$WritenSignatureMonth = date("F");
$Variable = "demo-CC";

// Setup for empty petition.
$pdfPetition->WitnessName = "________________________________________"; 
$pdfPetition->WitnessResidence = "_______________________________________________________";
$pdfPetition->TodayDateText = "Date: " . date("F _________ , Y"); 
$pdfPetition->TodayDateText = "Date: " . $WritenSignatureMonth . " _______ , " . date("Y");
$pdfPetition->City = "____________"; 
$pdfPetition->County = "________"; 
$DateForCounter = " ___ / ___ / " . date("Y");
$DateForCounter = date("m") . " / ____ / " . date("Y"); 

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
	  	$result = $r->ListCandidatePetition($Candidate_ID);	  	
	  } else {
	  	$result = $r->ListCandidatePetition($Candidate_ID, "published");
	  	WriteStderr($result, "PDF Petition RESULT IN Person");
	  }
	  
		$result[0]["CandidateGroup_ID"] = 1;
	  
  	if ( ! empty ($result)) {
  		for ($i = 0; $i < count($result); $i++) { 	 		
	  		$result[$i]["CandidateSet_ID"] = 1;	
				$result[$i]["CandidateParty"] = PrintPartyAdjective($result[0]["Candidate_Party"]);
				$result[$i]["CandidatePetition_VoterCounty"] = $result[0]["DataCounty_Name"];
			}
			$pdfPetition->BarCode = "P" . $Candidate_ID;
			$ElectionDate = PrintShortDate($result[0]["Elections_Date"]);
		}
		
		if ($result[0]["Candidate_Watermark"] == 'no') { $pdf->Watermark = NULL; }	
		else {
			$pdfPetition->Watermark = "VOID - Do not use " . $result[0]["Candidate_Status"]; 
		}

		if ( $result[0]["Candidate_Status"] == "published" || $URIEncryptedString["PendingBypass"] == "yes") break;
		goto democc;
		break;
		
	case 'setid';
	 	if ( $URIEncryptedString["PendingBypass"] == "yes" ) {
	  	$result = $r->ListPetitionGroup($CandidateSet_ID); 	
	  } else {
	  	$result = $r->ListPetitionGroup($CandidateSet_ID, "published");
	  }
	  
	  WriteStderr($result, "Result Set ID");
	
		if ( ! empty ($result)) {
			for ($i = 0; $i < count($result); $i++) {
	  		$result[$i]["CandidateSet_ID"] = 1;
	  		if ( $result[0]["Candidate_Party"] == "BLK" ) {
	  			$pdfPetition->PetitionType = "independent";
	  			$pdfPetition->EmblemFontType = $result[0]["CandidatePartySymbol_Font"];
					$pdfPetition->EmblemFontSize = $result[0]["CandidatePartySymbol_Size"];
					$pdfPetition->PartyEmblem = $result[0]["CandidatePartySymbol_Char"];
					$result[$i]["CandidateParty"] = $result[0]["Candidate_FullPartyName"];				
	  		} else {
	  			$result[$i]["CandidateParty"] = PrintPartyAdjective($result[0]["Candidate_Party"]);	
	  		}
	  		
				$result[$i]["CandidatePetition_VoterCounty"] = $result[0]["DataCounty_Name"];
			}
			
			$pdfPetition->BarCode = "S" . $CandidateSet_ID;
			$ElectionDate = PrintShortDate($result[0]["Elections_Date"]);		
			if ($result[0]["CandidateGroup_Watermark"] == 'no') { $pdf->Watermark = NULL; }	
		}
		
		if ( $result[0]["Candidate_Status"] == "published" || $URIEncryptedString["PendingBypass"] == "yes") break;
		goto democc;
		break;
							
	case 'petid';
		$result = $r->ListCandidatePetitionSet($CanPetitionSet_ID);
		if ( ! empty ($result)) {
			$result[0]["CandidateParty"] = PrintPartyAdjective($result[0]["CanPetitionSet_Party"]);
			$result[0]["CandidatePetition_VoterCounty"] = $result[0]["DataCounty_Name"];
			$pdfPetition->BarCode = $result[0]["CanPetitionSet_ID"];
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
		$pdfPetition->Watermark = "Demo Petition / Not Valid";
		$pdfPetition->BarCode = "Demo Petition";
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
		$pdfPetition->Watermark = "Demo Petition / Not Valid";
		$pdfPetition->BarCode = "Demo Petition";
		$pdfPetition->DemoPrint = "true";
		break;
}

$pdfPetition->county = $result[0]["CandidatePetition_VoterCounty"];
$pdfPetition->party = $result[0]["CandidateParty"];
$pdfPetition->ElectionDate =  PrintShortDate($result[0]["Elections_Date"]);

// This is for the Custom Data stuff

if ( ! empty ($URIEncryptedString["CustomData"] )) {
	$DateForCounter = $URIEncryptedString["CustomDataDate"]; 
	$pdfPetition->WitnessName = $URIEncryptedString["CustomDataWitnessName"];
	$pdfPetition->WitnessResidence = $URIEncryptedString["CustomDataWitnessResidence"];
	$pdfPetition->City = $URIEncryptedString["CustomDataCity"];
	$pdfPetition->County = $URIEncryptedString["CustomDataCounty"];
	//$pdf->County = $result[0]["CandidatePetition_VoterCounty"];
	$MyCustomAddress = $URIEncryptedString["CustomDataCustomAddress"];
	$MyCustomCounty = $URIEncryptedString["CustomDataCustomCounty"];
	$MyCustomCountyFontSize = $URIEncryptedString["CustomDataCountyFontSize"];
}

// This is to control the TOWN or COUNTY depending of where the petition
// is circulated.
switch ($pdfPetition->county) {
	case "Bronx":
	case "New York":
	case "Richmond":
	case "Queens":
	case "Kings":
		$pdfPetition->TypeOfTown = "County";
		break;

	default:
		$pdfPetition->TypeOfTown = "Town";
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
				$pdfPetition->Candidate[$TotalCandidates] =  $key["CandidateName"];	
				$pdfPetition->RunningFor[$TotalCandidates] = $key["CandidatePositionName"];
				$pdfPetition->Residence[$TotalCandidates] = $key["CandidateResidence"];
				$pdfPetition->PositionType[$TotalCandidates] = $key["PositionType"];
				
				if ( ! empty ($key["ComReplace_FullName"])) {
					$pdfPetition->Appointments[$TotalCandidates] = "";
					$comma_first = 0;
					foreach ($key["ComReplace_FullName"] as $klo => $vir) {
						if ($comma_first == 1) {
							$pdfPetition->Appointments[$TotalCandidates] .= ", ";
						}
						$pdfPetition->Appointments[$TotalCandidates] .= $vir . ", " . $key["ComReplace_Residence"][$klo];						
						$comma_first = 1;
					}						
				}
				$TotalCandidates++;	
			
			}
		}
	}
}

WriteStderr($TotalCandidates, "Total candidates");



$pdfPetition->NumberOfCandidates = $TotalCandidates;

if ($pdfPetition->NumberOfCandidates > 1) { 
	$pdfPetition->PluralCandidates = "s"; 
	$pdfPetition->PluralAcandidates = "";	
} else { 
	$pdfPetition->PluralCandidates = "";
	$pdfPetition->PluralAcandidates = "a";	
}

$pdfPetition->RunningForHeading["electoral"] = "PUBLIC OFFICE" . strtoupper($pdf->PluralCandidates);
$pdfPetition->RunningForHeading["party"] = "PARTY POSITION" . strtoupper($pdf->PluralCandidates);
$pdfPetition->RunningForHeading["demo"] = "A PARTY POSITION OR A PUBLIC OFFICE" . strtoupper($pdf->PluralCandidates);


$pdfPetition->CandidateNomination = "nomination of such party for public office";
// Add or the if both.	
$pdfPetition->CandidateNomination .= " or for election to a party position of such party.";

// Need to fix that.

if ( $PageSize == "letter") {
	$NumberOfLines = 12 - $pdf->NumberOfCandidates;
	$pdfPetition->BottonPt = 240.4;	
	$pdfPetition->BottonPt = 232;
	$Botton =  216.9;
	
} else if ( $PageSize = "legal") {
	$NumberOfLines = 23;
	$pdfPetition->BottonPt = 236;
}

$pdfPetition->AliasNbPages();
$pdfPetition->SetTopMargin(8);
$pdfPetition->SetLeftMargin(5);
$pdfPetition->SetRightMargin(5);
$pdfPetition->SetAutoPageBreak(1, 38);
$pdfPetition->AddPage();

// This is the meat of the petition.	
$Counter = 0;

// Need to calculate the number of empty line.

$TotalCountName = count($Name);

for ($i = 0; $i < $TotalCountName; $i++) {
	$Counter++;
	$YLocation = $pdfPetition->GetY();

	$pdfPetition->SetFont('Arial', '', 10);
	$pdfPetition->SetY($YLocation - 13);
	$pdfPetition->Cell(38, 0, $Counter . ". " . $DateForCounter, 0, 0, 'L', 0);	
	
	$pdfPetition->SetX(195);
	$pdfPetition->Cell(38, 0, $County[$i], 0, 0, 'L', 0);
	
	$pdfPetition->SetXY(41, $YLocation + 6);
	$pdfPetition->Cell(78, 0, $Name[$i], 0,'C', 0);
	
	$pdfPetition->SetXY(121, $YLocation - 4);
	$pdfPetition->MultiCell(73, 2.8, $Address[$i], 0, 'L', 0);

	$pdfPetition->Line(5, $YLocation + 8, 212.5, $YLocation + 8);
	$pdfPetition->SetY($YLocation);
	
	$pdfPetition->Ln(13); 
	
	if ( $Counter > $NumberOfLines ) {
		$Counter = 0;
		$pdfPetition->AddPage();
	}	
}

// This is the last 
// $pdf->YLocation 

$done = 1;	
while ( $done == 1) {
	$Counter++;
	$YLocation = $pdfVoterList->GetY();
	
	// Above line.	
	$pdfPetition->Line($pdfPetition->Line_Left, $YLocation + 2, $pdfPetition->Line_Right, $YLocation + 2);
	
	$YLocation += 13;
	$pdfPetition->SetXY($pdfPetition->Line_Left, $YLocation - 4);
	
	$pdfPetition->Line($pdfPetition->Line_Left + 36, $YLocation - 1.5, $pdfPetition->Line_Right - 91, $YLocation - 1.5);
	
	$pdfPetition->SetTextColor(220);

	$pdfPetition->SetFont('Arial','I',20);
	$pdfPetition->SetXY( 72,  $YLocation - 6);
	$pdfPetition->Write(0, 'Sign here');
	
	$pdfPetition->SetTextColor(190);

	$pdfPetition->SetFont('Arial','I',8);		
	$pdfPetition->SetXY( 41,  $YLocation + 0.4);
	$pdfPetition->Write(0, "Print your name here:");

	
	$pdfPetition->SetTextColor(0);
	
 	if ( ! empty ($MyCustomCounty)) {
		$pdfPetition->SetFont('Arial','B', $MyCustomCountyFontSize);
		$pdfPetition->SetXY(195, $YLocation - 4);
		$pdfPetition->Cell(38, 0, $MyCustomCounty, 0, 0, 'L', 0);
	}
	
	
	if ( ! empty ($MyCustomAddress)) {
		$pdfPetition->SetFont('Arial','',12);
		$pdfPetition->SetXY(121, $YLocation - 9);
		$pdfPetition->MultiCell(73, 5, $MyCustomAddress, 0, 'L', 0);
	}
	
	$pdfPetition->SetFont('Arial','',8);
	$pdfPetition->SetXY( 6,  $YLocation - 4 );
	$pdfPetition->SetFont('Arial', '', 10);
	$pdfPetition->Cell(38, 0, $Counter . ". " . $DateForCounter, 0, 0, 'L', 0);

	$pdfPetition->SetY($YLocation+0.8);	
		
	if ($pdfPetition->GetY() > 218) {
		$done = 0;
	} else {
		$pdfPetition->SetXY($pdfPetition->Line_Left, $YLocation);				
	}
	
}

$pdfPetition->Line($pdf->Line_Left, $YLocation + 2, $pdf->Line_Right, $YLocation + 2);
$pdfPetition->LocationOfFooter = $YLocation + 6.5;
$pdfPetition->BottonPt = $YLocation + 1.9;


##################### ADD PAGE FOR THE VOTER LIST

	
	WriteStderr($URIEncryptedString, "URIEncryptedString");
		
	if ($URIEncryptedString["DataDistrict_ID"] > 0) {
		// $voters = $r->ListVotersForDataDistrict($URIEncryptedString["DataDistrict_ID"]);
		//$PreparedFor = $URIEncryptedString["PreparedFor"];
		
		$DataQuery = array("AD" => intval($URIEncryptedString["AD"]), "ED" => intval($URIEncryptedString["ED"]), 
												//"PT" => $URIEncryptedString["Party"]
												);
												
		$voters = $r->SearchInRawNYSFile($DataQuery);
		$PreparedFor = $URIEncryptedString["PreparedFor"];
		$ElectionDate = PrintShortDate($WalkSheetUser["Elections_Date"]);
		
		
		$WalkSheetUser["CandidateElection_DBTable"] = "ADED";
		$WalkSheetUser["CandidateElection_DBTableValue"] = sprintf("%2d%03d", $URIEncryptedString["AD"], $URIEncryptedString["ED"]);
				
		$WalkSheetUser["Candidate_ID"] = $URIEncryptedString["Party"] . $URIEncryptedString["SystemID"];
				
	} else {

		
		$WalkSheetUser = $r->ListCandidatePetition($URIEncryptedString["Candidate_ID"]);
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
		$voters = $r->SearchInRawNYSFile($DataQuery);

		$PreparedFor = $WalkSheetUser["Candidate_DispName"];
		$ElectionDate = PrintShortDate($WalkSheetUser["Elections_Date"]);
	}
	
	$FileTitle = preg_replace('/[^a-zA-Z0-9]/', '', $PreparedFor);
	$Today = date("Ymd_Hi");
	$OutputFilename = "WalkSheet_" . $FileTitle . "_" . $Today . "_" . $WalkSheetUser["CandidateElection_DBTable"] . 
										$WalkSheetUser["CandidateElection_DBTableValue"] . ".pdf";
	
	if (! empty ($voters)) {
		foreach ($voters as $person) {
			if ( ! empty ($person)) {
				switch($DB_Type) {
					case 'DBRaw':		
					
					WriteStderr($person, "person");
										
						$FixedAddress = preg_replace('!\s+!', ' ', $person["ResStreetName"] );
						$FixedApt = strtoupper(preg_replace('!\s+!', '', $person["ResApartment"] ));
						$Address[$FixedAddress][$person["ResHouseNumber"]]["PrintAddress"] = 
													ucwords(strtolower(trim($person["ResHouseNumber"] . " " . 
													$person["ResStreetName"] )));
						$Address[$FixedAddress][$person["ResHouseNumber"]]
										[$FixedApt][$person["Status"]]
										[$person["UniqNYSVoterID"]] =	$person["FirstName"] . " " . 
																																	$person["MiddleName"] . ". " . 
																																	$person["LastName"];
											
						// The reason for this is that the CandidatePetition_ID is unique enough.
		        $Gender[$person["UniqNYSVoterID"]] = $person["Gender"];
		    		$interval = date_diff(date_create(date('Y-m-d')), date_create($person["DOB"]));    		
		    		$Age[$person["UniqNYSVoterID"]] = $interval->y;
					break;
	
				case 'DBNorm':
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
					break;
				
				default:
					$FixedAddress = "You did not select a DB Type\n";
					break;
				}	
			}
		}
	}

	#$PageSize = "letter";
	#$pdf = new PDF('P','mm', $PageSize);
	
	$RestOfLine = "";
	$pdfVoterList->Text_PubDate_XLoc = 153;
	if ( $WalkSheetUser["CandidateElection_DBTable"] = "ADED") {
		preg_match('/(\d\d)(\d\d\d)/', $WalkSheetUser["CandidateElection_DBTableValue"], $Keywords);
		$RestOfLine = " AD: " . intval($Keywords[1]) . " ED: " . intval($Keywords[2]);
		$pdfVoterList->Text_PubDate_XLoc = 133;
	}
	
	$pdfVoterList->Text_PubDate = date("M j, Y \a\\t g:i a") . $RestOfLine;
	$pdfVoterList->Text_CandidateName = $PreparedFor;
	$pdfVoterList->Text_ElectionDate = $ElectionDate;
	$pdfVoterList->Text_PosType = $WalkSheetUser["CandidateElection_PositionType"];
  $pdfVoterList->Text_Party = $WalkSheetUser["CandidateElection_Party"];
  $pdfVoterList->Text_PosText = $WalkSheetUser["CandidateElection_Text"];
 	$pdfVoterList->Text_PosPetText = $WalkSheetUser["CandidateElection_PetitionText"];
  $pdfVoterList->Text_DistricType = $WalkSheetUser["CandidateElection_DBTable"];
  $pdfVoterList->Text_DistricHeading = $WalkSheetUser["CandidateElection_DBTableValue"];
  $pdfVoterList->Text_PetitionSetID = $WalkSheetUser["CandidatePetitionSet_ID"];
   
  $pdfVoterList->LeftText = $pdfVoterList->Text_Party . " CanID:" . $WalkSheetUser["Candidate_ID"];
	$pdfVoterList->RightText =  $pdfVoterList->Text_DistricType . ":" . $pdfVoterList->Text_DistricHeading;
	
	// Insert the logo:
	if ( $PageSize == "letter") {
		$NumberOfLines = 13; $pdfVoterList->BottonPt = 10.4; 
	} else if ( $PageSize = "legal") {
		$NumberOfLines = 23; $pdfVoterList->BottonPt = 236; 
	}

	$pdfVoterList->AliasNbPages();
	$pdfVoterList->SetTopMargin(8);
	$pdfVoterList->SetLeftMargin(5);
	$pdfVoterList->SetRightMargin(5);
	$pdfVoterList->SetAutoPageBreak(1, 10);
	$pdfVoterList->AliasNbPages();
	$pdfVoterList->AddPage();
	
	// This is the meat of the petition.	
  $Counter = 0;
	$ResetApt = 0;
	
	
	$LineLoc = 110; $LineTop = 28;
	$pdfVoterList->Line($LineLoc, $LineTop, $LineLoc, $LineTop + 230);
	$Alternate = 0;
	
	if ( ! empty ($Address)) {
		foreach ($Address as $AddressLine => $ArrayOne) {
			ksort($ArrayOne);
			if ( ! empty ($ArrayOne)) {
				foreach ($ArrayOne as $HomeNumber => $ArrayTwo) {
					ksort($ArrayTwo);
					
					PrintAddress($Alternate, $pdf, $ArrayTwo["PrintAddress"]);
					
					if ( ! empty ($ArrayTwo)) {
						foreach ($ArrayTwo as $ApartementNumber => $ArrayThree) {
							if ( ! empty ($ArrayThree)) {					
								
								// Print Apt if there is one.
								if ( $ApartementNumber != "PrintAddress") {					
									if ( ! empty ($ApartementNumber)) {
										PrintApt($Alternate, $pdfVoterList, $ApartementNumber);
									} else {
										$pdfVoterList->Ln(6);
									}
									$pdfVoterList->SetFont('Arial', '', 10);
		
									// Names and status.
									foreach ($ArrayThree as $Status => $ArrayFour) {
										if (! empty ($ArrayFour)) {
								
											foreach($ArrayFour as $IDToUse => $PersonVoters) {
												
												// This is the page control				
												if ($pdfVoterList->GetY() > 256) {				
																				
													if ($Alternate == 0) {
														$pdfVoterList->SetY($LineTop - 0.5);
														$Alternate = 1;
													} else { 
														$pdfVoterList->AddPage();
														$pdfVoterList->Line($LineLoc, $LineTop, $LineLoc, $LineTop + 230);
														$Alternate = 0;
													} 
												
													PrintAddress($Alternate, $pdfVoterList, $ArrayTwo["PrintAddress"]);
													PrintApt($Alternate, $pdfVoterList, $ApartementNumber);
													
												}
												
												// How far are we from the end?
												$VoterPrintLine = $PersonVoters . " - " . strtoupper($Gender[$IDToUse][0]) . $Age[$IDToUse];
												
												PrintVoterLine($Alternate, $pdfVoterList, $VoterPrintLine, $Status);											
											}
										}	
									}	
								}									
							}
						}					
					}
				}				
			}			
		}
	}
	
$pdfVoterList->Output("I", $OutputFilename);
#$pdfPetition->Output("I", $Petition_FileName);


function PrintAddress($Alternate, $pdf, $PrintAddress) {
	$pdf->Ln(6);
	if ($Alternate == 1) { $pdf->SetX(110); }
	$pdf->SetFont('Arial', 'B', 16);
	$pdf->Write(7, $PrintAddress);	
	$pdf->Ln(2);
}

function PrintApt($Alternate, $pdf, $ApartementNumber) {
	$pdf->Ln(6);
	if ($Alternate == 1) { $pdf->SetX(110); }
	$pdf->SetFont('Arial', '', 12);										
	$pdf->Write(2, "Apartment: " );
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->Write(2, $ApartementNumber);
	$pdf->Ln(6);													
}

function PrintVoterLine($Alternate, $pdf, $VoterPrintLine, $Status) {
	$LenghtString = $pdf->GetStringWidth($VoterPrintLine);
	
	if ($Alternate == 1) { 
		if ($pdf->GetX() + 110 + $LenghtString > 214 ) { $pdf->Ln(5); } 
		$pdf->SetX(110);
	} else {
		if ($pdf->GetX() + $LenghtString > 104 ) { $pdf->Ln(5); }
	}

	$MyGetX = $pdf->GetX();

	$pdf->SetFont('ZapfDingbats','', 15);
	$pdf->Write(1, "o" );												
	$pdf->SetFont('Arial', '', 10);
	$pdf->Write(1, " " );	
	
	if ( $Status == "I") { $pdf->SetTextColor(255, 0, 0); }
	$pdf->Write(1, $VoterPrintLine . "  ");
	if ( $Status == "I") { $pdf->SetTextColor(0); }
}




function Redact ($string) {
	return str_repeat("X", strlen($string)); ;
	return $string;
}

?>

