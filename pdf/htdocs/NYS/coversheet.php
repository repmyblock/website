<?php
	//date_default_timezone_set('America/New_York'); 
		
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/coversheet_class.php';
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	$r = new OutragedDems();

if (strlen($k < 20)) {
	// This is just regular K
	preg_match('/([pseN])Y?(\d*)/', $k, $matches, PREG_OFFSET_CAPTURE);

	switch ($matches[1][0]) {
		case 'p': $CanPetitionSet_ID = intval($matches[2][0]); break;
		case 's': $CandidatePetitionSet_ID = intval($matches[2][0]); break;
			case 'e': $Candidate_ID = intval($matches[2][0]); $result = $r->GetBOEIDFromCandidateID($Candidate_ID); break;
		case 'N': $NYSVoters = intval($matches[2][0]); break;
	}
} 

	//$result = $r->ListCandidatePetitionSet($CanPetitionSet_ID);
		
	//	print "<PRE>" . print_r($result, 1) . "</PRE>";
		//exit();
	/*	
	if ( ! empty ($result)) {
			$result[0]["CandidateParty"] = NewYork_PrintPartyAdjective($result[0]["CanPetitionSet_Party"]);
			$result[0]["CandidatePetition_VoterCounty"] = $result[0]["DataCounty_Name"];
			$pdf->BarCode = "S" . $result[0]["CandidatePetitionSet_ID"];
			$ElectionDate = PrintShortDate($result[0]["Elections_Date"]);
		}
		*/
		
	$var = $result[0];
	$PetitionData[$var["CanPetitionSet_ID"]]["TotalPosition"] = $var["CandidateElection_Number"];
	$PetitionData[$var["CanPetitionSet_ID"]]["PositionType"]	= $var["CandidateElection_PositionType"];
	$PetitionData[$var["CanPetitionSet_ID"]]["CandidateName"]	= $var["Candidate_DispName"];
	$PetitionData[$var["CanPetitionSet_ID"]]["CandidatePositionName"]	= $var["CandidateElection_PetitionText"];
	$PetitionData[$var["CanPetitionSet_ID"]]["CandidateResidence"] = $var["Candidate_DispResidence"];
	$PetitionData[$var["CanPetitionSet_ID"]]["Witness_FullName"][$var["CandidateWitness_ID"]] = $var["CandidateWitness_FullName"];
	$PetitionData[$var["CanPetitionSet_ID"]]["Witness_Residence"][$var["CandidateWitness_ID"]] = $var["CandidateWitness_Residence"];

	$PageSize = "letter";
	$pdf = new PDF('P','mm', $PageSize);

	if (
			$result[0]["CandidatePetition_VoterCounty"] == "New York" || 
			$result[0]["CandidatePetition_VoterCounty"] == "Richmond"
		) {
		$pdf->Watermark = "Demo Petition / Not Valid";
	}

	$pdf->Candidate[$TotalCandidates] = $var["Candidate_DispName"];
	$pdf->PositionType[$TotalCandidates] = "electoral";
	$pdf->RunningFor[$TotalCandidates] =  $var["CandidateElection_PetitionText"];
	$pdf->Residence[$TotalCandidates] = $var["Candidate_DispResidence"];
	
	
	$pdf->BOEIDNbrOfVolumes = count($result);
	
	
	#for ($i = 2101467; $i <= 210176; $i++) {
	#	$Order[$j] = "BX" . 2101467 . " ";		
	#}
	
	for( $i = 0; $i < $pdf->BOEIDNbrOfVolumes; $i++) {
		do {
			$j = rand ( 0 , ($pdf->BOEIDNbrOfVolumes - 1) );
			if ( empty ($Order[$j])) {
				$Order[$j] = $result[$i]["CandidatePetIDNbr_BOEID"] . " ";
				$done = 0;
			} else {
				$done = 1;
			}
		} while ($done == 1);		
	}
	
	/*
	for( $i = 0; $i < $pdf->BOEIDNbrOfVolumes; $i++) {
		$Order[$i] = "NY" . (2101786 + $i) . " ";
	}
	*/
	
	for( $i = 0; $i < $pdf->BOEIDNbrOfVolumes; $i++) {
		$pdf->BOEIDNbr .= $Order[$i];
	}
	
	$pdf->Person = $result[0]["CandidatePetIDDeficiencies_Name"];
 	$pdf->Address = $result[0]["CandidatePetIDDeficiencies_Address"];
	$pdf->Phone = $result[0]["CandidatePetIDDeficiencies_Phone"];
	$pdf->Email = $result[0]["CandidatePetIDDeficiencies_Email"];	
	$pdf->PositionType[0] = $result[0]["CandidateElection_PositionType"];
	
		
	$pdf->NumberOfCandidates = $TotalCandidates;
	$pdf->county = "New York" . $var["CandidatePetition_VoterCounty"];
	$pdf->party = NewYork_PrintPartyAdjective($result[0]["Candidate_Party"]);
	$pdf->ElectionDate = "June 25th, 2019";
	
	if ($pdf->NumberOfCandidates > 1) { 
		$pdf->PluralCandidates = "s"; 
		$pdf->PluralAcandidates = "";	
	} else { 
		$pdf->PluralCandidates = "";
		$pdf->PluralAcandidates = "a";	
	}

	$pdf->RunningForHeading["electoral"] = "PUBLIC OFFICE" . strtoupper($pdf->PluralCandidates);
	$pdf->RunningForHeading["party"] = "PARTY POSITION" . strtoupper($pdf->PluralCandidates);

	$pdf->CandidateNomination = "nomination of such party for public office";
	// Add or the if both.	
 	$pdf->CandidateNomination .= " or for election to a party position of such party.";

	if ( $PageSize == "letter") {
		$NumberOfLines = 14 - $pdf->NumberOfCandidates;
		$pdf->BottonPt = 240.4;
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
	
	$pdf->Output("I", "CoverSheet.pdf");

function Redact ($string) {
	return str_repeat("X", strlen($string)); ;
	return $string;
}

?>

