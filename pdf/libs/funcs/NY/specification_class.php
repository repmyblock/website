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

		$i= 0;

    $this->SetFont('Arial','B',10);

    $this->Cell(120,5, "Part A",1,0,'C');
    $this->Cell(20,5, "Part B",1,0,'C');
    $this->Cell(30,5, "Part C",1,0,'C');
    $this->Cell(40,5, "Part D",1,0,'C');
    $this->Cell(50,5, "Part E",1,0,'C');
    
    $this->SetFont('Arial','',8);
    $this->Ln(14);   
    
    $this->Cell(120,5, "For use by ojbector only",1,0,'C');
    $this->Cell(20,5, "Board of elections use only",1,0,'C');
    $this->Cell(30,5, "Court Appointed Referee use only",1,0,'C');
    $this->Cell(40,5, "Attroney Stipulations",1,0,'C');
    $this->Cell(50,5, "Decision & Order of Supreme Court",1,0,'C');
    
    $this->Ln(14); 
    $this->Cell(120,5, "Line No.     SPECIFICATION OF OJECTIONS TO SIGNATURES",1,0,'C');
    $this->Cell(10,5, "AS",1,0,'C');
    $this->Cell(5,5, "NAS",1,0,'C');
    $this->Cell(5,5, "NJ",1,0,'C');
    $this->Cell(5,5, "RTB",1,0,'C');
    $this->Cell(25,5, "COMMENT",1,0,'C');
    
    $this->Cell(5,5, "AFF",1,0,'C');
    $this->Cell(5,5, "OVR",1,0,'C');
    $this->Cell(5,5, "(+/-)",1,0,'C');
    $this->Cell(25,5, "REASON OR COMMENT",1,0,'C');
    $this->Cell(5,5, "EXC",1,0,'C');

    $this->Cell(5,5, "IN",1,0,'C');
    $this->Cell(5,5, "OUT",1,0,'C');
   
    $this->Cell(5,5, "AFF",1,0,'C');
    $this->Cell(5,5, "OVR",1,0,'C');
    $this->Cell(5,5, "(+/-)",1,0,'C');
      
		$this->Ln(24);   
    $this->SetFont('Arial','B',8);
    
	 	$this->Ln(4.5);
   	
 	 	
	}

	// Page footer
	function Footer()	{
		$this->SetFont('Arial','',8);
		
		$this->MultiCell(30, 5, "Specifications of Ojbections to Winess Statement and Witness Indentification Information", 1);
		
		
		$this->MultiCell(30, 5, "BOE INDENTIFICATION #", 1);
		$this->MultiCell(30, 5, "SHEET #", 1);
		
		$this->MultiCell(30, 5, "Number of Signatures CLAIMED", 1);
		$this->MultiCell(30, 5, "Number of Invalid Signatures", 1);
		$this->MultiCell(30, 5, "Number of VALID Signatures", 1);
		
		$this->MultiCell(30, 5, "WITNESS RULLINGS ONLY", 1);
		$this->MultiCell(30, 5, "Number of Signatures Files", 1);
		$this->MultiCell(30, 5, "Invivalid in Signatures Aera", 1);
		$this->MultiCell(30, 5, "Invalid Witness Statement", 1);
		$this->MultiCell(30, 5, "Total VALID Signatures", 1);
		$this->MultiCell(30, 5, "NJ", 1);
		$this->MultiCell(30, 5, "RTB", 1);
		
		
		$this->MultiCell(30, 5, "RTB", 1);
		
		$this->MultiCell(30, 5, "AS", 1);
		$this->MultiCell(30, 5, "NAS/NJ/RTB", 1);


		$this->MultiCell(30, 5, "[ ] ASs [ ] NASs, NJs & RTBs [ ] Denovo", 1);
		$this->MultiCell(30, 5, "[ ] Ass, NASs, NJs & RTBs Simultaneously", 1);
		$this->MultiCell(30, 5, "NAME(S) OF CANDIDATE(S)", 1);

		$this->MultiCell(30, 5, "AS", 1);
		$this->MultiCell(30, 5, "NAS/NJ/RTB", 1);
		
		$this->MultiCell(30, 5, "REFEREE:", 1);
		$this->MultiCell(30, 5, "DATE:", 1);

		$this->MultiCell(30, 5, "PAGE NO. ", 1);		
		$this->SetY(-7);
		
		$this->SetFont('Arial','I', 7); 
		$this->MultiCell(10, 5, $this->PetitionsGroups);
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