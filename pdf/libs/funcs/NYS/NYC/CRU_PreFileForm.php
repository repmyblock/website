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
		
		$this->Image('../common/NYCBOE.jpg',10 ,10 , 25);
		
		$this->SetLineWidth(0.4);
		
		$this->SetXY(10, 5); 
		$this->SetFont('Arial','',6);
    $this->Cell(24, 4, "Candidate Record Unit", 0, 0, 'L');		
		
   	$this->SetXY(0, 5); 
    $this->MultiCell(0, 2.5,  "New York City\nBoard of Elections\n32 Broadway 7th Floor\nNew York, NY 10004", 0, 'C', 0);
    $this->Ln(4);
   
    $this->SetX(37);
    $this->SetFont('Arial','I',7);
    $this->Cell(150, 4.1, "Petition-Pre Assigned Identification Number Application", 1 ,1, 'C');
    $this->SetX(37);
    $this->SetFont('Arial','B',8.2);
    $this->Cell(150, 4, "PLEASE FILL OUT ENTIRE FORM", 1, "LRB", 'C');

		// Arial 8     
    $this->SetFont('Arial','',8);
	  $this->SetXY(109, 38); $this->Cell(50,2.5, "Name of Party or Independent Body", 0, 0,'L');
    $this->SetXY(80, 60); $this->Cell(50, 4, "Petition Type:", 1, 1, 'L');		
    
    $this->SetXY(80, 64); 
    $this->Cell(34, 4, "Designating", 1, 0, 'L');		
    $this->Cell(34, 4, "Independent Nominating", 1, 0, 'L');		
    $this->Cell(34, 4, "Opportunity to Ballot", 1, 0, 'L');		
    
   	$this->SetXY(10, 90); $this->MultiCell(12, 4, "Date of Event:", 0, 'C');		
   	$this->SetXY(10, 100); $this->Cell(10, 10, "Quantity", 0, 0,'C');		
   	$this->SetXY(10, 115); $this->Cell(15, 8, "Bronx", 1, 0, 'C');		
    $this->SetXY(10, 123); $this->Cell(15, 8, "New York", 1, 0, 'C');		
    $this->SetXY(10, 131); $this->Cell(15, 8, "Kings", 1, 0, 'C');		
    $this->SetXY(10, 139); $this->Cell(15, 8, "Queens", 1, 0, 'C');		
    $this->SetXY(10, 147); $this->Cell(15, 8, "Richmond", 1, 0, 'C');		
    $this->SetXY(10, 155); $this->Cell(15, 8, "Total", 1, 0, 'C');		
   	$this->SetXY(80, 100); $this->Cell(120, 4, "Applicant", 1, 0,'C');
   	$this->SetXY(80, 107); $this->Cell(120, 4, "Name:", 0, 0,'L');		
   	$this->SetXY(80, 116); $this->Cell(120, 4, "Address:", 0, 0,'L');		
		$this->SetXY(80, 131); $this->Cell(120, 4, "Representing:",0, 0,'L');		
		$this->SetXY(80, 140); $this->Cell(120, 4, "Applicant Signature",0, 0,'L');
 		$this->SetXY(80, 170); $this->Cell( 25, 4, "Processed by", 1, 0, 'L');		
  	$this->SetXY(10, 180); $this->Cell( 10, 4, "Pre Assigned Identification Numbers", 0, 0, 'L');		

		// Arial 8 BOLD  
    $this->SetFont('Arial','B',8);
    $this->SetXY(15, 40); $this->Cell( 11, 4, "EVENT",0 ,0, 'L');		
 		$this->SetXY(84, 163.5);  $this->MultiCell(60, 3, "Check here if petition is filed without a Petition ID Sticker", 0, 'C');		
 		
 		// Arial 10 BOLD
 		$this->SetFont('Arial','B',10);
    $this->SetXY(105, 107);  $this->Cell(120, 4, $this->PrintName, 0, 0,'L');		
    $this->SetXY(105, 116);  $this->Cell(120, 4, $this->AddressLine1, 0, 0,'L');
    $this->SetXY(105, 123);  $this->Cell(120, 4, $this->AddressLine2, 0, 0,'L');	
    $this->SetXY(105, 131);  $this->Cell(120, 4, $this->Representing, 0, 0,'L');
    
		// Arial 16 BOLD
 		$this->SetFont('Arial','B',16);
    $this->SetXY(120, 165); $this->Cell(120, 4,$this->PetWithoutID, 0, 0,'C'); ;
   
		// Arial 18 BOLD     
    $this->SetFont('Arial','B',18);
    $this->SetXY(30, 40); $this->Cell( 50, 15, $this->Election, 1 ,0, 'C');		
  	$this->SetXY(110, 40.5); $this->Cell( 80, 10, $this->PartyName, 1 ,0, 'L');		
  
		$this->SetXY(80, 68); 
		$this->Cell(34, 10, $this->XonDesign, 1, 0, 'C');		
		$this->Cell(34, 10, $this->XonIndepend, 1, 0, 'C');		
		$this->Cell(34, 10, $this->XonOpportunity, 1, 0, 'C');		

		$this->SetXY(27, 89); $this->Cell(34, 10, $DatePrintEvent, 0, 0, 'C');		

    $this->SetXY(25, 115); $this->Cell(15, 8, $this->TotalBX, 1, 0, 'C');	
    $this->SetXY(25, 123); $this->Cell(15, 8, $this->TotalNY, 1, 0, 'C');	
    $this->SetXY(25, 131); $this->Cell(15, 8, $this->TotalKG, 1, 0, 'C');	
    $this->SetXY(25, 139); $this->Cell(15, 8, $this->TotalQN, 1, 0, 'C');	
    $this->SetXY(25, 147); $this->Cell(15, 8, $this->TotalRC, 1, 0, 'C');	
    $this->SetXY(25, 155); $this->Cell(15, 8, $this->Total, 1, 0, 'C');	
	
	
	
    $this->SetFont('Arial','',8);  
   	$this->Rect(10, 107, 30, 8, 'FD');
		$this->Rect(80, 104, 120, 66, 'D');
		$this->Rect(10, 184, 190, 74, 'D');
		
	  $this->Line(24, 98, 63, 98);
    $this->Line(105, 111, 200, 111);		
    $this->Line(105, 120, 200, 120);		
    $this->Line(105, 127, 200, 127);		
    $this->Line(105, 135, 200, 135);	
		$this->Line(105, 174, 105, 184);  // Processed By Line down
		$this->Line(150, 163, 150, 170);  
		$this->Line(200, 170, 200, 184); 
	 	$this->Line(80, 144,  200, 144); // Under Applicant Signature
	 	$this->Line(80, 163,  200, 163); // Above Check Here.
	 	$this->Line(10, 244,  200, 244); // Underneather Check HEre
	 	$this->Line(10, 199,  200, 199); 
	 	$this->Line(10, 214,  200, 214); 
	 	$this->Line(10, 229,  200, 229); 
	 	$this->Line(10, 244,  200, 244); 
	 	
			
 		$this->SetTextColor(242);
 		$this->SetFont('Arial','', 45);
		$this->SetXY(100, 153 );
		$this->Write(0, 'Sign Here');
		$this->SetTextColor(0);
	}

	// Page footer
	function Footer()	{
		
		if (! empty ($this->BarCode)) {
			$this->Code128(160,0, $this->BarCode, 50,10);
		}

		$this->SetXY(10, -20);
		$this->SetFont('Arial','B',10);
		$this->MultiCell(190, 4.5, "Pursuant to NYC Board of Elections Petition Rules: A pre assigned " . 
														"petition volume identification number shall be used only by the candidate " .
														"or applicant named in the application. Petition volume identification " .
														"numbers are not transferable or assignable.", 1, 'L');
	}
	
}

?>