<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/fpdf181/fpdf.php');

class PDF_RMB_VoterList extends FPDF {
	
	var $angle=0;
	var $Col1 = 6; var $Col2 = 61; var $Col3 = 150;
	var $SizeCol1 = 55; var $SizeCol2 = 89; var $SizeCol3 = 59;
  var $Line_Left = 6; var $Line_Right = 209; var $Line_Col1 = 61; var $Line_Col2 = 150;
	//$Botton_Corner_Y = 0;
	 
	// Page header
	function Header()	{
		
		// The Logo
		$this->Image('../pics/RepMyBlock.png', 5, 5, 0);

		if (! empty ($this->Watermark)) {
			$this->SetFont('Arial','B',50);
    	$this->SetTextColor(255,192,203);
   		$this->RotatedText(35,190, $this->Watermark, 45);
   		$this->RotatedText(40,210, "Election will be held in 2023", 45);
   		$this->SetTextColor(0,0,0);
		}
		
    $this->SetFont('Arial','B',24);
    $this->SetXY(33, 8.5);
    $this->Cell(0,0, "Rep My Block",0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','',12);
		$this->Cell(0,0, "Objection list for Petition Volume " . $this->TextPetitionID,0,0,'R');
    $this->Ln(11);    
    $this->SetFont('Arial','',8);
    $this->SetXY(51,16);
    $this->SetXY($this->Text_PubDate_XLoc, 6);
    $this->SetFont('Arial','UB',8);
    $this->Write(0, "List prepared on ");
    $this->SetFont('Arial','U',8);
    $this->Write(0, $this->Text_PubDate);
    $this->Ln(22);  			
			
	}

	// Page footer
	function Footer()	{
		
		$this->SetY(-9);
   	$YLocation = $this->GetY() + 1.1;		
		$this->SetFont('Arial','',8);
   	//$this->Write(0, "The voters listed in red are inactive in the voter roll. " .
		//								"You can collect the signature, but don't count them toward the signature threshold. ");
   	$this->Ln(3.9); 
		$this->Line($this->Line_Left, $YLocation + 0.8, $this->Line_Right, $YLocation + 0.8);
		//$this->SetX($this->Line_Left);
//$BoxWide = ($this->Line_Right / 3) - 1.2;
		//$this->Cell($BoxWide, 0, $this->LeftText, 0, 0, 'L');	
	
		$this->SetFont('Arial','B',8);
		$this->Cell($BoxWide, 0,'Page ' . $this->PageNo(). ' of {nb}',0,0,'C');	
		
		//$this->SetFont('Arial','',8);	
		//$this->Cell($BoxWide, 0, $this->RightText, 0, 0, 'R');	
			
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