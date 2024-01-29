<?php
	//date_default_timezone_set('America/New_York'); 
		
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/NY/specification_class.php';
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	$r = new OutragedDems();

	$PageSize = "letter";
	$pdf = new PDF('L','mm', $PageSize);

	$Counter = 1;
	$TotalCandidates = 0;

	$NumbersOfVolumesPetitions = 0;
	$VolumesID = "";
	$pdf->PetitionsGroups = "Candidate: P" . $URIEncryptedString["Candidate_ID"] . " - Petitions: ";
	
	if ( ! empty ($result)) {
		foreach ($result as $var) {
			if ( ! empty ($var)) {
				$PetitionsSet[$var["CandidateSet_ID"]] = 1;
				$VolumesID .= $var["FillingTrack_BOEID"] . " ";		
				$NumbersOfVolumesPetitions++;		
			}
		}
		
		foreach ($PetitionsSet as $var => $index) {			
			$pdf->PetitionsGroups .= "S" . $var . " ";
		}
	}

	$pdf->NumbersOfVolumesPetitions = 	$NumbersOfVolumesPetitions;
  $pdf->VolumesIDs = $VolumesID;
	#echo "<PRE>"  . print_r($PetitionData, 1) . "</PRE>";
	
	$i = 0;
	if ( ! empty ($PetitionData)) {
		foreach ( $PetitionData as $var => $key) {	
			if ( ! empty ($var)) {
				if ( is_array($key)) {
					#print "<PRE>" . print_r($key, 1) . "</PRE>";
 					$pdf->Candidate[$TotalCandidates] =  $key["CandidateName"];
 					$pdf->RunningFor[$TotalCandidates] =  $key["CandidatePositionName"];
					$pdf->Residence[$TotalCandidates] = $key["CandidateResidence"];
					$pdf->PositionType[$TotalCandidates] = $key["PositionType"];					
					#print "Total Candidates; $TotalCandidates\n";
					$TotalCandidates++;
				}
			}
		}
	}	

	$pdf->NumberOfCandidates = $TotalCandidates;
	$pdf->county = "New York" . $var["CandidatePetition_VoterCounty"];
	$pdf->party = "Social Democratic";
	$pdf->ElectionDate = "June 8th, 2022";
	
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

	// Need to fix that.
	
	$pdf->Person = "Theo Chino";
	$pdf->Address = "640 Riverside Drive - 10B\nNew York, NY 10031";
 	$pdf->Phone = "(929) 359-3349";
  $pdf->Email = "theo@repmyblock.org";
  
	$pdf->TodayDateText = "Date: " . date("F _________ , Y"); 
	$pdf->County = $result[0]["CandidatePetition_VoterCounty"];
	$pdf->City = "City of New York";
	
	$pdf->City = "____________________"; 
	$pdf->County = "__________________"; 
	
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
	
	$Filename = "CoverSheet_" . $pdf->typepetition . $pdf->Candidate[0]  . "_" . $pdf->PetitionsGroups;
	$Filename = preg_replace('/\s+/', '_', $Filename);
	
	$pdf->Output("I", $Filename . ".pdf");
?>

