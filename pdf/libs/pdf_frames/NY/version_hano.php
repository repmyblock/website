<?php
// This is the petition frame
// Make sure the name of the function name matches the file name version_<uniqname>.php.

// Built by Mike Hano for 2022.
function version_hano ($pdf, $InfoArray) {

	
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
		//$pdf->Line($pdf->Line_Left, $YLocation + 2, $pdf->Line_Right, $YLocation + 2);
		
		$pdf->SetFont('Arial','B',15);
		$pdf->SetXY($pdf->Line_Left - 2, $YLocation + 7);
		$pdf->Cell(5, 0, $Counter, 0, 0, 'R', 0);
		
		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY($pdf->Line_Left + 4, $YLocation + 3.7);
		$pdf->MultiCell(12, 3.3, "Print Name", 0, 'L', 0);

		$pdf->SetXY($pdf->Line_Left + 80, $YLocation + 3.7);
		$pdf->MultiCell(10, 3.3, "Sign x", 0, 'R', 0);
		
		$pdf->SetFont('Arial','B',17);
		$pdf->SetXY($pdf->Line_Left + 148, $YLocation + 6);
		$pdf->MultiCell(40, 3.3, "   /      / 2022", 0, 'R', 0);
		
		$pdf->Rect($pdf->Line_Left + 3, $YLocation + 2,  $pdf->Line_Right - $pdf->Line_Left - 2 , 18);
		$pdf->Line($pdf->Line_Left + 3, $YLocation + 12, $pdf->Line_Right - 14 , $YLocation + 12);
		
		$pdf->Line($pdf->Line_Left + 80,  $YLocation + 2, $pdf->Line_Left + 80, $YLocation + 12);
		$pdf->Line($pdf->Line_Left + 149,  $YLocation + 2, $pdf->Line_Left + 149, $YLocation + 12);
		$pdf->Line($pdf->Line_Left + 189,  $YLocation + 2, $pdf->Line_Left + 189, $YLocation +20);

	
		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY($pdf->Line_Left + 4, $YLocation + 15.5);
		$pdf->MultiCell(21, 3.3, "Address", 0, 'L', 0);
		
		$pdf->SetFont('Arial','',10);
		$pdf->SetXY($pdf->Line_Left + 110, $YLocation + 15.5);
		$pdf->Cell(21, 3.3, "Apt", 0, 'L', 0);
		$pdf->SetXY($pdf->Line_Left + 150, $YLocation + 15.5);
		$pdf->Cell(21, 3.3, "New York, NY, ", 0, 'L', 0);
		
		$pdf->SetFont('Arial','',10);
		$pdf->SetXY($pdf->Line_Left + 198, $YLocation +5);
		$pdf->Cell(5, 0, "County", 0, 0, 'R', 0);
		
		$pdf->SetFont('Arial','B',10);
		//$pdf->SetXY($pdf->Line_Left + 198, $YLocation +12);	
		//$pdf->RotatedText($pdf->Line_Left + 193, $YLocation + 19, "BRONX", 50);
		//$pdf->Cell(5, 0, "BRONX", 0, 0, 'R', 0);

		//$pdf->Line($pdf->Line_Left + 13,  $YLocation + 2, $pdf->Line_Left + 13, $YLocation + 2);
	
		
		
		$YLocation += 19.5;
		$pdf->SetXY($pdf->Line_Left, $YLocation - 4);
		
		//
		
		$pdf->SetTextColor(220);

		$pdf->SetFont('Arial','I',20);
		$pdf->SetXY( 72,  $YLocation - 6);
		#$pdf->Write(0, 'Sign here');
		
		$pdf->SetTextColor(190);

		$pdf->SetFont('Arial','I',8);		
		$pdf->SetXY( 41,  $YLocation + 0.4);
		#$pdf->Write(0, "Print your name here:");

		
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
		//$pdf->Cell(38, 0, $Counter . ". " . $DateForCounter, 0, 0, 'L', 0);

		$pdf->SetY($YLocation+0.8);	
			
		if ($pdf->GetY() > 210) {
			$done = 0;
		} else {
			$pdf->SetXY($pdf->Line_Left, $YLocation);				
		}
		
	}

	//$pdf->Line($pdf->Line_Left, $YLocation + 2, $pdf->Line_Right, $YLocation + 2);
	
	$pdf->LocationOfFooter = $YLocation + 6.5;
	$pdf->BottonPt = $YLocation + 1.9;
	
}
?>
