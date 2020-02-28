<?php
	error_reporting(E_ERROR | E_PARSE);
	// date_default_timezone_set('America/New_York'); 		
	// require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/voterlist.php';

	$UniqID = $_GET["nys"];
	$hash = $_GET["hash"];
	
	$r = new OutragedDems();

	if ( ! empty ($hash) && ! empty ($UniqID)) {
		$Result = $r->ListCandidatePetitionByHash($UniqID, $hash);
		// $r->UpdateCandidatePetitionHash($UniqID, $hash);
	} 
	
	if( empty ($Result)) {
		header("Location: " . $FrontEndPDF . "/multipetitions/");
		exit();
	}

	$TodayDay = date_create(date("Y-m-d"));
	
	if (! empty ($Result)) {
		foreach ($Result as $var) {
			if ( ! empty ($var)) {
				if ( $var["Raw_Voter_Status"] == "ACTIVE" || $var["Raw_Voter_Status"] == "INACTIVE") {
							  
				  $FixedAddress = preg_replace('!\s+!', ' ', $var["Raw_Voter_ResStreetName"] );
					$FixedApt = preg_replace('!\s+!', '', $var["Raw_Voter_ResApartment"] );
					$Address[$FixedAddress][$var["Raw_Voter_ResHouseNumber"]]["PrintAddress"] = ucwords(strtolower(trim($r->DB_ReturnAddressLine1($var))));
					$Address[$FixedAddress][$var["Raw_Voter_ResHouseNumber"]][$FixedApt][$var["Raw_Voter_Status"]][$var["VotersIndexes_ID"]] =	$var["CandidatePetition_VoterFullName"];
					
					// The reason for this is that the CandidatePetition_ID is unique enough.
					$Age[$var["VotersIndexes_ID"]] = $var["CandidatePetition_Age"];
	        $Gender[$var["VotersIndexes_ID"]] = $var["Raw_Voter_Gender"];
			  }
			}
		}
	}

	$Today = date("Ymd_Hi");
	$OutputFilename = "WalkSheet_MAIL_" . $Result[0]["CandidateElection_DBTable"] . $Result[0]["CandidateElection_DBTableValue"] . "_" . $Today . ".pdf";
	
	$PageSize = "letter";
	$pdf = new PDF('P','mm', $PageSize);
	
	$pdf->Text_PubDate = date("M j, Y \a\\t g:i a");
	$pdf->Text_CandidateName = $Result[0]["Candidate_DispName"];
	$pdf->Text_ElectionDate = $ElectionDate;
	$pdf->Text_PosType =  $Result[0]["CandidateElection_PositionType"];
  $pdf->Text_Party = $Result[0]["Candidate_Party"];
  $pdf->Text_PosText =  $Result[0]["CandidateElection_Text"];
 	$pdf->Text_PosPetText =  $Result[0]["CandidateElection_PetitionText"];
  $pdf->Text_DistricType = $Result[0]["CandidateElection_DBTable"];
  $pdf->Text_DistricHeading = $Result[0]["CandidateElection_DBTableValue"];
  $pdf->Text_PetitionSetID =  $Result[0]["Raw_Voter_ID"];
  
  $pdf->LeftText = $pdf->Text_Party . " Mail Request: " . $Result[0]["Candidate_UniqNYSVoterID"];
	$pdf->RightText =  $Result[0]["Raw_Voter_Dates_Date"] . " - " . $pdf->Text_DistricType . ":" . $pdf->Text_DistricHeading;
	
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

