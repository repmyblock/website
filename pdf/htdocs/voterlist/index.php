<?php
	//date_default_timezone_set('America/New_York'); 
		
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/voterlist.php';
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	$r = new OutragedDems();

	$result = $r->ListCandidatePetition($SystemUser_ID, "published");
	$result = $result[0];
	$voters = $r->ListVoterCandidate($result["Candidate_ID"]);
	
	#echo "<PRE>";
	//print_r($voters);
	
	if (! empty ($voters)) {
		foreach ($voters as $person) {
			if ( ! empty ($person)) {
				$FixedAddress = preg_replace('!\s+!', ' ', $person["Raw_Voter_ResStreetName"] );
				$FixedApt = preg_replace('!\s+!', '', $person["Raw_Voter_ResApartment"] );
				$Address[$FixedAddress][$person["Raw_Voter_ResHouseNumber"]]["PrintAddress"] = ucwords(strtolower(trim($r->DB_ReturnAddressLine1($person))));
				$Address[$FixedAddress][$person["Raw_Voter_ResHouseNumber"]][$FixedApt][$person["Raw_Voter_Status"]][] = $person["CandidatePetition_VoterFullName"];
			}
		}
	}
	
	$PageSize = "letter";
	$pdf = new PDF('P','mm', $PageSize);
	
	// Insert the logo:
	
	$pdf->Candidate[0] = $result["Candidate_DispName"];
	$pdf->RunningFor[0] = $key["CandidatePositionName"];
	$pdf->Residence[0] = $result["Candidate_DispResidence"];
	$pdf->PositionType[0] = $result["CandidateElection_PositionType"];

	$pdf->NumberOfCandidates = 1;
	$pdf->ElectionDate = "June 25th, 2018";

	if ( $PageSize == "letter") {
		$NumberOfLines = 13; $pdf->BottonPt = 10.4;
	} else if ( $PageSize = "legal") {
		$NumberOfLines = 23; $pdf->BottonPt = 236;
	}

	$pdf->AliasNbPages();
	$pdf->SetTopMargin(8);
	$pdf->SetLeftMargin(5);
	$pdf->SetRightMargin(5);
	$pdf->SetAutoPageBreak(1, 38);
	$pdf->AddPage();
	
	// This is the meat of the petition.	
  $Counter = 0;
	
	#print "Counted Addres: $TotalCountName\n";	
	$pdf->SetFont('Arial', '', 10);
	$YLocation = $pdf->GetY();
	
	if ( ! empty ($Address)) {
		foreach ($Address as $AddressLine => $ArrayOne) {
			if ( ! empty ($ArrayOne)) {
				foreach ($ArrayOne as $HomeNumber => $ArrayTwo) {
					
					$YLocation += 12;
					$pdf->SetXY(5, $YLocation);
					$pdf->SetFont('Arial', 'B', 16);
					$pdf->Cell(39, 0, $ArrayTwo["PrintAddress"], 0, 0, 'L', false);
				
				
/*	
					Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
					w -> Cell width. If 0, the cell extends up to the right margin. 
					h -> Cell height. Default value: 0. 
					txt -> String to print. Default value: empty string. 
					border ->  Indicates if borders must be drawn around the cell. The value can be either a number:
					        0: no border 1 : frame
					        L: left    T: top     R: right    B: bottom    Default value: 0. 
					ln  ->  Indicates where the current position should go after the call. Possible values are:
					        0: to the right     1: to the beginning of the next line      2: below
					        Putting 1 is equivalent to putting 0 and calling Ln() just after. Default value: 0. 
					align ->  Allows to center or align the text. Possible values are
					        L or empty string: left align (default value)
					        C: center
					        R: right align
					fill -> Indicates if the cell background must be painted (true) or transparent (false). Default value: false. 
					link -> URL or identifier returned by AddLink(). 
					
					SetXY(float x, float y)
*/
					
					if ( ! empty ($ArrayTwo)) {
						foreach ($ArrayTwo as $ApartementNumber => $ArrayThree) {
							if ( ! empty ($ArrayThree)) {
								
								if ( $ApartementNumber != "PrintAddress") {
									$YLocation += 5;
									$pdf->SetFont('Arial', 'B', 12);
									$pdf->SetXY(10, $YLocation);
									$pdf->Cell(27, 0, $ApartementNumber, 0, 0, 'L', false);
									$pdf->SetFont('Arial', '', 10);
									
									// Names and status.
									foreach ($ArrayThree as $Status => $ArrayFour) {
										if (! empty ($ArrayFour)) {
											foreach($ArrayFour as $PersonVoters) {
												$YLocation += 5;
												$pdf->SetXY(17, $YLocation);
												
												$pdf->SetFont('ZapfDingbats','', 15);
												$pdf->Cell(5, 0, "o", 0, 0, 'L', false);
												
												$pdf->SetFont('Arial', '', 10);
												$pdf->Cell(1, 0, $PersonVoters . " (" . $Status . ")" , 0, 0, 'L', false);											 	
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
	
	 		
 	/*
	if ( $Counter++ > $NumberOfLines ) {
													$Counter = 0;
													$pdf->AddPage();
												}	
	*/
	#exit();
	
	$pdf->Output("I", "VotersList.pdf");

function Redact ($string) {
	return str_repeat("X", strlen($string)); ;
	return $string;
}

?>

