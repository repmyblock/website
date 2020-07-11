<?php
require $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/script88/PDF_Code128.php';

class PDF extends FPDF {

		function Header()	{
		
		$PageHeight = $this->GetPageHeight();
		$PageWidth = $this->GetPageWidth();
		
		$FontSize = 10;
    $this->SetFont('Arial','', $FontSize);  
	
		$this->SetLineWidth(0.4);	
 	 	$this->SetFont('Arial','B',8);
    $this->SetXY(5, 5);  $this->Cell(20, 0.25, "Page: Height: $PageHeight - Width: $PageWidth - String: $LengthNoPostage", 0, 0,'L');		

		//$FontSize = 5;
    $this->SetFont('Arial','', $FontSize);  
     
     
    $Start = 1; $FontSize = 8;
    $this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Please print clearly;", 0, 0, "R");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "See detailed instructions.", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "This application must either be personally delivered to your county " . 
												"board of elections not later than the day before the election, or " . 
												"postmarked by a governmental postal service not later than 7th day before election day;", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "The ballot itself must either be personally delivered" .
												"to the board of elections no later than the close of polls on election day, or postmarked by a " .
												"governmental postal service not later than the day before the election and received no later " .
												"than the 7th day after the election.", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "I am requesting, in good faith, an absentee ballot due to (check one reason):", 0, 0, "L");

		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "absence from county or New York ity on election day", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "temporary illness or physical disability", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "permanent illness or physical disability", 0, 0, "L");

		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "duties related to primary care of one or more", 0, 0, "L");

		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "individuals who are ill or physically disabled Administration Hospital", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "detention in jail/prison, awaiting trial, awaiting action by a grand jury, or in prison for a conviction of a crime or offense which was not a felony", 0, 0, "L");		$this->Cell(65, 1, "Suffix", 0, 0, "L");
		
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "absentee ballot(s) requested for the following election(s) :", 0, 0, "L");

		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Primary Election only ", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "General Election only", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Special Election only", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Any election held between these dates. absence begins:", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "last name or surname", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "first name", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "middle initial", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "suffix", 0, 0, "L");

		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "date of birth", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "MM/DD/YYYY", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "county where you live", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "phone number (optional)", 0, 0, "L");


		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "email (optional)", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "address where you live (residence) street", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "apt.", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "city", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "state", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "zip code", 0, 0, "L");

		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Delivery of Primary Election Ballot", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "(check one)", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Deliver to me in person at the board of elections", 0, 0, "L");

		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "I authorize", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "(give name).", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "to pick up my ballot at the board of elections.", 0, 0, "L");

		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Mail ballot to me at:", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "You ar ddress was", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "(mailing address)", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "street no.", 0, 0, "L");

		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "street name", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "apt.", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "city", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "state", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "zip code", 0, 0, "L");

		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Delivery of General (or Special) Election Ballot", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "(check one)", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Deliver to me in person at the board of elections", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "I authorize", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "• 	This is my signature or mark in the box  below. ", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "• 	The above information is true, I understand that if it is not true, ", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "• 	I can be convicted and fined up to $5,000 and/or jailed for up to four years.", 0, 0, "L");

		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "I need to apply for an Absentee ballot.", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "I would like to be an Election Day worker.", 0, 0, "L");

		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Optional questions", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Sign", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Date", 0, 0, "L");

		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Democratic party ", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Republican party ", 0, 0, "L");
		$this->Cell(5, $Start += $FontSize1, "Conservative party ", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Working Families party ", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Green party ", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Libertarian party ", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Independence party ", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "SAM party", 0, 0, "L");
		$this->SetXY(5, $Start += $FontSize); $this->Cell(0, 0, "Other", 0, 0, "L");



    #$LengthNoPostage = $this->GetStringWidth("UNITED STATES") + 5.671;
    #$this->SetXY($PageWidth - ($LengthNoPostage) - 10, 20); 
    #$this->MultiCell($LengthNoPostage, $FontSize, "NO POSTAGE\nNECESARY\nIF MAILED\nIN THE\nUNITED STATES", 0, 'C');		
    #$this->Rect($PageWidth - ($LengthNoPostage) - 10, 14, ($LengthNoPostage), 5 * ($FontSize + 2), 'D');

		// I must make the bars
	#	for($i = 20; $i < 140; $i += 10) {
	#		$this->Rect($PageWidth - ($LengthNoPostage) - 10, 5 * ($FontSize + 2) + $i, ($LengthNoPostage), 5, 'FD');
	#	}

		// FIM C: || | | || (110101011)
		#$this->Rect($PageWidth - 150, 0, 2.25, 45, 'F'); // 1
		#$this->Rect($PageWidth - 154.75, 0, 2.25, 45, 'F'); // 1
		#//$this->Rect($PageWidth - 159.50, 0, 2.25, 45, 'D'); // 0
		#$this->Rect($PageWidth - 164.25, 0, 2.25, 45, 'F'); // 1
		#//$this->Rect($PageWidth - 169, 0, 2.25, 45, 'D'); // 0
		#$this->Rect($PageWidth - 173.75, 0, 2.25, 45, 'F'); // 1
		#//$this->Rect($PageWidth - 178.5, 0, 2.25, 45, 'D'); // 0
		#$this->Rect($PageWidth - 183.25, 0, 2.25, 45, 'F'); // 1
		#$this->Rect($PageWidth - 188, 0, 2.25, 45, 'F'); // 1


		//$this->Rect($PageWidth - 170, 0, 2.25, 45, 'FD');
		//$this->Rect($PageWidth - 180, 0, 2.25, 45, 'FD');
		//$this->Rect($PageWidth - 216, 0, 2.25, 45, 'FD');

 		// Arial 10 BOLD
 		#$this->SetFont('Arial','',20);
    #$this->SetXY(0, $HMiddlePage);  $this->Cell($PageWidth, 4, "BUSINESS REPLY MAIL", 0, 0,'C');		
        
    #$this->SetFont('Arial','',8);
    
    #$string = "FIRST-CLASS MAIL" . "PERMIT NO. " . $this->PermitNumber . " " . $this->PermitCity;
    
    #$this->SetXY(0, $HMiddlePage + 4);  $this->Cell($PageWidth, 4, "FIRST-CLASS MAIL PERMIT NO. 4339 NEW YORK NY", 0, 0,'C');
    #$this->SetXY(0, $HMiddlePage + 8);  $this->Cell($PageWidth, 4, "POSTAGE WILL BE PAID BY ADDRESSEE", 0, 0,'C');
    

    
		// Arial 16 BOLD
 	  #$this->SetFont('Arial','',8);  
   	//$this->Rect(10, 107, 30, 8, 'FD');
		//$this->Rect(80, 104, 120, 66, 'D');
		//$this->Rect(10, 184, 190, 74, 'D');
		
	  //$this->Line(24, 98, 63, 98);
   // $this->Line(105, 111, 200, 111);		
   // $this->Line(105, 120, 200, 120);		
  		
// 		$this->SetTextColor(242);
	//	$this->SetTextColor(0);
	}

	// Page footer
	function Footer()	{
		
		#if (! empty ($this->BarCode)) {
		#	$this->Code128(160,0, $this->BarCode, 50,10);
	#	}
		
	#	$this->Write(0, 'Mail Bar Code');


	}
	
}



?>