<?php
require $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/script88/PDF_Code128.php';

class PDF extends FPDF {

	function Header()	{
		
		$PageHeight = $this->GetPageHeight();
		$PageWidth = $this->GetPageWidth();
		
		$LocNoPostage = $PageWidth - 60;
		$HMiddlePage = $PageHeight / 2;
		$WMiddlePage = $PageWidth / 2;

		$FontSize = 10;
    $this->SetFont('Arial','', $FontSize);  
    $LengthNoPostage = $this->GetStringWidth("UNITED STATES");
		$StringLenght = $this->GetStringWidth("BUSINESS REPLY MAIL");
		
		$this->SetLineWidth(0.4);
		
 	 	$this->SetFont('Arial','B',8);
    $this->SetXY(5, 5);  $this->Cell(20, 0.25, "Page: Height: $PageHeight - Width: $PageWidth - String: $LengthNoPostage", 0, 0,'L');		


		//$FontSize = 5;
    $this->SetFont('Arial','', $FontSize);  
    $LengthNoPostage = $this->GetStringWidth("UNITED STATES") + 5.671;
    $this->SetXY($PageWidth - ($LengthNoPostage) - 10, 20); 
    $this->MultiCell($LengthNoPostage, $FontSize, "NO POSTAGE\nNECESARY\nIF MAILED\nIN THE\nUNITED STATES", 0, 'C');		
    $this->Rect($PageWidth - ($LengthNoPostage) - 10, 14, ($LengthNoPostage), 5 * ($FontSize + 2), 'D');

		// I must make the bars
		for($i = 20; $i < 140; $i += 10) {
			$this->Rect($PageWidth - ($LengthNoPostage) - 10, 5 * ($FontSize + 2) + $i, ($LengthNoPostage), 5, 'FD');
		}

		// FIM C: || | | || (110101011)
		$this->Rect($PageWidth - 150, 0, 2.25, 45, 'F'); // 1
		$this->Rect($PageWidth - 154.75, 0, 2.25, 45, 'F'); // 1
		//$this->Rect($PageWidth - 159.50, 0, 2.25, 45, 'D'); // 0
		$this->Rect($PageWidth - 164.25, 0, 2.25, 45, 'F'); // 1
		//$this->Rect($PageWidth - 169, 0, 2.25, 45, 'D'); // 0
		$this->Rect($PageWidth - 173.75, 0, 2.25, 45, 'F'); // 1
		//$this->Rect($PageWidth - 178.5, 0, 2.25, 45, 'D'); // 0
		$this->Rect($PageWidth - 183.25, 0, 2.25, 45, 'F'); // 1
		$this->Rect($PageWidth - 188, 0, 2.25, 45, 'F'); // 1


		//$this->Rect($PageWidth - 170, 0, 2.25, 45, 'FD');
		//$this->Rect($PageWidth - 180, 0, 2.25, 45, 'FD');
		//$this->Rect($PageWidth - 216, 0, 2.25, 45, 'FD');

 		// Arial 10 BOLD
 		$this->SetFont('Arial','',20);
    $this->SetXY(0, $HMiddlePage);  $this->Cell($PageWidth, 4, "BUSINESS REPLY MAIL", 0, 0,'C');		
        
    $this->SetFont('Arial','',8);
    
    $string = "FIRST-CLASS MAIL" . "PERMIT NO. " . $this->PermitNumber . " " . $this->PermitCity;
    
    $this->SetXY(0, $HMiddlePage + 4);  $this->Cell($PageWidth, 4, "FIRST-CLASS MAIL PERMIT NO. 4339 NEW YORK NY", 0, 0,'C');
    $this->SetXY(0, $HMiddlePage + 8);  $this->Cell($PageWidth, 4, "POSTAGE WILL BE PAID BY ADDRESSEE", 0, 0,'C');
    

    
		// Arial 16 BOLD
 	  $this->SetFont('Arial','',8);  
   	//$this->Rect(10, 107, 30, 8, 'FD');
		//$this->Rect(80, 104, 120, 66, 'D');
		//$this->Rect(10, 184, 190, 74, 'D');
		
	 // $this->Line(24, 98, 63, 98);
   // $this->Line(105, 111, 200, 111);		
   // $this->Line(105, 120, 200, 120);		
  		
	// $this->SetTextColor(242);
	//$this->SetTextColor(0);
	}

	// Page footer
	function Footer()	{
		
		if (! empty ($this->BarCode)) {
			$this->Code128(160,0, $this->BarCode, 50,10);
		}
		
		$this->Write(0, 'Mail Bar Code');


	}
	
}

function PrintFim($Pattern) {
	
	switch($Pattern) {
		
		case "A": 
		// fIM A: ||  |  || (110010011)
		// FIM B: | || || | (101101101)
		// FIM C: || | | || (110101011)
		// FIM D: ||| | ||| (111010111)
		// FIM E: | |   | | (101000101)
			
			break;
		case "B":
		
			break;
		case "C":
		
			break;
		case "D":
		
			break;
		case "E":
		
			break;
	}
	
	return;
		
}


?>