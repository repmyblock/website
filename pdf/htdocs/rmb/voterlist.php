<?php
	//date_default_timezone_set('America/New_York'); 		
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/voterlist_class.php';

	$r = new OutragedDems();
	
	if ( ! empty ($CanPetitionSet_ID)) {
		$result = $r->ListCandidatePetitionSet($CanPetitionSet_ID);		
	} else {
		$result = $r->ListCandidatePetition($SystemUser_ID, "published");
	}
	$result = $result[0];
	$voters = $r->ListVoterCandidate($result["Candidate_ID"]);

	$Today = date("Ymd_Hi");
	$OutputFilename = "WalkSheet_" . $result["CandidateElection_DBTable"] . $result["CandidateElection_DBTableValue"] . "_" . $Today . ".pdf";
	/*
		echo "<PRE>";
		print_r($result);
		exit();
	*/
	
	if (! empty ($voters)) {
		foreach ($voters as $person) {
			if ( ! empty ($person)) {
				$FixedAddress = preg_replace('!\s+!', ' ', $person["Raw_Voter_ResStreetName"] );
				$FixedApt = preg_replace('!\s+!', '', $person["Raw_Voter_ResApartment"] );
				$Address[$FixedAddress][$person["Raw_Voter_ResHouseNumber"]]["PrintAddress"] = ucwords(strtolower(trim($r->DB_ReturnAddressLine1($person))));
				$Address[$FixedAddress][$person["Raw_Voter_ResHouseNumber"]][$FixedApt][$person["Raw_Voter_Status"]][$person["CandidatePetition_ID"]] =	$person["CandidatePetition_VoterFullName"];
				
				// The reason for this is that the CandidatePetition_ID is unique enough.
				$Age[$person["CandidatePetition_ID"]] = $person["CandidatePetition_Age"];
        $Gender[$person["CandidatePetition_ID"]] = $person["Raw_Voter_Gender"];
			}
		}
	}
	
	$PageSize = "letter";
	$pdf = new PDF('P','mm', $PageSize);
	
	$RestOfLine = "";
	$pdf->Text_PubDate_XLoc = 153;
	if ( $result["CandidateElection_DBTable"] = "EDAD") {
		preg_match('/(\d\d)(\d\d\d)/', $result["CandidateElection_DBTableValue"], $Keywords);
		$RestOfLine = " AD: " . intval($Keywords[1]) . " ED: " . intval($Keywords[2]);
		$pdf->Text_PubDate_XLoc = 133;
	}
		
	
	$pdf->Text_PubDate = date("M j, Y \a\\t g:i a") . $RestOfLine;
	$pdf->Text_CandidateName = $result["Candidate_DispName"];
	$pdf->Text_ElectionDate = $ElectionDate;
	$pdf->Text_PosType = $result["CandidateElection_PositionType"];
  $pdf->Text_Party = $result["CandidateElection_Party"];
  $pdf->Text_PosText = $result["CandidateElection_Text"];
 	$pdf->Text_PosPetText = $result["CandidateElection_PetitionText"];
  $pdf->Text_DistricType = $result["CandidateElection_DBTable"];
  $pdf->Text_DistricHeading = $result["CandidateElection_DBTableValue"];
  $pdf->Text_PetitionSetID = $result["CandidatePetitionSet_ID"];
   
  $pdf->LeftText = $pdf->Text_Party . " SetID:" . $result["CandidatePetitionSet_ID"];
	$pdf->RightText =  $pdf->Text_DistricType . ":" . $pdf->Text_DistricHeading;
	
	// Insert the logo:
	if ( $PageSize == "letter") {
		$NumberOfLines = 13; $pdf->BottonPt = 10.4; 
	} else if ( $PageSize = "legal") {
		$NumberOfLines = 23; $pdf->BottonPt = 236; 
	}

	$pdf->AliasNbPages();
	$pdf->SetTopMargin(8);
	$pdf->SetLeftMargin(5);
	$pdf->SetRightMargin(5);
	$pdf->SetAutoPageBreak(1, 10);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	// This is the meat of the petition.	
  $Counter = 0;
	$ResetApt = 0;
	
	if ( ! empty ($Address)) {
		foreach ($Address as $AddressLine => $ArrayOne) {
			if ( ! empty ($ArrayOne)) {
				foreach ($ArrayOne as $HomeNumber => $ArrayTwo) {
					$pdf->SetFont('Arial', 'B', 16);
					$pdf->Write(7, $ArrayTwo["PrintAddress"] );	
					$pdf->Ln(2);
								
					if ( ! empty ($ArrayTwo)) {
						foreach ($ArrayTwo as $ApartementNumber => $ArrayThree) {
							if ( ! empty ($ArrayThree)) {
							
								$ResetApt = 1;
								if ( $ApartementNumber != "PrintAddress") {
									
									if ($pdf->GetY() > 256 ) {
										 $pdf->AddPage();
									}
										
									if ( ! empty ($ApartementNumber)) {			
										//$pdf->Ln(2);
										$pdf->SetFont('Arial', '', 12);
										$pdf->SetX(7);
										$pdf->Write(2, "Apartment: " );
										$pdf->SetFont('Arial', 'B', 12);
										$pdf->Write(2, $ApartementNumber);
										$pdf->Ln(6);
									} 
									$pdf->SetFont('Arial', '', 10);
		
									// Names and status.
									foreach ($ArrayThree as $Status => $ArrayFour) {
										if (! empty ($ArrayFour)) {
											foreach($ArrayFour as $IDToUse => $PersonVoters) {			
												
												// How far are we from the end?
												$VoterPrintLine = $PersonVoters . " - " . $Gender[$IDToUse] . " " . $Age[$IDToUse];
												$LenghtString = $pdf->GetStringWidth($VoterPrintLine);
												
												if (($pdf->GetX() + $LenghtString) > 180 && $ResetApt == 0) {
													$ResetApt = 1;
													$pdf->Ln(5);
												}
												
												if ( $ResetApt == 1 ) {
													$pdf->SetX(10);
												}
												
												$ResetApt = 0;
											
												$pdf->SetFont('ZapfDingbats','', 15);
												$pdf->Write(1, "o" );												
												$pdf->SetFont('Arial', '', 10);
												$pdf->Write(1, " " );	
												if ( $Status == "INACTIVE") { $pdf->SetTextColor(255, 0, 0); }
												$pdf->Write(1, $VoterPrintLine . "  ");
												if ( $Status == "INACTIVE") { $pdf->SetTextColor(0); }
							 	
											}
										}	
									}	
								}
								
									
								$pdf->Ln(7);
								
								
							}
						}					
					}
					//$pdf->Ln(1);
				}				
			}			
		}
	}
	
$pdf->Output("I", $OutputFilename);

function Redact ($string) {
	return str_repeat("X", strlen($string)); ;
	return $string;
}

?>

