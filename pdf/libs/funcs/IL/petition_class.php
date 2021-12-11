<?php

#require($_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/fpdf181/fpdf.php');
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
		
		$this->DemoPrint = NULL;
		$this->county = "Ohio";

		$YLocation = $this->GetY();
		$this->SetTextColor(0);
		
		if (! empty ($this->Watermark)) {
			$this->SetFont('Arial','B',50);
    	$this->SetTextColor(255,192,203);
   		$this->RotatedText(35,190, $this->Watermark, 45);
   		$this->RotatedText(40,210, "Election will be held in 2022", 45);
   		$this->SetTextColor(0,0,0);
		}

		if (! empty ($this->DemoPrint)) {		
			$this->SetXY(125, 1);
			$this->SetFont('Arial', 'B', 15);
			$this->SetTextColor(0,0,255);
			$this->Link(125, 1, 90, 10, "https://repmyblock.nyc/exp/multipetition/propose");
 	   	$this->MultiCell(90, 5, "Click here for more information on how to participate.", 0, 'R');
 	   	$this->SetTextColor(0); 	   	
 	   	$this->SetXY($this->Col1, $YLocation);
		}
		
		$this->SetFont('Arial','',10);
		
    $this->SetFont('Arial','B',12);
    $this->Cell(0,0, "STATE CENTRAL COMMITTEEMAN PETITION ", 0, 0, 'C');
    $this->Ln(4);
    $this->Cell(0,0, $this->party . " Party Primary Election",0,0,'C');
    $this->Ln(3);    
    
   	$this->SetFont('Arial','',8);
		  
		$this->MultiCell(0,2.8, "We, the undersigned, members of and affiliated  with  the ____________________ Party and " . 
														"qualified primary electors of the ____________________Party, in the _______________ Congressional " .
														"District of the State of Illinois, do hereby petition that ________________________________________ " .
														"who  resides  at  ___________________________________  in  the  City,  Village,  Unincorporated " .
														"Area  of  _________________________  (if  unincorporated,  list  municipality  that  provides  " . 
														"postal  service)  Zip  Code  __________,  County of ____________________  and  State  of  Illinois,  " .
														"shall  be  a  candidate  of  the  ______________________  Party  for  election    to  the  office  of " .
														"STATE CENTRAL COMMITTEEMAN of the State of Illinois, for the __________ Congressional District to be " .
														"voted for at the primary election to be held on ________________________ (date of election). ");
		
			$this->Ln(2.8);												
		
    	
    	
    	
		$YLocation_new = $Top_Corner_Y = $this->GetY() - 1.5;   
	
 		$this->SetY($Top_Corner_Y);
 		
 		/*
 		### Just to get a blank petition
 		if ( $this->NumberOfCandidates == 0) {
 			
 		 	$MyTop = $YLocation = $this->GetY();
    			
    	// This is the heading of the petition.
	  	$this->Line($this->Line_Left, $YLocation - 0.1,  $this->Line_Right, $YLocation - 0.1); 
	    $this->SetFont('Arial','B',8);
	    $this->SetXY($this->Col1, $YLocation );
	    $this->MultiCell($this->SizeCol1, 4, "NAME" . strtoupper($this->PluralCandidates) . " OF CANDIDATE" . strtoupper($this->PluralCandidates), 0, 'C');
	    $this->SetXY($this->Col2, $YLocation );
	    $this->MultiCell($this->SizeCol2, 4, $this->RunningForHeading["party"], 0, 'C');
  	 	$this->SetXY($this->Col3, $YLocation );
  	 	$this->MultiCell($this->SizeCol3, 4, "PLACE" . strtoupper($this->PluralCandidates) . " OF RESIDENCE", 0, 'C');
    	$this->SetFont('Arial','',8);
    	$Prev_PartyPosition = $this->PositionType[$i];
  		$YLocation = $this->GetY() + 0.5;
	    			
	    // This are the empty stuff.
	    $this->Line($this->Line_Left, $YLocation - 0.1, $this->Line_Right, $YLocation - 0.1); 
 			
     	$this->SetFont('Arial','B',11);
 			$this->SetXY($this->Col1, $YLocation + 0.3 );
			$this->MultiCell($this->SizeCol1, 3.5, $this->Candidate[$i], 0, 'C', 0);
  		if ( $YLocation_new < $this->GetY()) { $YLocation_new = $this->GetY(); }
	
			$this->SetFont('Arial','', 9);   	   		
			$this->SetXY($this->Col2, $YLocation );
  		if ( $YLocation_new < $this->GetY()) { $YLocation_new = $this->GetY(); }
									
			$this->SetXY($this->Col3, $YLocation );
  		if ( $YLocation_new < $this->GetY()) { $YLocation_new = $this->GetY(); }

									
			$YLocation = $YLocation_new + 4.7;   
			$this->Line($this->Line_Left, $YLocation - 0.1, $this->Line_Right, $YLocation - 0.1); 
			
		 	$this->SetY($YLocation);	
		 	
		 	// Here I need to put the pieces.
		 	$this->Line($this->Line_Left, $MyTop - 0.1, $this->Line_Left, $YLocation - 0.1); 
		 	$this->Line($this->Line_Col1, $MyTop - 0.1, $this->Line_Col1, $YLocation - 0.1); 
		 	$this->Line($this->Line_Col2, $MyTop - 0.1, $this->Line_Col2, $YLocation - 0.1); 
		 	$this->Line($this->Line_Right, $MyTop - 0.1, $this->Line_Right, $YLocation - 0.1); 
		 	
			/*
 	   	$this->SetFont('Times','I',7);
 	   	$this->SetXY($this->Line_Left + 0.5, $YLocation );
	    $this->MultiCell(0, 2.8, 
	    	"I do hereby appoint " . $this->Appointments[$i] . " all of whom are enrolled voters of the " . $this->party . 
	    	" Party, as a committee to fill vacancies in accordance with the provisions of the Election Law.", 0);
	  
	    
	    $YLocation = $this->GetY() - 1.5 ;
	    $Botton_Corner_Y = $this->GetY();
 		}
 		 
 		  
    for ($i = 0; $i < $this->NumberOfCandidates; $i++) {
    	$MyTop = $YLocation = $this->GetY();	 
    	
    	//$YLocation += 1;
   
 			if ($this->PositionType[$i] != $Prev_PartyPosition) {
		  	$this->Line($this->Line_Left, $YLocation - 0.1,  $this->Line_Right, $YLocation - 0.1); 

		    $this->SetFont('Arial','B',8);
		    $this->SetXY($this->Col1, $YLocation );
		    $this->MultiCell($this->SizeCol1, 4, "NAME" . strtoupper($this->PluralCandidates) . " OF CANDIDATE" . strtoupper($this->PluralCandidates), 0, 'C');

		    $this->SetXY($this->Col2, $YLocation );
		    $this->MultiCell($this->SizeCol2, 4, $this->RunningForHeading[$this->PositionType[$i]], 0, 'C');

	  	 	$this->SetXY($this->Col3, $YLocation );
	  	 	$this->MultiCell($this->SizeCol3, 4, "PLACE" . strtoupper($this->PluralCandidates) . " OF RESIDENCE", 0, 'C');

	    	$this->SetFont('Arial','',8);
	    	$Prev_PartyPosition = $this->PositionType[$i];
    		$YLocation = $this->GetY() + 0.5;
	    }    
	    	    			
	    $this->Line($this->Line_Left, $YLocation - 0.1, $this->Line_Right, $YLocation - 0.1); 
 			
     	$this->SetFont('Arial','B',11);
 			$this->SetXY($this->Col1, $YLocation + 0.3 );
			$this->MultiCell($this->SizeCol1, 3.5, $this->Candidate[$i], 0, 'C', 0);
  		if ( $YLocation_new < $this->GetY()) { $YLocation_new = $this->GetY(); }
	
			$this->SetFont('Arial','', 9);   	   		
			$this->SetXY($this->Col2, $YLocation );
   		$this->MultiCell($this->SizeCol2, 3.5, $this->RunningFor[$i], 0, 'C', 0);
  		if ( $YLocation_new < $this->GetY()) { $YLocation_new = $this->GetY(); }
									
			$this->SetXY($this->Col3, $YLocation );
  		$this->MultiCell($this->SizeCol3, 3.5, $this->Residence[$i], 0, 'C', 0);
  		if ( $YLocation_new < $this->GetY()) { $YLocation_new = $this->GetY(); }
									
			$YLocation = $YLocation_new + 0.7;   
			$this->Line($this->Line_Left, $YLocation - 0.1, $this->Line_Right, $YLocation - 0.1); 
		 	$this->SetY($YLocation);	

		 	// Here I need to put the pieces.
		 	$this->Line($this->Line_Left, $MyTop - 0.1, $this->Line_Left, $YLocation - 0.1); 
		 	$this->Line($this->Line_Col1, $MyTop - 0.1, $this->Line_Col1, $YLocation - 0.1); 
		 	$this->Line($this->Line_Col2, $MyTop - 0.1, $this->Line_Col2, $YLocation - 0.1); 
		 	$this->Line($this->Line_Right, $MyTop - 0.1, $this->Line_Right, $YLocation - 0.1); 
		 	
			if (! empty ($this->Appointments[$i])) {
	 	   	$this->SetFont('Times','I',7);
 		   	$this->SetXY($this->Line_Left + 0.5, $YLocation );
	  	  $this->MultiCell(0, 2.8, 
	    		"I do hereby appoint " . $this->Appointments[$i] . " all of whom are enrolled voters of the " . $this->party . 
	    		" Party, as a committee to fill vacancies in accordance with the provisions of the Election Law.", 0);
	    } 
	    
	    if ( $this->PositionType[$i+1] != $Prev_PartyPosition ) $this->ln(1);
	    
	    $YLocation = $this->GetY() - 1.5 ;
	    $Botton_Corner_Y = $this->GetY();
	    
   	}
   	
   	 */
   	 
   	$this->Ln(2);  	 
   	$this->SetX($this->Line_Left);
    
    $this->SetFont('Arial','B',13);
		$this->Cell(35, 8, "Date" ,0, 0, 'C', 0);
		$this->Cell(75, 8, "Signature / Name of Signer", 0, 0, 'C', 0);
		$this->Cell(74, 8, "Residence", 0, 0, 'C', 0);
		$this->Cell(20, 8, "County", 0, 0, 'C', 0);
		$this->Ln(4.5);
   
   	$this->YLocation = $this->GetY();
   
   	$YLocation = $this->GetY() - 3.5;
   	$this->Line($this->Line_Left, $YLocation, $this->Line_Right, $YLocation);
		
		//$this->Line($this->Line_Left, $Botton_Corner_Y, $this->Line_Right, $Botton_Corner_Y - 0.3);
		//$this->Line($this->Line_Left,	 $Botton_Corner_Y + 6.1, $this->Line_Right, $Botton_Corner_Y + 6.1);

 		$this->Line($this->Line_Left,   $YLocation, $this->Line_Left, $this->BottonPt);
 		$this->Line(40,  $YLocation, 40,  $this->BottonPt);
 		$this->Line(120, $YLocation, 120, $this->BottonPt);
 		$this->Line(190, $YLocation, 190, $this->BottonPt);
 		$this->Line($this->Line_Right, $YLocation, $this->Line_Right, $this->BottonPt);
    $this->Line($this->Line_Left, $this->BottonPt, $this->Line_Right, $this->BottonPt);
    
	}

	// Page footer
	function Footer()	{
		$this->SetTextColor(0);
		$this->SetY(-44);
   	$YLocation = $this->GetY() - 1.9;
		
		if ( empty ($this->WitnessName)) {
			$EmptyWitnessName = true;
			$this->WitnessName = "_______________________________________________"; 
		}
		
		if ( empty ($this->WitnessResidence)) {
			$EmptyWitnessResidence = true;
			$this->WitnessResidence = "__________________________________________________________, Ohio"; 
		}

		$this->SetFont('Arial','',10);
		$this->Ln(1);
		$this->MultiCell(0, 4.2, "
			State of  __________________________ ) 
     ) SS. 
County of _________________________ ) 
 
I, ________________________________ (Circulator’s Name) do hereby certify that I reside at ___________________________________, in the 
City/Village/Unincorporated Area of_______________________(if unincorporated, list municipality that provides postal service)(Zip Code)________, 
County of_________________, State of__________ that I am 18 years of age or older (or 17 years of age and qualified to vote in Illinois), that I am 
a citizen of the United States, and that the signatures on this sheet were signed in my presence, not more than 90 days preceding the last day for 
filing of the petitions and are genuine and that to the best of my knowledge and belief the persons so signing were at the ti me of signing the petition 
qualified voters of the _______________________ Party in the political division in which the candidates is seeking nomination/elective office, and 
that their respective residences are correctly stated, as above set forth. 
         ___________________________________________________
           (Circulator’s Signature)    
 
Signed and sworn to (or affirmed) by ____________________________________ before me, on _____________________________________ 
 (Name of Circulator) (Insert month, day, year) 
 
(SEAL)        ___________________________________________________ 
           (Notary Public’s Signature)  ", 0, 'L', 0);
// " . $this->WitnessResidence . ". Each " . 
		
		$this->SetFont('Arial','I',8);
		$this->SetTextColor(200);

		if ( $EmptyWitnessName == true) {
			$this->SetXY( 8,  $YLocation + 5 );
			$this->Write(0, 'Printed Name of Circulator');
		}

		/*
		if ( $EmptyWitnessResidence == true) {
			$this->SetXY( 92,  $YLocation + 9 );
			$this->Write(0, 'Residence address, also post office if not identical');
		}
		*/

		$this->SetFont('Arial','I',14);
		$this->SetXY( 124,  $YLocation + 30 );
		$this->Write(0, 'Signature of witness');
		
		$this->SetFont('Arial','',8);
		$this->SetTextColor(0);

		$this->SetY(-11);
		$this->SetFont('Arial','B',13);
		$this->Cell(0,0,	$this->TodayDateText);
		$this->SetFont('Arial','',8);
		$this->Cell(0,0, "_________________________________________________________", 0, 0, 0);
		
		
		//A,C,B sets
		if (! empty ($this->BarCode)) {
			$this->Code128(6,0, $this->BarCode, 50,10);
		}
		
		
		if (! empty ($this->DemoPrint)) {		
			$this->SetFont('Arial','B',19);
			$this->SetTextColor(255,0,0);
			$this->SetXY(40, 50);
			$this->Link(40, 50, 80, 30, "https://repmyblock.nyc/exp/multipetition/propose");
 	   	$this->MultiCell(80, 8, "We'll provide you the list of " . $this->party . 
				 	   									" voters to ask for signatures.", 0, 'C');

			$this->SetTextColor(0,0,255);
			$this->SetXY(120, 132.5);
			$this->Link(120, 130, 70, 25, "https://repmyblock.nyc/exp/multipetition/propose");
 	   	$this->MultiCell(70, 8.2, "Petitioning will start in February 2022 until March 2022", 0, 'C'); 	   									
 	   }
		
		$this->SetTextColor(0);
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