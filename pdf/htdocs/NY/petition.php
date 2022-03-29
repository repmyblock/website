<?php
//date_default_timezone_set('America/New_York'); 

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/NY/petition_class.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/script88/PDF_Code128.php';

$r = new OutragedDems();
$PageSize = "letter";
$pdf = new PDF_Multi('P','mm', $PageSize);

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

$pdf->Watermark = "VOID - Do not use"; 
$WritenSignatureMonth = "March";
$Variable = "demo-CC";

// Setup for empty petition.
$pdf->WitnessName = "________________________________________"; 
$pdf->WitnessResidence = "_______________________________________________________";
$pdf->TodayDateText = "Date: " . date("F _________ , Y"); 
$pdf->TodayDateText = "Date: " . $WritenSignatureMonth . " _______ , " . date("Y");
$pdf->City = "____________"; 
$pdf->County = "________"; 
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
			$pdf->BarCode = "P" . $Candidate_ID;
			$ElectionDate = PrintShortDate($result[0]["Elections_Date"]);
		}
		
		if ($result[0]["Candidate_Watermark"] == 'no') { $pdf->Watermark = NULL; }	
		else {
			$pdf->Watermark = "VOID - Do not use " . $result[0]["Candidate_Status"]; 
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
	  			$pdf->PetitionType = "independent";
	  			$pdf->EmblemFontType = $result[0]["CandidatePartySymbol_Font"];
					$pdf->EmblemFontSize = $result[0]["CandidatePartySymbol_Size"];
					$pdf->PartyEmblem = $result[0]["CandidatePartySymbol_Char"];
					$result[$i]["CandidateParty"] = $result[0]["Candidate_FullPartyName"];				
	  		} else {
	  			$result[$i]["CandidateParty"] = PrintPartyAdjective($result[0]["Candidate_Party"]);	
	  		}
	  		
				$result[$i]["CandidatePetition_VoterCounty"] = $result[0]["DataCounty_Name"];
			}
			
			$pdf->BarCode = "S" . $CandidateSet_ID;
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
			$pdf->BarCode = $result[0]["CanPetitionSet_ID"];
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
		$pdf->Watermark = "Demo Petition / Not Valid";
		$pdf->BarCode = "Demo Petition";
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
		$pdf->Watermark = "Demo Petition / Not Valid";
		$pdf->BarCode = "Demo Petition";
		$pdf->DemoPrint = "true";
		break;
}

$pdf->county = $result[0]["CandidatePetition_VoterCounty"];
$pdf->party = $result[0]["CandidateParty"];
$pdf->ElectionDate =  PrintShortDate($result[0]["Elections_Date"]);

// This is for the Custom Data stuff

if ( ! empty ($URIEncryptedString["CustomData"] )) {
	$DateForCounter = $URIEncryptedString["CustomDataDate"]; 
	$pdf->WitnessName = $URIEncryptedString["CustomDataWitnessName"];
	$pdf->WitnessResidence = $URIEncryptedString["CustomDataWitnessResidence"];
	$pdf->City = $URIEncryptedString["CustomDataCity"];
	$pdf->County = $URIEncryptedString["CustomDataCounty"];
	//$pdf->County = $result[0]["CandidatePetition_VoterCounty"];
	$MyCustomAddress = $URIEncryptedString["CustomDataCustomAddress"];
	$MyCustomCounty = $URIEncryptedString["CustomDataCustomCounty"];
	$MyCustomCountyFontSize = $URIEncryptedString["CustomDataCountyFontSize"];
}

// This is to control the TOWN or COUNTY depending of where the petition
// is circulated.
switch ($pdf->county) {
	case "Bronx":
	case "New York":
	case "Richmond":
	case "Queens":
	case "Kings":
		$pdf->TypeOfTown = "County";
		break;

	default:
		$pdf->TypeOfTown = "Town";
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
				$pdf->Candidate[$TotalCandidates] =  $key["CandidateName"];	
				$pdf->RunningFor[$TotalCandidates] = $key["CandidatePositionName"];
				$pdf->Residence[$TotalCandidates] = $key["CandidateResidence"];
				$pdf->PositionType[$TotalCandidates] = $key["PositionType"];
				
				if ( ! empty ($key["ComReplace_FullName"])) {
					$pdf->Appointments[$TotalCandidates] = "";
					$comma_first = 0;
					foreach ($key["ComReplace_FullName"] as $klo => $vir) {
						if ($comma_first == 1) {
							$pdf->Appointments[$TotalCandidates] .= ", ";
						}
						$pdf->Appointments[$TotalCandidates] .= $vir . ", " . $key["ComReplace_Residence"][$klo];						
						$comma_first = 1;
					}						
				}
				$TotalCandidates++;	
			
			}
		}
	}
}

WriteStderr($TotalCandidates, "Total candidates");



$pdf->NumberOfCandidates = $TotalCandidates;

if ($pdf->NumberOfCandidates > 1) { 
	$pdf->PluralCandidates = "s"; 
	$pdf->PluralAcandidates = "";	
} else { 
	$pdf->PluralCandidates = "";
	$pdf->PluralAcandidates = "a";	
}

$pdf->RunningForHeading["electoral"] = "PUBLIC OFFICE" . strtoupper($pdf->PluralCandidates);
$pdf->RunningForHeading["party"] = "PARTY POSITION" . strtoupper($pdf->PluralCandidates);
$pdf->RunningForHeading["demo"] = "A PARTY POSITION OR A PUBLIC OFFICE" . strtoupper($pdf->PluralCandidates);


$pdf->CandidateNomination = "nomination of such party for public office";
// Add or the if both.	
$pdf->CandidateNomination .= " or for election to a party position of such party.";

// Need to fix that.

if ( $PageSize == "letter") {
	$NumberOfLines = 12 - $pdf->NumberOfCandidates;
	$pdf->BottonPt = 240.4;	
	$pdf->BottonPt = 232;
	$Botton =  216.9;
	
} else if ( $PageSize = "legal") {
	$NumberOfLines = 23;
	$pdf->BottonPt = 236;
}

$pdf->AliasNbPages();
$pdf->SetTopMargin(8);
$pdf->SetLeftMargin(5);
$pdf->SetRightMargin(5);
$pdf->SetAutoPageBreak(1, 38);
$pdf->AddPage();

// This is the meat of the petition.	
$Counter = 0;

// Need to calculate the number of empty line.

$TotalCountName = count($Name);

for ($i = 0; $i < $TotalCountName; $i++) {
	$Counter++;
	$YLocation = $pdf->GetY();

	$pdf->SetFont('Arial', '', 10);
	$pdf->SetY($YLocation - 13);
	$pdf->Cell(38, 0, $Counter . ". " . $DateForCounter, 0, 0, 'L', 0);	
	
	$pdf->SetX(195);
	$pdf->Cell(38, 0, $County[$i], 0, 0, 'L', 0);
	
	$pdf->SetXY(41, $YLocation + 6);
	$pdf->Cell(78, 0, $Name[$i], 0,'C', 0);
	
	$pdf->SetXY(121, $YLocation - 4);
	$pdf->MultiCell(73, 2.8, $Address[$i], 0, 'L', 0);

	$pdf->Line(5, $YLocation + 8, 212.5, $YLocation + 8);
	$pdf->SetY($YLocation);
	
	$pdf->Ln(13); 
	
	if ( $Counter > $NumberOfLines ) {
		$Counter = 0;
		$pdf->AddPage();
	}	
}

// This is the last 
// $pdf->YLocation 

$done = 1;	
while ( $done == 1) {
	$Counter++;
	$YLocation = $pdf->GetY();
	
	// Above line.	
	$pdf->Line($pdf->Line_Left, $YLocation + 2, $pdf->Line_Right, $YLocation + 2);
	
	$YLocation += 13;
	$pdf->SetXY($pdf->Line_Left, $YLocation - 4);
	
	$pdf->Line($pdf->Line_Left + 36, $YLocation - 1.5, $pdf->Line_Right - 91, $YLocation - 1.5);
	
	$pdf->SetTextColor(220);

	$pdf->SetFont('Arial','I',20);
	$pdf->SetXY( 72,  $YLocation - 6);
	$pdf->Write(0, 'Sign here');
	
	$pdf->SetTextColor(190);

	$pdf->SetFont('Arial','I',8);		
	$pdf->SetXY( 41,  $YLocation + 0.4);
	$pdf->Write(0, "Print your name here:");

	
	$pdf->SetTextColor(0);
	
 	if ( ! empty ($MyCustomCounty)) {
		$pdf->SetFont('Arial','B', $MyCustomCountyFontSize);
		$pdf->SetXY(195, $YLocation - 4);
		$pdf->Cell(38, 0, $MyCustomCounty, 0, 0, 'L', 0);
	}
	
	
	if ( ! empty ($MyCustomAddress)) {
		$pdf->SetFont('Arial','',12);
		$pdf->SetXY(121, $YLocation - 9);
		$pdf->MultiCell(73, 5, $MyCustomAddress, 0, 'L', 0);
	}
	
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY( 6,  $YLocation - 4 );
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(38, 0, $Counter . ". " . $DateForCounter, 0, 0, 'L', 0);

	$pdf->SetY($YLocation+0.8);	
		
	if ($pdf->GetY() > 218) {
		$done = 0;
	} else {
		$pdf->SetXY($pdf->Line_Left, $YLocation);				
	}
	
}

$pdf->Line($pdf->Line_Left, $YLocation + 2, $pdf->Line_Right, $YLocation + 2);
$pdf->LocationOfFooter = $YLocation + 6.5;
$pdf->BottonPt = $YLocation + 1.9;

$pdf->Output("I", $Petition_FileName);

function Redact ($string) {
	return str_repeat("X", strlen($string)); ;
	return $string;
}

?>

