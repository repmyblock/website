<?php
require($_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/fpdf181/fpdf.php');

class PDF extends FPDF {
	
	var $angle=0;
	var $Col1 = 6; var $Col2 = 61; var $Col3 = 150;
	var $SizeCol1 = 55; var $SizeCol2 = 89; var $SizeCol3 = 59;
  var $Line_Left = 6; var $Line_Right = 209; var $Line_Col1 = 61; var $Line_Col2 = 150;
	//$Botton_Corner_Y = 0;
	 
	// Page header
	function Header()	{

		if (! empty ($this->Watermark)) {
			$this->SetFont('Arial','B',50);
    	$this->SetTextColor(255,192,203);
   		$this->RotatedText(35,190, $this->Watermark, 45);
   		$this->RotatedText(40,210, "Election will be held in 2020", 45);
   		$this->SetTextColor(0,0,0);
		}
		
    $this->SetFont('Arial','B',24);
    $this->Ln(15);
    $this->Cell(0,0, "CERTIFICATE OF ACCEPTANCE",0,0,'C');
    $this->Ln(13);
    $this->Cell(0,0, strtoupper($this->party) . " PARTY",0,0,'C');		
    $this->Ln(15);    
    
		$YLocation_new = $Top_Corner_Y = $this->GetY() - 1.5;   
 		$this->SetY($Top_Corner_Y); 
  	$MyTop = $YLocation = $this->GetY();
  
  	$this->Line($this->Line_Left, $YLocation - 0.1,  $this->Line_Right, $YLocation - 0.1); 
  	$this->Ln(2.8);
	    			
    $YLocation = $this->GetY() - 1.5 ;
    
    $Botton_Corner_Y = $this->GetY();


 		$this->Ln(10);  
		$this->SetFont('Arial','', 18);  
		$this->SetX(10);
		$this->MultiCell(190, 8,  "I, " . $this->CandidateName . ", residing at " . $this->CandidateAddress . 
															" having been designated/nominated by the " . $this->party . 
															" Party, as a candidate for the office of " . $this->PublicOffice . 
															", do hereby accept such designation/nomination and consent to be " . 
															"such candidate of such party at a " . $this->TypeOffice . 
															" election to be held on " . $this->ElectionDate . ".");
   	
  
		$this->SetXY(10, 135); 
		$this->MultiCell(0, 10,  "____________________\nDate");
		$this->SetXY(110, 135); 
		$this->MultiCell(0, 10,  "_________________________\nSignature of Candidate");
		 		
		 		
   	$this->Ln(7);
  
   	$this->SetX(10); $this->MultiCell(0, 10,  "State of New York");
   	$this->SetX(10); $this->MultiCell(0, 8,  "County of " . $this->PubNotaryCounty . " : ss:");
		$this->Ln(4.5);
   	
 	 	$this->SetX(10); 
   	$this->MultiCell(190, 8,  "On this " . $this->PubNotaryDay . " day of " . $this->PubNotaryMonth . 
   														", before me personally appeared " . $this->CandidateName . ", to me known and known " .
   														" to me to be the individual described therein, and who executed the foregoing instrument, " .
   														" and acknowledged to me that he/she executed the same.");
   	
      
		$this->SetXY(110, 245); 
		$this->MultiCell(0, 10,  "_________________________\nNotary Public");
   
		
    
	}

	// Page footer
	function Footer()	{
		
		$this->SetY(-37);
   	$YLocation = $this->GetY() - 1.9;
		
	
		
		


	}
	
	function Rotate($angle,$x=-1,$y=-1) {
    if($x==-1) $x=$this->x;
    if($y==-1) $y=$this->y;
    if($this->angle!=0) $this->_out('Q');
    $this->angle=$angle;
    if($angle!=0) {
      $angle*=M_PI/180;
      $c=cos($angle);
      $s=sin($angle);
      $cx=$x*$this->k;
      $cy=($this->h-$y)*$this->k;
      $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
    }
  }
    
  function RotatedText($x, $y, $txt, $angle) {
	  //Text rotated around its origin
	  $this->Rotate($angle,$x,$y);
	  $this->Text($x,$y,$txt);
	  $this->Rotate(0);
	}
	
	function _endpage() {
    if($this->angle!=0) {
      $this->angle=0;
      $this->_out('Q');
    }
    parent::_endpage();
	}
	
}

?>