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
		
    $this->SetFont('Arial','B',18);
    $this->Ln(15);
    $this->Cell(0,0, "Proxy Request to be removed from mailing lists.",0,0,'C');
    $this->Ln(13);
    $this->SetFont('Arial','B',8);
		  
		
    
		$YLocation_new = $Top_Corner_Y = $this->GetY() - 1.5;   
 		$this->SetY($Top_Corner_Y); 
  	$MyTop = $YLocation = $this->GetY();
  
  	$this->Line($this->Line_Left, $YLocation - 0.1,  $this->Line_Right, $YLocation - 0.1); 

    $this->SetFont('Arial','B',8);
    $this->SetXY($this->Col1, $YLocation );
    $this->MultiCell($this->SizeCol1, 4, "NAME" . strtoupper($this->PluralCandidates) . " OF CANDIDATE" . strtoupper($this->PluralCandidates), 0, 'C');

    $this->SetXY($this->Col2, $YLocation );
    $this->MultiCell($this->SizeCol2, 4, $this->RunningForHeading[$this->PositionType[$i]], 0, 'C');

	 	$this->SetXY($this->Col3, $YLocation );
	 	$this->MultiCell($this->SizeCol3, 4, "PLACE" . strtoupper($this->PluralCandidates) . " OF RESIDENCE", 0, 'C');

		$this->MultiCell(0, 5,  "RepMyBlock\n" .
															"C/O Theo Chino\n" . 
															"640 Riverside Drive, 10B\n" .
															"New York, NY 10031");

  	$this->SetFont('Arial','',8);
  	$Prev_PartyPosition = $this->PositionType[$i];
		$this->MultiCell(0, 10,  "RE: Request to be Removed from Mailing Lists");
		
	 	
			
 	 
    $YLocation = $this->GetY() - 1.5 ;
    
    $Botton_Corner_Y = $this->GetY();


 		$this->Ln(15);  
		$this->SetFont('Arial','', 12);  
		$this->MultiCell(0, 10,  "Dear Sir/Madam:");


 		$this->MultiCell(0, 10,  "I am writing to request that my name removed from any " . 
 															"and all mailing lists for unsolicited mail, effective immediately. " .
 															"I am currently receiving unsolicited mail at:");

		$this->MultiCell(0, 10,  "Other persons living at this address who also request hat their names " . 
														 "be removed immediately from any and all mailing lists are [Names of family members]. " . 
														 "If this request is not sufficient for removing my name or those of my listed family members, " .
														 "please notify me promptly of any other procedures I need to follow. " . 
														 "I can be reached at the address listed above. Thank you for your attention " .
														 "to this matter.");


		$this->MultiCell(0, 10,  "[Signature]");
		$this->MultiCell(0, 10,  "[Printed name]");

   #$this->Ln(1);
    
   
		$this->Ln(4.5);
		$this->MultiCell(0, 10,  "Candidate or Agent");
   
		
    
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