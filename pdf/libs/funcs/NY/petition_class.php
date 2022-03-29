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
		$YLocation = $this->GetY();
		$this->SetTextColor(0);
		
		

		if (! empty ($this->DemoPrint)) {		
			$this->SetXY(125, 1);
			$this->SetFont('Arial', 'B', 15);
			$this->SetTextColor(0,0,255);
			$this->Link(125, 1, 90, 10, "https://repmyblock.org/pet/training/steps/torun");
 	   	$this->MultiCell(90, 5, "Click here for more information on how to participate.", 0, 'R');
 	   	$this->SetTextColor(0); 	   	
 	   	$this->SetXY($this->Col1, $YLocation);
		}
		
		$this->SetFont('Arial','',10);
		
    $this->SetFont('Arial','B',12);
    $this->Cell(0,0, strtoupper($this->party) . " PARTY",0,0,'C');
    $this->Ln(4);
    
    if ($this->PetitionType == "independent") {
      $this->Cell(0,0, "Independent Nominating Petition",0,0,'C');
	  } else {
			$this->Cell(0,0, "Designating Petition - " . $this->county . ' County',0,0,'C');
    }
    $this->Ln(3);    
    
    $this->SetFont('Arial','B',8);
    $this->Cell(36,2.8, 'To the Board of Elections:');
    $this->SetFont('Arial','',8);

		if ($this->PetitionType == "independent") {
    	
 			$this->write(3, 
				"I, the undersigned, do hereby state that I am a registered voter of the political unit for " .
				"which a nomination for public office is hereby being made, that my present place of residence " . 
				"is truly stated opposite my signature hereto, and that I do hereby nominate the following " . 
				"named person as a candidate for election to public office to be voted for at the election " . 
				"to be held on the " . $this->ElectionDate . ", and that I select the name " . $this->party . 
				" as the name of the independent body making the nomination and ");
				
			if ( ! empty ($this->EmblemFontType)) {
				$this->AddFont($this->EmblemFontType,'', $this->EmblemFontType . ".php");
				$this->SetFont($this->EmblemFontType,'', $this->EmblemFontSize);
				$this->Write(3, $this->PartyEmblem);
			}
			
			$this->SetFont('Arial','', 8);		
			$this->Write(3, " as the emblem of such body.");
			
		} else {
			
			$this->write(3, "I, the undersigned, do hereby state that I am a duly " . 
				"enrolled voter of the " . $this->party . " Party " .
				"and entitled to vote at the next primary election of such party, to be held on " . 
				$this->ElectionDate . "; that my place of residence is truly " . 
				"stated opposite my signature hereto, and I do hereby designate " .
				"the following named person" . $this->PluralCandidates . " as " .
				$this->PluralAcandidates . " candidate" . $this->PluralCandidates . " for ". 
				"the " . $this->CandidateNomination);
			
		}			
    $this->Ln(5);
		$YLocation_new = $Top_Corner_Y = $this->GetY() - 1.5;   
 		$this->SetY($Top_Corner_Y);
 		
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
	    */
	    
	  
	    
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
   	
   	$this->Ln(2);  	 
   	$this->SetX($this->Line_Left);
   	$this->SetFont('Arial','B',8);
    $this->Cell(0, 0, "In witness whereof, I have hereunto set my hand, the day and year placed opposite my signature.");
    
    $this->Ln(1);
    
    $this->SetFont('Arial','B',13);
		$this->Cell(35, 8, "Date" ,0, 0, 'C', 0);
		$this->Cell(75, 8, "Signature / Name of Signer", 0, 0, 'C', 0);
		$this->Cell(74, 8, "Residence", 0, 0, 'C', 0);
		$this->Cell(20, 8, $this->TypeOfTown, 0, 0, 'C', 0);
		$this->Ln(4.5);
   
   	$this->YLocation = $this->GetY();
   
   	$YLocation = $this->GetY() - 3.5;
   	$this->Line($this->Line_Left, $YLocation, $this->Line_Right, $YLocation);
   	
   	$this->MyTopFor = $YLocation;
		
		//$this->Line($this->Line_Left, $Botton_Corner_Y, $this->Line_Right, $Botton_Corner_Y - 0.3);
		//$this->Line($this->Line_Left,	 $Botton_Corner_Y + 6.1, $this->Line_Right, $Botton_Corner_Y + 6.1);
	}

	// Page footer
	function Footer()	{

		//$this->LocationOfFooter = -44;		
		// Let see moving the square at the end
		$this->Line($this->Line_Left, $this->MyTopFor, $this->Line_Left, $this->BottonPt);
 		$this->Line(40,  $this->MyTopFor, 40,  $this->BottonPt);
 		$this->Line(120, $this->MyTopFor, 120, $this->BottonPt);
 		$this->Line(190, $this->MyTopFor, 190, $this->BottonPt);
 		$this->Line($this->Line_Right, $this->MyTopFor, $this->Line_Right, $this->BottonPt);
		// $this->Line($this->Line_Left, $this->BottonPt, $this->Line_Right, $this->BottonPt);
	
		$this->SetTextColor(0);

		$this->SetY($this->LocationOfFooter);
   	$YLocation = $this->GetY() - 1.9;
		
		if ( empty ($this->WitnessName)) {
			$EmptyWitnessName = true;
			$this->WitnessName = "_______________________________________________"; 
		}
		
		if ( empty ($this->WitnessResidence)) {
			$EmptyWitnessResidence = true;
			$this->WitnessResidence = "__________________________________________________________, New York"; 
		}

		$this->SetFont('Arial','B',10);
		$this->Cell(0,0, "STATEMENT OF WITNESS", 0, 1, 'C');		
		$this->SetFont('Arial','',10);
		$this->Ln(1);
		
		if ($this->PetitionType == "independent") {
	  	
	  	/* Independent witness statement */
			
			$this->MultiCell(0, 4.2, 
			"I, " . $this->WitnessName . " state: I am a duly qualified voter of the State of New York.  " . 
			"I now reside at " . $this->WitnessResidence .  
			". Each of the individuals whose names are subscribed to this petition sheet containing " .
			"____ signatures, subscribed the same in my presence on the dates above indicated " . 
			"and identified himself or herself to be the individual who signed this sheet. I understand " . 
			"that this statement will be accepted for all purposes as the equivalent of an affidavit and, " . 
			"if it contains a material false statement, " . 
			"shall subject me to the same penalties as if I had been duly sworn.", 0, 'L', 0);
		
			$this->SetFont('Arial','I',8);
			$this->SetTextColor(200);

			if ( $EmptyWitnessName == true) {
				$this->SetXY( 8,  $YLocation + 5 );
				$this->Write(0, 'Name of witness');
			}

			if ( $EmptyWitnessResidence == true) {
				$this->SetXY(20,  $YLocation + 9 );
				$this->Write(0, 'Residence address, also post office if not identical');
			}
			
		} else {
		
			$this->MultiCell(0, 4.2, 
				"I, " . $this->WitnessName . " state: I am a duly qualified voter of the State of New York and am an " . 
				"enrolled voter of the " . $this->party . " Party. I now reside at " . $this->WitnessResidence . ". Each " . 
				"of the individuals whose names are subscribed to this petition sheet " . 
				"containing ____ signatures, subscribed the same in my presence on the dates above indicated " . 
				"and identified himself or herself to be the individual who signed this sheet. I understand that this " .
				"statement will be accepted for all purposes as the equivalent of an affidavit and, " .
				"if it contains a material false statement, shall subject me to the " . 
				"same penalties as if I had been duly sworn.", 0, 'L', 0);
	
			$this->SetFont('Arial','I',8);
			$this->SetTextColor(200);

			if ( $EmptyWitnessName == true) {
				$this->SetXY( 8,  $YLocation + 5 );
				$this->Write(0, 'Name of witness');
			}

			if ( $EmptyWitnessResidence == true) {
				$this->SetXY( 92,  $YLocation + 9 );
				$this->Write(0, 'Residence address, also post office if not identical');
			}
		}
		

		$this->SetFont('Arial','I',14);
		$this->SetXY( 150,  $YLocation + 30 );
		$this->Write(0, 'Signature of witness');
		
		$this->SetFont('Arial','',8);
		$this->SetTextColor(0);

		$this->SetY(-15);
		$this->SetFont('Arial','B',13);
		$this->Cell(0,0,	$this->TodayDateText);
		$this->SetY(-12.5);
		$this->SetFont('Arial','',8);
		$this->Cell(0,0, "_________________________________________________________", 0, 0, 0);
		
		$this->SetXY(20, -14);
		$this->Cell(40,10, "City:", 0, 'L', 0);

		$this->SetXY(60, -14);
		$this->Cell(40,10, "County:", 0, 'L', 0);
		
		$this->SetXY(40, -14 );
		$this->SetFont('Arial','B',8);
		$this->Cell(40, 10, $this->City, 0, 'L', 0);
		$this->SetXY(69, -14 );
		$this->Cell(45, 10, $this->County, 0, 'L', 0);
		
		$this->SetXY(160, -7 );
		$this->SetFont('Arial','',13);
		$this->Cell(0, 0,	"SHEET No. ______ ");
		
		$this->SetXY(5, -7 );
		$this->SetFont('Arial','',8);
		$this->Cell(0, 0, $this->BarCode);
	
	
	
		//A,C,B sets
		if (! empty ($this->BarCode)) {
			$this->Code128(6,0, $this->BarCode, 50,10);
		}
		
		if (! empty ($this->DemoPrint)) {		
			$this->SetFont('Arial','B',19);
			$this->SetTextColor(255,0,0);
			$this->SetXY(40, 50);
			$this->Link(40, 50, 80, 30, "https://repmyblock.org/pet/training/steps/torun");
 	   	$this->MultiCell(80, 8, "We'll provide you the list of " . $this->party . 
				 	   									" voters to ask for signatures.", 0, 'C');

			$this->SetTextColor(0,0,255);
			$this->SetXY(120, 132.5);
			$this->Link(120, 130, 70, 25, "https://repmyblock.org/pet/training/steps/torun");
 	   	$this->MultiCell(70, 8.2, "Petitioning will start in February 2022 until March 2022", 0, 'C'); 	   									
 	   }
		
		$this->SetTextColor(0);
		
		if ( empty ($this->party) || empty ($this->ElectionDate) || empty ($this->county) || empty ($this->TypeOfTown)) {
		  	$this->SetXY(0,0);
				$this->SetFont('Arial','B',80);
	    	$this->SetTextColor(255,0,0);
	   		$this->RotatedText(25,90, "VOID", 45);
	   		$this->RotatedText(25,150, "DO NOT USE", 45);
				if ( empty ($this->ElectionDate)) {
		   		$this->RotatedText(30,210, "DATE IS MISSING" , 45);				
				} else if ( empty ($this->county) || empty ($this->TypeOfTown)) {
					$this->RotatedText(28,210, "COUNTY IS MISSING", 45);
				} else {
		   		$this->RotatedText(30,210, "PARTY IS MISSING" , 45);
		   	}
	   		$this->RotatedText(40,270, "FROM PETITION", 45);
	   		$this->RotatedText(140,260, "VOID", 45);
	   		$this->SetTextColor(0,0,0);
		} else {
		
			if (! empty ($this->Watermark)) {
				$this->SetXY(0,0);	
				$this->SetFont('Arial','B',50);
	    	$this->SetTextColor(255,192,203);
	   		$this->RotatedText(35,190, $this->Watermark, 45);
	   		$this->RotatedText(40,210, "Election will be held in 2022", 45);
	   		$this->SetTextColor(0,0,0);
			}
		
		}
	
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