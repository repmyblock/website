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
//$pdf = new PDF('P','mm', $PageSize);

// Faut que je travaille avec K.
if (strlen($k < 20)) {
	// This is just regular K
	preg_match('/([pse])(\d*)/', $k, $matches, PREG_OFFSET_CAPTURE);

	switch ($matches[1][0]) {
		case 'p': $CanPetitionSet_ID = intval($matches[2][0]); break;
		case 's': $CandidatePetitionSet_ID = intval($matches[2][0]); break;
		case 'e': $Candidate_ID = intval($matches[2][0]); break;
	}
} else {
	$CanPetitionSet_ID = trim($_GET["petid"]);
	$CandidatePetitionSet_ID = trim($_GET["setid"]);
	$WaterMarkVoid = trim($_GET["Watermark"]);
}

$WritenSignatureMonth = "March";
$Variable = "demo-CC";
	
if (is_numeric($CanPetitionSet_ID)) { $Variable = "petid"; }
if (is_numeric($CandidatePetitionSet_ID)) { $Variable = "setid"; }
	
if (is_numeric($Candidate_ID)) { $Variable = "person"; }
if (is_numeric($SystemUser_ID)) { $Variable = "person"; }
if ( $WaterMarkVoid == 'yes') { $pdf->Watermark = "VOID - Do not use"; }


switch ($Variable) {
	
  case 'person';
  	$result = $r->ListCandidatePetition($SystemUser_ID, "published");
  	if ( ! empty ($result)) {
  		
  		//print "<PRE>" . print_r($result, 1) . "</PRE>";
  		
			$result[0]["CandidateParty"] = NewYork_PrintPartyAdjective($result[0]["CanPetitionSet_Party"]);
			$result[0]["CandidatePetition_VoterCounty"] = $result[0]["DataCounty_Name"];
			$pdf->BarCode = "P" . $SystemUser_ID;
			$ElectionDate = PrintShortDate($result[0]["Elections_Date"]);
		}
		
		if ( $result[0]["Candidate_Status"] == "published") break;
		goto democc;
		break;
		
	case 'setid';
		$result = $r->ListPetitionSet($CandidatePetitionSet_ID);
		if ( ! empty ($result)) {
			$result[0]["CandidateParty"] = NewYork_PrintPartyAdjective($result[0]["CanPetitionSet_Party"]);
			$result[0]["CandidatePetition_VoterCounty"] = $result[0]["DataCounty_Name"];
			$pdf->BarCode = "S" . $result[0]["CandidatePetitionSet_ID"];
			$ElectionDate = PrintShortDate($result[0]["Elections_Date"]);
		}
		
		if ( $result[0]["Candidate_Status"] == "published") break;
		goto democc;
		break;
							
	case 'petid';
		$result = $r->ListCandidatePetitionSet($CanPetitionSet_ID);
		if ( ! empty ($result)) {
			$result[0]["CandidateParty"] = NewYork_PrintPartyAdjective($result[0]["CanPetitionSet_Party"]);
			$result[0]["CandidatePetition_VoterCounty"] = $result[0]["DataCounty_Name"];
			$pdf->BarCode = $result[0]["CanPetitionSet_ID"];
			$ElectionDate = PrintShortDate($result[0]["Elections_Date"]);
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
		$result[0]["CandidateElection_PetitionText"] = "Member of the Democratic or Republican Party County Committee from the XXth election district in the XXth assembly district Your County, New York State";
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

$pdf->county = $result[0]["CandidatePetition_VoterCounty"];
$pdf->party = $result[0]["CandidateParty"];
$pdf->ElectionDate = $ElectionDate;

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
$pdf->TodayDateText = "Date: " . $WritenSignatureMonth . " _______ , 2021";
$pdf->County = $result[0]["CandidatePetition_VoterCounty"];
$pdf->City = "City of New York";

$pdf->City = "____________________"; 
$pdf->County = "__________________"; 

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
	$pdf->Cell(38, 0, $Counter  . ". ___ / ___ / " . date("Y"), 0, 0, 'L', 0);	
	
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
	$pdf->SetXY( 41,  $YLocation + 0.8);
	$pdf->Write(0, "Print your name here:");

	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0);
	
	$pdf->SetXY( 6,  $YLocation - 4 );
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(38, 0, $Counter . ". ___ / ___ / ". date("Y"), 0, 0, 'L', 0);

	$pdf->SetY($YLocation+0.8);	
		
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

