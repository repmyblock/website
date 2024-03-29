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

		if (! empty ($this->Watermark)) {
			$this->SetFont('Arial','B',50);
    	$this->SetTextColor(255,192,203);
   		$this->RotatedText(35,190, $this->Watermark, 45);
   		$this->RotatedText(40,210, "Election will be held in 2020", 45);
   		$this->SetTextColor(0,0,0);
		}
		
    $this->SetFont('Arial','B',24);
    $this->Ln(25);
    $this->Cell(0,0, $this->typepetition . "PETITION COVER SHEET",0,0,'C');
    $this->Ln(13);
    $this->Cell(0,0, strtoupper($this->party) . " PARTY",0,0,'C');		
    $this->Ln(15);    
    
    $this->SetFont('Arial','B',8);
		  
		
    
		$YLocation_new = $Top_Corner_Y = $this->GetY() - 1.5;   
 		$this->SetY($Top_Corner_Y); 
  	$MyTop = $YLocation = $this->GetY();
  
  	$this->Line($this->Line_Left, $YLocation - 0.1,  $this->Line_Right, $YLocation - 0.1); 

    $this->SetFont('Arial','B', 8);
    $this->SetXY($this->Col1, $YLocation );
    $this->MultiCell($this->SizeCol1, 4, "NAME" . strtoupper($this->PluralCandidates) . " OF CANDIDATE" . strtoupper($this->PluralCandidates), 0, 'C');

    $this->SetXY($this->Col2, $YLocation );
    $this->MultiCell($this->SizeCol2, 4, $this->RunningForHeading[$this->PositionType[0]], 0, 'C');

	 	$this->SetXY($this->Col3, $YLocation );
	 	$this->MultiCell($this->SizeCol3, 4, "PLACE" . strtoupper($this->PluralCandidates) . " OF RESIDENCE", 0, 'C');

  	$this->SetFont('Arial','',8);
  	$Prev_PartyPosition = $this->PositionType[$i];

		$YLocation = $this->GetY() + 0.5;
    			
   
  	$this->Ln(2.8);
	    			
	  $this->Line($this->Line_Left, $YLocation - 0.1, $this->Line_Right, $YLocation - 0.1); 
 			
   	$this->SetFont('Arial','B',11);
		$this->SetXY($this->Col1, $YLocation + 0.3 );
		$this->MultiCell($this->SizeCol1, 5, $this->Candidate[$i], 0, 'C', 0);
		if ( $YLocation_new < $this->GetY()) { $YLocation_new = $this->GetY(); }

		$this->SetFont('Arial','', 11);   	   		
		$this->SetXY($this->Col2, $YLocation );
 		$this->MultiCell($this->SizeCol2, 5, $this->RunningFor[$i], 0, 'C', 0);
		if ( $YLocation_new < $this->GetY()) { $YLocation_new = $this->GetY(); }
								
		$this->SetXY($this->Col3, $YLocation );
		$this->MultiCell($this->SizeCol3, 5, $this->Residence[$i], 0, 'C', 0);
		if ( $YLocation_new < $this->GetY()) { $YLocation_new = $this->GetY(); }

									
	/*		
	
		
 					$pdf->Candidate[$TotalCandidates] =  $key["CandidateName"];
 					$pdf->RunningFor[$TotalCandidates] =  $key["CandidatePositionName"];
					$pdf->Residence[$TotalCandidates] = $key["CandidateResidence"];
					$pdf->PositionType[$TotalCandidates] = $key["PositionType"];					
		
			$PetitionData[$var["CanPetitionSet_ID"]]["TotalPosition"] = $var["CandidateElection_Number"];
			$PetitionData[$var["CanPetitionSet_ID"]]["PositionType"]	= $var["CandidateElection_PositionType"];
			$PetitionData[$var["CanPetitionSet_ID"]]["CandidateName"]	= $var["Candidate_DispName"];
			$PetitionData[$var["CanPetitionSet_ID"]]["CandidatePositionName"]	= $var["CandidateElection_PetitionText"];
			$PetitionData[$var["CanPetitionSet_ID"]]["CandidateResidence"] = $var["Candidate_DispResidence"];
	*/
									
		$YLocation = $YLocation_new + 0.7;   
		$this->Line($this->Line_Left, $YLocation - 0.1, $this->Line_Right, $YLocation - 0.1); 
		
	 	$this->SetY($YLocation);	
	 	
	 	// Here I need to put the pieces.
	 	$this->Line($this->Line_Left, $MyTop - 0.1, $this->Line_Left, $YLocation - 0.1); 
	 	$this->Line($this->Line_Col1, $MyTop - 0.1, $this->Line_Col1, $YLocation - 0.1); 
	 	$this->Line($this->Line_Col2, $MyTop - 0.1, $this->Line_Col2, $YLocation - 0.1); 
	 	$this->Line($this->Line_Right, $MyTop - 0.1, $this->Line_Right, $YLocation - 0.1); 
	 	
			
 	 
    $YLocation = $this->GetY() - 1.5 ;
    
    $Botton_Corner_Y = $this->GetY();

 		$this->Ln(8);  
		$this->SetFont('Arial','', 15);  
		$this->MultiCell(0, 10,  "Total Number of Volumes in the Petition: " . $this->NumbersOfVolumesPetitions);
		
		$this->Ln(3);  
		
   	$this->MultiCell(0, 6, "Identification Numbers:");
 
	 	$this->SetFont('Arial','', 12);
 		$this->SetX(20);
   	$this->MultiCell(0, 5,  $this->VolumesIDs, '', 'L');
   	
   	$this->Ln(4.5);
   	$this->SetFont('Arial','B', 12);  
   	$this->MultiCell(0, 5,  "The petition contains the number, or in excess of the number, " . 
   												"of valid signatures required by the Election Law.");
		$this->Ln(4.5);
   	
   	$this->SetFont('Arial','', 12);  
   	
   	$this->SetX(20);
   	$this->MultiCell(0, 5, "Contact person to correct deficiencies: " . $this->Person);
		$this->SetX(20);
   	$this->MultiCell(0, 5, "Residence address: ");
 		$this->SetX(40);
   	$this->MultiCell(0, 5,  $this->Address, '', 'L');
		$this->SetX(20);
   	$this->MultiCell(0, 5, "Phone: " . $this->Phone);
		$this->SetX(20);
   	$this->MultiCell(0, 5, "Email: " . $this->Email);
   	
   	$this->Ln(4.5);
   	
 	 	$this->SetFont('Arial','B', 12); 
   	$this->MultiCell(0, 5,  "I hereby authorize that notice of any determination made by the Board of Elections " . 
   												"be transmitted to the person name above.");
   	
  	#$this->Ln(1);
		if ( $this->AmendedmentCoverSheet == 'yes' ) {
			$this->Ln(7);
			$this->MultiCell(0, 5,  "This is to certify that I am authorized to file this amended cover sheet.");			
		}
    
   
		$this->Ln(4.5);
		$this->MultiCell(0, 10,  "Candidate or Agent");
   
   
   	$this->Ln(15);
		$this->MultiCell(0, 1,  "___________________________________________");
		
		$this->SetFont('Arial','', 9);
		$this->MultiCell(0, 10,  $this->SignatureLine);
	}

	// Page footer
	function Footer()	{
		
		
		
		
		
		$this->SetY(-7);
		
		$this->SetFont('Arial','I', 7); 
		$this->MultiCell(0, 5, $this->PetitionsGroups);
		


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