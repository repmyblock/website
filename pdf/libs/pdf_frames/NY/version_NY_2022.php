<?php
// This is the petition frame
// Make sure the name of the function name matches the file name version_<uniqname>.php.

// Built by Theo Chino for the 2021 petitioning season.
function version_NY_2022 ($pdf, $InfoArray) {
	
	// Header of the petition.
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(35, 8, "Date" ,0, 0, 'C', 0);
	$pdf->Cell(75, 8, "Name of Signer / Signature", 0, 0, 'C', 0);
	$pdf->Cell(74, 8, "Residence", 0, 0, 'C', 0);
	$pdf->Cell(20, 8, $pdf->TypeOfTown, 0, 0, 'C', 0);
	$pdf->Ln(4.5);

 	$pdf->YLocation = $pdf->GetY();
 
 	$YLocation = $pdf->GetY() - 3.5;
 	$pdf->Line($pdf->Line_Left, $YLocation, $pdf->Line_Right, $YLocation);
 	
 	$pdf->MyTopFor = $YLocation;

	for ($i = 0; $i < $TotalCountName; $i++) {
		$Counter++;
		$YLocation = $pdf->GetY();

		$pdf->SetFont('Arial', '', 10);
		$pdf->SetY($YLocation - 13);
		$pdf->Cell(38, 0, $Counter . ". " . $DateForCounter, 0, 0, 'L', 0);	
		
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
		$pdf->SetXY( 41,  $YLocation + 0.4);
		$pdf->Write(0, "Print your name here:");

		
		$pdf->SetTextColor(0);
		
	 	if ( ! empty ($MyCustomCounty)) {
			$pdf->SetFont('Arial','B', $MyCustomCountyFontSize);
			$pdf->SetXY(195, $YLocation - 4);
			$pdf->Cell(38, 0, $MyCustomCounty, 0, 0, 'L', 0);
		}
		
		
		if ( ! empty ($MyCustomAddress)) {
			$pdf->SetFont('Arial','',12);
			$pdf->SetXY(121, $YLocation - 9);
			$pdf->MultiCell(73, 5, $MyCustomAddress, 0, 'L', 0);
		}
		
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY( 6,  $YLocation - 4 );
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(38, 0, $Counter . ". " . $DateForCounter, 0, 0, 'L', 0);

		$pdf->SetY($YLocation+0.8);	
			
		if ($pdf->GetY() > 218) {
			$done = 0;
		} else {
			$pdf->SetXY($pdf->Line_Left, $YLocation);				
		}
		
	}

	$pdf->Line($pdf->Line_Left, $YLocation + 2, $pdf->Line_Right, $YLocation + 2);
	$pdf->LocationOfFooter = $YLocation + 6.5;
	$pdf->BottonPt = $YLocation + 1.9;
	
	  	$pdf->Line($pdf->Line_Left, $pdf->MyTopFor, $pdf->Line_Left, $pdf->BottonPt);
 	$pdf->Line(40,  $pdf->MyTopFor, 40,  $pdf->BottonPt);
 	$pdf->Line(120, $pdf->MyTopFor, 120, $pdf->BottonPt);
 	$pdf->Line(190, $pdf->MyTopFor, 190, $pdf->BottonPt);
 	$pdf->Line($pdf->Line_Right, $pdf->MyTopFor, $pdf->Line_Right, $pdf->BottonPt);
	// $this->Line($this->Line_Left, $this->BottonPt, $this->Line_Right, $this->BottonPt);

}
?>
