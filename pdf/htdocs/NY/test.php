<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/script88/PDF_Code128.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/fpdf_libs/fpdf_merge.php';

class PDF extends FPDF {
	protected $col = 0; // Current column
	protected $y0;      // Ordinate of column start

	function Header() {
	  // Page header
	  global $title;

	  $this->SetFont('Arial','B',15);
	  $w = $this->GetStringWidth($title)+6;
	  $this->SetX((210-$w)/2);
	  $this->SetDrawColor(0,80,180);
	  $this->SetFillColor(230,230,0);
	  $this->SetTextColor(220,50,50);
	  $this->SetLineWidth(1);
	  $this->Cell($w,9,$title,1,1,'C',true);
	  $this->Ln(10);
	  
	  // Save ordinate
	  $this->y0 = $this->GetY();
	}

}

class PDF2 extends FPDF {
	protected $col = 0; // Current column
	protected $y0;      // Ordinate of column start

	function Footer()	{
    // Page footer
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->SetTextColor(128);
    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
	}
	
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World!');
$bla = $pdf->Output('s');

$pdf = new PDF2();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World 2!');
$blo = $pdf->Output('s');

$merge = new FPDF_Merge();
//echo "<TABLE BORDER=1><TR VALIGN=TOP><TD>";
$merge->add("doc.pdf");
//echo "</TD><TD>";
$merge->add_string($bla);
//echo "</TD></TR></TABLE>";

$merge2 = new FPDF_Merge();
$merge2->add_string($blo);
$merge2->add_string($bla);
$merge2->output();
?>


?>