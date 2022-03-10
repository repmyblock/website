<?php
	//date_default_timezone_set('America/New_York'); 		
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/voterlist_class.php';

	$r = new OutragedDems();
	$DB_Type = "DBRaw";
	
	WriteStderr($URIEncryptedString, "URIEncryptedString");
		
	if ($URIEncryptedString["DataDistrict_ID"] > 0) {
		$voters = $r->ListVotersForDataDistrict($URIEncryptedString["DataDistrict_ID"]);
		$PreparedFor = $URIEncryptedString["PreparedFor"];
		
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
	$OutputFilename = "WalkSheet_" . $Today . "_" . $FileTitle . "_" . $WalkSheetUser["CandidateElection_DBTable"] . 
										$WalkSheetUser["CandidateElection_DBTableValue"] . 
										".pdf";
	
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

	$PageSize = "letter";
	$pdf = new PDF('P','mm', $PageSize);
	
	$RestOfLine = "";
	$pdf->Text_PubDate_XLoc = 153;
	if ( $WalkSheetUser["CandidateElection_DBTable"] = "EDAD") {
		preg_match('/(\d\d)(\d\d\d)/', $WalkSheetUser["CandidateElection_DBTableValue"], $Keywords);
		$RestOfLine = " AD: " . intval($Keywords[1]) . " ED: " . intval($Keywords[2]);
		$pdf->Text_PubDate_XLoc = 133;
	}
	
	$pdf->Text_PubDate = date("M j, Y \a\\t g:i a") . $RestOfLine;
	$pdf->Text_CandidateName = $PreparedFor;
	$pdf->Text_ElectionDate = $ElectionDate;
	$pdf->Text_PosType = $WalkSheetUser["CandidateElection_PositionType"];
  $pdf->Text_Party = $WalkSheetUser["CandidateElection_Party"];
  $pdf->Text_PosText = $WalkSheetUser["CandidateElection_Text"];
 	$pdf->Text_PosPetText = $WalkSheetUser["CandidateElection_PetitionText"];
  $pdf->Text_DistricType = $WalkSheetUser["CandidateElection_DBTable"];
  $pdf->Text_DistricHeading = $WalkSheetUser["CandidateElection_DBTableValue"];
  $pdf->Text_PetitionSetID = $WalkSheetUser["CandidatePetitionSet_ID"];
   
  $pdf->LeftText = $pdf->Text_Party . " CanID:" . $WalkSheetUser["Candidate_ID"];
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
	
	
	$LineLoc = 110; $LineTop = 28;
	$pdf->Line($LineLoc, $LineTop, $LineLoc, $LineTop + 230);
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
										PrintApt($Alternate, $pdf, $ApartementNumber);
									} else {
										$pdf->Ln(6);
									}
									$pdf->SetFont('Arial', '', 10);
		
									// Names and status.
									foreach ($ArrayThree as $Status => $ArrayFour) {
										if (! empty ($ArrayFour)) {
								
											foreach($ArrayFour as $IDToUse => $PersonVoters) {
												
												// This is the page control				
												if ($pdf->GetY() > 256) {				
																				
													if ($Alternate == 0) {
														$pdf->SetY($LineTop - 0.5);
														$Alternate = 1;
													} else { 
														$pdf->AddPage();
														$pdf->Line($LineLoc, $LineTop, $LineLoc, $LineTop + 230);
														$Alternate = 0;
													} 
												
													PrintAddress($Alternate, $pdf, $ArrayTwo["PrintAddress"]);
													PrintApt($Alternate, $pdf, $ApartementNumber);
													
												}
												
												// How far are we from the end?
												$VoterPrintLine = $PersonVoters . " - " . strtoupper($Gender[$IDToUse][0]) . $Age[$IDToUse];
												
												PrintVoterLine($Alternate, $pdf, $VoterPrintLine, $Status);											
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
	
$pdf->Output("I", $OutputFilename);

function Redact ($string) {
	return str_repeat("X", strlen($string)); ;
	return $string;
}

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

?>

