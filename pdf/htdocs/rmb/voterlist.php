<?php
	//date_default_timezone_set('America/New_York'); 		
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/voterlist_class.php';

	$r = new OutragedDems();
	$voters = $r->ListVoterForCandidates($URIEncryptedString["Candidate_ID"]);
	
	
	//echo "<PRE>" . print_r($URIEncryptedString, 1) . "</PRE>";
	//exit();
/*
		[DataHouse_Apt] => 44
		[DataDistrictTemporal_GroupID] => 
		[DataDistrictTown_ID] => 
		[DataHouse_BIN] => 
		[DataAddress_HouseNumber] => 601
		[DataAddress_FracAddress] => 
		[DataAddress_PreStreet] => 
		[DataStreet_ID] => 14265
		[DataAddress_PostStreet] => 
		[DataCity_ID] => 47
		[DataAddress_zipcode] => 10031
		[DataAddress_zip4] => 1003
		[Cordinate_ID] => 
		[PG_OSM_osmid] => 
		[DataStreet_Name] => West 141 Street
		[DataCity_Name] => New York

	exit();
	*/

	$Today = date("Ymd_Hi");
	$OutputFilename = "WalkSheet_" . $voters[0]["CandidateElection_DBTable"] . $voters[0]["CandidateElection_DBTableValue"] . "_" . $Today . ".pdf";
	
	WriteStderr($voters, "voters");
	
	
	if (! empty ($voters)) {
		foreach ($voters as $person) {
			
			// echo "<PRE>" . print_r($person, 1) . "</PRE>";
			
			/*
			Array
(
    [Candidate_ID] => 1
    [SystemUser_ID] => 1
    [Candidate_UniqStateVoterID] => NY000000000038194272
    [DataCounty_ID] => 120
    [Voter_ID] => 9741479
    [CandidateElection_ID] => 
    [Candidate_Party] => DEM
    [Candidate_FullPartyName] => 
    [PartySymbol_ID] => 
    [Candidate_DisplayMap] => 
    [Candidate_DispName] =>  Theo Bruce. Chino Tavarez
    [Candidate_DispResidence] => 640 Riverside Drive - Apt 10b
New York, NY 10031
    [CandidateAptment_ID] => 
    [Candidate_StatementPicFileName] => 
    [Candidate_StatementWebsite] => 
    [Candidate_StatementEmail] => 
    [Candidate_StatementTwitter] => 
    [Candidate_StatementPhoneNumber] => 
    [Candidate_StatementText] => 
    [CandidateElection_DBTable] => ADED
    [CandidateElection_DBTableValue] => 71002
    [Candidate_StatsVoters] => 
    [Candidate_Status] => published
    [Candidate_LocalHash] => 
    [Candidate_NominatedBy] => 
    [Voters_ID] => 96759
    [VotersIndexes_ID] => 83966
    [ElectionsDistricts_DBTable] => ADED
    [ElectionsDistricts_DBTableValue] => 71002
    [DataHouse_ID] => 62676
    [Voters_Gender] => male
    [VotersComplementInfo_ID] => 
    [Voters_UniqStateVoterID] => NY000000000034847095
    [DataState_ID] => 1
    [Voters_RegParty] => DEM
    [Voters_ReasonCode] => 
    [Voters_Status] => Active
    [VotersMailingAddress_ID] => 
    [Voters_IDRequired] => no
    [Voters_IDMet] => yes
    [Voters_ApplyDate] => 
    [Voters_RegSource] => MailIn
    [Voters_DateInactive] => 
    [Voters_DatePurged] => 
    [Voters_CountyVoterNumber] => 304880362
    [Voters_RecFirstSeen] => 2021-11-02
    [Voters_RecLastSeen] => 2021-11-02
    [DataAddress_ID] => 31643
    [DataHouse_Apt] => 3k
    [DataDistrictTemporal_GroupID] => 
    [DataDistrictTown_ID] => 
    [DataHouse_BIN] => 
    [DataAddress_HouseNumber] => 610
    [DataAddress_FracAddress] => 
    [DataAddress_PreStreet] => 
    [DataStreet_ID] => 4362
    [DataAddress_PostStreet] => 
    [DataCity_ID] => 47
    [DataAddress_zipcode] => 10031
    [DataAddress_zip4] => 1003
    [Cordinate_ID] => 
    [PG_OSM_osmid] => 
    [DataStreet_Name] => West 142 Street
    [DataCity_Name] => New York
    [DataLastName_ID] => 15410
    [DataFirstName_ID] => 9024
    [DataMiddleName_ID] => 2039
    [VotersIndexes_Suffix] => 
    [VotersIndexes_DOB] => 1982-09-09
    [VotersIndexes_UniqStateVoterID] => NY000000000034847095
    [DataLastName_Text] => Rodriguez
    [DataLastName_Compress] => rodriguez
    [DataFirstName_Text] => Daniel
    [DataFirstName_Compress] => daniel
    [DataMiddleName_Text] => J
    [DataMiddleName_Compress] => j
)

*/
			
			if ( ! empty ($person)) {
				$FixedAddress = preg_replace('!\s+!', ' ', $person["DataStreet_Name"] );
				$FixedApt = preg_replace('!\s+!', '', $person["DataHouse_Apt"] );
				$Address[$FixedAddress][$person["DataAddress_HouseNumber"]]["PrintAddress"] = ucwords(strtolower(trim( $person["DataAddress_HouseNumber"] . " " . $person["DataStreet_Name"] )));
				$Address[$FixedAddress][$person["DataAddress_HouseNumber"]][$FixedApt][$person["Voters_Status"]][$person["VotersIndexes_UniqStateVoterID"]] =	$person["DataFirstName_Text"] . " " . $person["DataMiddleName_Text"] . " " . $person["DataLastName_Text"];
				
				

				
				// The reason for this is that the CandidatePetition_ID is unique enough.
				$Age[$person["VotersIndexes_UniqStateVoterID"]] = $person["CandidatePetition_Age"];
        $Gender[$person["VotersIndexes_UniqStateVoterID"]] = $person["Voters_Gender"];
			}
		}
	}
	
	$PageSize = "letter";
	$pdf = new PDF('P','mm', $PageSize);
	
	$RestOfLine = "";
	$pdf->Text_PubDate_XLoc = 153;
	if ( $voters[0]["CandidateElection_DBTable"] = "EDAD") {
		preg_match('/(\d\d)(\d\d\d)/', $voters[0]["CandidateElection_DBTableValue"], $Keywords);
		$RestOfLine = " AD: " . intval($Keywords[1]) . " ED: " . intval($Keywords[2]);
		$pdf->Text_PubDate_XLoc = 133;
	}
		
	
	$pdf->Text_PubDate = date("M j, Y \a\\t g:i a") . $RestOfLine;
	$pdf->Text_CandidateName = $voters[0]["Candidate_DispName"];
	$pdf->Text_ElectionDate = $ElectionDate;
	$pdf->Text_PosType = $voters[0]["CandidateElection_PositionType"];
  $pdf->Text_Party = $voters[0]["CandidateElection_Party"];
  $pdf->Text_PosText = $voters[0]["CandidateElection_Text"];
 	$pdf->Text_PosPetText = $voters[0]["CandidateElection_PetitionText"];
  $pdf->Text_DistricType = $voters[0]["CandidateElection_DBTable"];
  $pdf->Text_DistricHeading = $voters[0]["CandidateElection_DBTableValue"];
  $pdf->Text_PetitionSetID = $voters[0]["CandidatePetitionSet_ID"];
   
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
												
												if ( $Status == "Inactive") { $pdf->SetTextColor(255, 0, 0); }
												$pdf->Write(1, $VoterPrintLine . "  ");
												if ( $Status == "Inactive") { $pdf->SetTextColor(0); }
							 	
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

