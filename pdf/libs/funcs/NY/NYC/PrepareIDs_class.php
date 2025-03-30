<?php
require $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/script88/PDF_Code128.php';

class PDF_Multi extends PDF_Code128 {
	 
	// Page header
	function Header()	{
		
#		$this->SetLineWidth(0.4);
		
		$this->SetXY(20, 5); 
    $this->BarCode = "NY2500861";
		$this->Code128(6, 10, $this->BarCode, 50, 10);
		$this->SetFont('Arial','', 15);
		$this->SetXY(25, 115); $this->Cell(24, 8, "*" . $this->BarCode . "*", 0, 0);	
   	
#   $this->SetTextColor(242); 		
#		$this->SetXY(100, 153 ); $this->Write(0, 'Sign Here');
#		$this->SetTextColor(0);
	}

	// Page footer
	function Footer()	{
		// Nothing in the footer
	}
	
}

?>