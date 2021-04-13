<?php
require $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/script88/PDF_Code128.php';

#class PDF extends FPDF {
class PDF_Multi extends PDF_Code128 {
	
	var $angle=0;
	var $Col1 = 6; var $Col2 = 61; var $Col3 = 150;
	var $SizeCol1 = 55; var $SizeCol2 = 89; var $SizeCol3 = 59;
  var $Line_Left = 6; var $Line_Right = 209; var $Line_Col1 = 61; var $Line_Col2 = 150;
	//$Botton_Corner_Y = 0;
	 
	// Page header
	function Header()	{
		
		$DatePrintEvent = "  /      /   ";
			
		if ( ! empty ($this->DateEvent)) {
			$DatePrintEvent = $this->DateEvent;
		}
		
		$this->Image($_SERVER["DOCUMENT_ROOT"] . "/../libs/asset/NYS/NYCBOE.jpg", 95, 8, 25);
		
		$this->SetLineWidth(0.4);
		
		$this->SetXY(77, 35); 
		$this->SetFont('Arial','B',14);
    $this->Cell(24, 4, "BOARD OF ELECTIONS", 0, 0, 'L');		
 
 		$this->SetXY(0, 39); 
		$this->SetFont('Arial','B',9);
    $this->MultiCell(0, 3,  "IN\nTHE CITY OF NEW YORK", 0, 'C', 0);
		$this->SetFont('Arial','B',12);
    $this->Ln(4);
    $this->MultiCell(0, 4,  "PETITION HEARINGS\nNOTICE OF APPEARANCE", 0, 'C', 0);
    $this->Cell(24, 4, "", 0, 0, 'L');		
		
    $this->SetFont('Arial','B',9);
		$this->SetXY(20, 67);	$this->Cell(0, 4.1, "Date: ", 0 ,0, 'L');
		$this->SetXY(20, 75);	$this->Cell(0, 4.1, "County: ", 0 ,0, 'L');
		$this->SetXY(20, 83);	$this->Cell(0, 4.1, "Specification No(s): ", 0 ,0, 'L');
		$this->SetXY(20, 91);	$this->Cell(0, 4.1, "Petition No(s): ", 0 ,0, 'L');
		$this->SetXY(20, 99);	$this->Cell(0, 4.1, "Objector: ", 0 ,0, 'L');
		$this->SetXY(20, 107); $this->Cell(0, 4.1, "Candidate: ", 0 ,0, 'L');
		
		$this->SetFont('Arial','',9);
		$this->SetXY(55, 67);	$this->Cell(0, 4.1, $this->DateAppear, 0 ,0, 'L');
		$this->SetXY(55, 75);	$this->Cell(0, 4.1, $this->County, 0 ,0, 'L');
		$this->SetXY(55, 83);	$this->Cell(0, 4.1, $this->SpecificationNumber, 0 ,0, 'L');
		$this->SetXY(55, 91);	$this->Cell(0, 4.1, $this->PetitionNumber, 0 ,0, 'L');
		$this->SetXY(55, 99);	$this->Cell(0, 4.1, $this->ObjectorName, 0 ,0, 'L');
		$this->SetXY(55, 107); $this->Cell(0, 4.1, $this->CandidateName, 0 ,0, 'L');
		
		
		$this->SetFont('Arial','BI',9);
		$this->SetXY(20, 120);	$this->MultiCell(0, 4.1, "I hereby appear in the proceeding before the Board of " .
												  "Elections in the City of New York with respect to the specification of the " .
												  "objections indicated above.", 0, 'L', 0);

		$LongString = "I appear as the ";
		if ($this->CheckRep == 1) { $LongString .= "representative of the "; }
		$LongString .= $this->RepType . ".";
		
		$this->SetFont('Arial','',9);		
		$this->SetXY(20, 132); $this->Cell(0, 4.1, $LongString, 0 ,0, 'L');

		$this->SetFont('Arial','B',9);
			$this->SetXY(40, 142); $this->Cell(0, 4.1, "Name: ", 0 ,0, 'L');

		if ($this->CheckRep == 1) {		
			$this->SetXY(40, 150); $this->Cell(0, 4.1, "Firm (if any): ", 0 ,0, 'L');
		}
	
		$this->SetXY(40, 158); $this->Cell(0, 4.1, "Address: ", 0 ,0, 'L');
		$this->SetXY(40, 170); $this->Cell(0, 4.1, "Tel. No.:  ", 0 ,0, 'L');
		$this->SetXY(120, 170); $this->Cell(0, 4.1, "Fax No.: ", 0 ,0, 'L');
		$this->SetXY(40, 178); $this->Cell(0, 4.1, "Email Address: ", 0 ,0, 'L');

		$this->SetFont('Arial','',9);
		$this->SetXY(65, 142); $this->Cell(0, 4.1, $this->RepreName, 0 ,0, 'L');
		
		if ($this->CheckRep == 1) {
			$this->SetXY(65, 150); $this->Cell(0, 4.1, $this->RepreFirm, 0 ,0, 'L');
		}
		
		$this->SetXY(65, 158); $this->Cell(0, 4.1, $this->RepAddress1, 0 ,0, 'L');
		$this->SetXY(65, 162); $this->Cell(0, 4.1, $this->RepAddress2, 0 ,0, 'L');
		$this->SetXY(65, 170); $this->Cell(0, 4.1, $this->RepTel, 0 ,0, 'L');
		$this->SetXY(145, 170); $this->Cell(0, 4.1, $this->RepFax, 0 ,0, 'L');
		$this->SetXY(65, 178); $this->Cell(0, 4.1, $this->RepEmail, 0 ,0, 'L');
	
		if ($this->CheckRep == 1) {
			$this->SetXY(20, 190);	$this->MultiCell(0, 4.1, "If the representative is not an attorney, a notice of authorization signed " .
												  "by the candidate or objector must also be filed with this notice of appearance.", 0, 'L', 0);

			$this->SetFont('Arial','BU',12);
		  $this->Ln(4);
  		$this->MultiCell(0, 4.5,  "NOTICE OF AUTHORIZATION", 0, 'C', 0);
	
			$this->SetFont('Arial','BI',9);
			$this->SetXY(20, 210);	$this->MultiCell(0, 4.1, "I hereby authorize the person listed above to represent " . 
																										"me at hearings at the Board of Elections.", 0, 'L', 0);
		}

	 	$this->SetFont('Arial','B',12);
		$this->SetXY(168, 230); $this->Cell(0, 4.1, $this->SignedDate, 0 ,0, 'L');
		if ($this->CheckRep == 1) { $this->SetXY(168, 255); $this->Cell(0, 4.1, $this->SignedDate, 0 ,0, 'L'); }

	 	$this->SetFont('Arial','B',9);
		$this->SetXY(95, 236); $this->Cell(0, 4.1, "Signature of the " . ucwords($this->RepType), 0 ,0, 'L');
		$this->SetXY(180, 236); $this->Cell(0, 4.1, "Date ", 0 ,0, 'L');

		if ($this->CheckRep == 1) {
			$this->SetXY(80, 260); $this->Cell(0, 4.1, "Signature of the representative of the " . ucwords($this->RepType), 0 ,0, 'L');
			$this->SetXY(180, 260); $this->Cell(0, 4.1, "Date ", 0 ,0, 'L');
			$this->Line(80, 260, 155, 260);
			$this->Line(165, 260, 205, 260);
		}
		 

		$this->Line(80, 235, 155, 235);
		$this->Line(165, 235, 205, 235);
		
		
		
	}

	// Page footer
	function Footer()	{
		
		if (! empty ($this->BarCode)) {
			$this->Code128(160,0, $this->BarCode, 50,10);
		}
	}
	
}

?>