<?php
//date_default_timezone_set('America/New_York'); 

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/NYS/petition.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/script88/PDF_Code128.php';

$r = new OutragedDems();

$PageSize = "letter";
$pdf = new PDF_Multi('P','mm', $PageSize);
//$pdf = new PDF('P','mm', $PageSize);

// Faut que je travaille avec K.
if (strlen($k < 20)) {
	// This is just regular K
	preg_match('/([pseN])Y?(\d*)/', $k, $matches, PREG_OFFSET_CAPTURE);

	switch ($matches[1][0]) {
		case 'p': $CanPetitionSet_ID = intval($matches[2][0]); break;
		case 's': $CandidatePetitionSet_ID = intval($matches[2][0]); break;
		case 'e': $Candidate_ID = intval($matches[2][0]); break;
		case 'N': $NYSVoters = intval($matches[2][0]); break;
	}
} else {
	$CanPetitionSet_ID = trim($_GET["petid"]);
	$CandidatePetitionSet_ID = trim($_GET["setid"]);
	$WaterMarkVoid = trim($_GET["Watermark"]);
}

if (! empty ($NYSVoters)) {
	echo "Need to fish the rest: $NYSVoters<BR>";	
	$result = $r->ListCandidateByNYS("NY" . $NYSVoters, "1369");
	print "<PRE>" . print_r($result, 1) . "</PRE>";

}

$WritenSignatureMonth = date("F");
$WritenSignatureYear = date("Y");
$Variable = "demo-CC";
$WaterMarkVoid = 'yes';
	
if (is_numeric($CanPetitionSet_ID)) { $Variable = "petid"; }
if (is_numeric($CandidatePetitionSet_ID)) { $Variable = "setid"; }
	
if (is_numeric($Candidate_ID)) { $Variable = "person"; }
if (is_numeric($SystemUser_ID)) { $Variable = "person"; }
if ( $WaterMarkVoid == 'yes') { $pdf->Watermark = "VOID - Do not use"; }


switch ($Variable) {
	
  case 'person':
  	$result = $r->ListCandidatePetition($SystemUser_ID, "published");
  	if ( ! empty ($result)) {
  	
  		
			$result[0]["CandidateParty"] = NewYork_PrintPartyAdjective($result[0]["CanPetitionSet_Party"]);
			$result[0]["CandidatePetition_VoterCounty"] = $result[0]["DataCounty_Name"];
			$pdf->BarCode = "P" . $SystemUser_ID;
			$ElectionDate = PrintShortDate($result[0]["Elections_Date"]);
		}
		
		if ( $result[0]["Candidate_Status"] == "published") break;
		goto democc;
		break;
		
	case 'setid':
	
		$result = $r->ListPetitionSet($CandidatePetitionSet_ID);
		
		//print "<PRE>" . print_r($result, 1) . "</PRE>";
		//exit();
		
		if ( ! empty ($result)) {
			$result[0]["CandidateParty"] = NewYork_PrintPartyAdjective($result[0]["CanPetitionSet_Party"]);
			$result[0]["CandidatePetition_VoterCounty"] = $result[0]["DataCounty_Name"];
			$pdf->BarCode = "S" . $result[0]["CandidatePetitionSet_ID"];
			$ElectionDate = PrintShortDate($result[0]["Elections_Date"]);
		}
		
		// Check that all answer are set to no.
		$FinalWaterMark = "no";
		foreach ($result as $var) {
			if ( $var["CanPetitionSet_Watermark"] == "yes" ) { $FinalWaterMark = 'yes'; }
		}
		if ( $FinalWaterMark == 'no') { $WaterMarkVoid = NULL; $pdf->Watermark = NULL; }
		
		
		if ( $result[0]["Candidate_Status"] == "published") break;
		goto democc;
		break;
							
	case 'petid':
		$result = $r->ListCandidatePetitionSet($CanPetitionSet_ID);
		
		if ( ! empty ($result)) {
			$result[0]["CandidateParty"] = NewYork_PrintPartyAdjective($result[0]["CanPetitionSet_Party"]);
			$result[0]["CandidatePetition_VoterCounty"] = $result[0]["DataCounty_Name"];
			$pdf->BarCode = "P" . $result[0]["CanPetitionSet_ID"];
			$ElectionDate = PrintShortDate($result[0]["Elections_Date"]);
			if ( $result[0]["CanPetitionSet_Watermark"] == 'no' ) { $WaterMarkVoid = NULL; $pdf->Watermark = NULL; }
		}
	
		if ( $result[0]["Candidate_Status"] == "published") break;
		
	case 'demo-single':
		demosingle:
		$result[0]["CanPetitionSet_ID"] = 1;
		$result[0]["CandidateElection_Number"] = 1;
		$result[0]["CandidateElection_PositionType"] = "demo";
		$result[0]["Candidate_DispName"] = "Your name here";
		$result[0]["CandidateElection_PetitionText"] = "The election type here";
		$result[0]["Candidate_DispResidence"] = "Your address here";
		$result[0]["CandidateWitness_FullName"] = "Committee to replace here";
		$result[0]["CandidateWitness_Residence"] = "Address of committee person";
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
		$result[0]["CandidateElection_PetitionText"] = "Member of the Democratic Party County Committee from the XXth election district in the XXth assembly district Your County, New York State";
		$result[0]["Candidate_DispResidence"] = "Your address here";
		// $result[0]["CandidateWitness_FullName"] = "Committee to replace here";
		// $result[0]["CandidateWitness_Residence"] = "Address of committee person";
		$result[0]["CandidatePetition_VoterCounty"] = "a New York City";
		$result[0]["CandidateParty"] = "Democratic or Republican";
		$pdf->Watermark = "Demo Petition / Not Valid";
		$pdf->BarCode = "Demo Petition";
		$pdf->DemoPrint = "true";
		break;	
}


if ( ! empty ($URIEncryptedString["EmptyAddress"])) { $EmptyAddress = $URIEncryptedString["EmptyAddress"]; }
if ( ! empty ($URIEncryptedString["EmptyCounty"])) { $EmptyCounty = $URIEncryptedString["EmptyCounty"]; }

$pdf->county = $result[0]["CandidatePetition_VoterCounty"];

if ( ! empty ($result[0]["Candidate_FullPartyName"])) {
	$pdf->PetitionType = "independent";
	$pdf->party = $result[0]["Candidate_FullPartyName"];
	$pdf->ElectionDate = date("jS \of F Y", strtotime($result[0]["Elections_Date"]));
	$pdf->EmblemFontType = $result[0]["PartySymbol_Font"];
	$pdf->EmblemFontSize = $result[0]["PartySymbol_Size"];
	$pdf->PartyEmblem = $result[0]["PartySymbol_Char"];
	
	//echo "<PRE>" . print_r($result, 1) . "</PRE>";
	//exit();
	
} else {
	$pdf->party = $result[0]["CandidateParty"];
	$pdf->ElectionDate = $ElectionDate;
}




#print "<PRE>" . print_r($result, 1) . "</PRE>";
#exit();

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
			$PetitionData[$var["CanPetitionSet_ID"]]["TotalPosition"] = $var["CandidateElection_Number"];
			$PetitionData[$var["CanPetitionSet_ID"]]["PositionType"]	= $var["CandidateElection_PositionType"];
			$PetitionData[$var["CanPetitionSet_ID"]]["CandidateName"]	= $var["Candidate_DispName"];
			$PetitionData[$var["CanPetitionSet_ID"]]["CandidatePositionName"]	= $var["CandidateElection_PetitionText"];
			$PetitionData[$var["CanPetitionSet_ID"]]["CandidateResidence"] = $var["Candidate_DispResidence"];
			if ( ! empty($var["CandidateWitness_FullName"])) {					
				$PetitionData[$var["CanPetitionSet_ID"]]["Witness_FullName"][$var["CandidateWitness_ID"]] = $var["CandidateWitness_FullName"];
				$PetitionData[$var["CanPetitionSet_ID"]]["Witness_Residence"][$var["CandidateWitness_ID"]] = $var["CandidateWitness_Residence"];
			}
		}
	}
}

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
				
				if ( ! empty ($key["Witness_FullName"])) {
					$pdf->Appointments[$TotalCandidates] = "";
					$comma_first = 0;
					foreach ($key["Witness_FullName"] as $klo => $vir) {
						if ($comma_first == 1) {
							$pdf->Appointments[$TotalCandidates] .= ", ";
						}
						$pdf->Appointments[$TotalCandidates] .= $vir . ", " . $key["Witness_Residence"][$klo];						
						$comma_first = 1;
					}						
				}
				$TotalCandidates++;	
			
			}
		}
	}
}

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
//$pdf->WitnessName = "________________________________________"; 
//$pdf->WitnessResidence = "_______________________________________________________"; 

$pdf->TodayDateText = "Date: " . date("F _________ , Y"); 
$pdf->TodayDateText = "Date: " . $WritenSignatureMonth . " _______, " . $WritenSignatureYear;
$pdf->County = $result[0]["CandidatePetition_VoterCounty"];
$pdf->City = "City of New York";

$pdf->City = "____________________"; 
$pdf->County = "__________________"; 

if ( $PageSize == "letter") {
	$NumberOfLines = 13 - $pdf->NumberOfCandidates;
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
	$pdf->Line($pdf->Line_Left, $YLocation + 2, $pdf->Line_Right, $YLocation + 2);
	
	$YLocation += 16; // This makes the box bigger
	$pdf->SetXY($pdf->Line_Left, $YLocation - 4);
	
	$pdf->Line($pdf->Line_Left + 36, $YLocation - 4.5, $pdf->Line_Right - 91, $YLocation - 4.5);
	


	$pdf->SetFont('Arial',"B",10);
	$pdf->SetXY( 40,  $YLocation - 1);
	$pdf->Cell(38, 0, $Name[$i], 0, 0, 'L', 0);


	$pdf->SetFont('Arial','',14);
	$pdf->SetXY( 120,  $YLocation - 10);
	$pdf->MultiCell(70, 5, $Address[$i], 0, 'L', 0);

	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY( 190,  $YLocation - 6);
	$pdf->Cell(38, 0, $County[$i], 0, 0, 'L', 0);


	$pdf->SetXY( 41,  $YLocation - 1.8);	
	

	
	
	$pdf->SetXY( 6,  $YLocation - 4 );
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(38, 0, $Counter . ". " . $WritenSignatureMonth . " ___ ". $WritenSignatureYear, 0, 0, 'L', 0);

	$pdf->SetY($YLocation + 0.8);	
	
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
	
	$YLocation += 16; // This makes the box bigger
	$pdf->SetXY($pdf->Line_Left, $YLocation - 4);
	
	$pdf->Line($pdf->Line_Left + 36, $YLocation - 4.5, $pdf->Line_Right - 91, $YLocation - 4.5);
	
	$pdf->SetTextColor(220);

	$pdf->SetFont('Arial','I',20);
	$pdf->SetXY( 72,  $YLocation - 9);
	$pdf->Write(0, 'Sign here');
	
	$pdf->SetTextColor(190);

	$pdf->SetFont('Arial','I',8);		
	$pdf->SetXY( 41,  $YLocation - 1.8);
	$pdf->Write(0, "Print your name here:");

	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0);
	
	$pdf->SetXY( 6,  $YLocation - 4 );
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(38, 0, $Counter . ". " . $WritenSignatureMonth . " ___ ". $WritenSignatureYear, 0, 0, 'L', 0);
		
	if ( ! empty ($EmptyAddress)) {
		$pdf->SetFont('Arial','',14);
		$pdf->SetXY( 120,  $YLocation - 10);
		$pdf->MultiCell(70, 5, $EmptyAddress, 0, 'L', 0);
	}

	if (! empty ($EmptyCounty)) {
		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY( 190,  $YLocation - 6);
		$pdf->Cell(38, 0, $EmptyCounty, 0, 0, 'L', 0);
	}

	$pdf->SetY($YLocation + 0.8);	
		
	if ($pdf->GetY() > 218) {
		$done = 0;
	} else {
		$pdf->SetXY($pdf->Line_Left, $YLocation);				
	}
	
}

$pdf->Output("I", $Petition_FileName);

function Redact ($string) {
	return str_repeat("X", strlen($string)); ;
	return $string;
}

?>

