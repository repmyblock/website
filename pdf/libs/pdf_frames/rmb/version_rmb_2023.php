<?php
// This is the petition frame
// Make sure the name of the function name matches the file name version_<uniqname>.php.

// Built by Theo Chino for the 2021 petitioning season.
function version_rmb_2023 ($pdf, $InfoArray) {


	// This is the meat of the petition.	
	$Counter = 0;
	$ResetApt = 0;


	$LineLoc = 110; $LineTop = 28;
	$pdf->Line($LineLoc, $LineTop, $LineLoc, $LineTop + 230);
	$Alternate = 0;

	if ( ! empty ($InfoArray["Address"])) {
		foreach ($InfoArray["Address"] as $AddressLine => $ArrayOne) {
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
}