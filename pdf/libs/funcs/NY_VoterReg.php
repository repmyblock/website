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
     
    $this->Cell(10, 5, "It is a crime to procure a false registration or to furnish false information to the Board of Elections.", 0, 0, "L");
		$this->Cell(18, 5, "Are you a citizen of the U.S.?", 0, 0, "L");
		$this->Cell(26, 5, "Please print in blue or black ink.", 0, 0, "L");
		$this->Cell(32, 5, "If you answer No, you cannot register to vote.", 0, 0, "L");
		$this->Cell(40, 5, "Will  you be 18 years of age or older on or before election day? ", 0, 0, "L");

		$this->Cell(35, 5, "Are you at least 16 years of age and understand that you must be 18 years of age on or before election day to vote, ", 0, 0, "L");
		$this->Cell(40, 5, "and that until you will be eighteen years of age at the time of such election your registration will be marked “pending” and you", 0, 0, "L");
		$this->Cell(45, 5, "will be unable to cast a ballot in any election.", 0, 0, "L");

		$this->Cell(50, 1, "If you answer No to both of the prior questions, you cannot register to vote.", 0, 0, "L");

		$this->Cell(55, 1, "Last name", 0, 0, "L");
		$this->Cell(60, 1, "First name", 0, 0, "L");
		$this->Cell(65, 1, "Suffix", 0, 0, "L");
		$this->Cell(70, 65, "Middle Initial", 0, 0, "L");

		$this->Cell(75, 70, "More information ", 0, 0, "L");
		$this->Cell(80, 75, "Items 5, 6 & 7 are optional", 0, 0, "L");
		$this->Cell(85, 80, "Birth date", 0, 0, "L");
		$this->Cell(90, 85, "Gender", 0, 0, "L");
		$this->Cell(95, 90, "Phone ", 0, 0, "L");
		$this->Cell(100, 95, "Email", 0, 0, "L");

		$this->Cell(0, 1, "The address  where you live", 0, 0, "L");
		$this->Cell(0, 1, "Address (not P.O. box)", 0, 0, "L");
		$this->Cell(0, 1, " Apt. Number ", 0, 0, "L");
		$this->Cell(0, 1, " Zip code", 0, 0, "L");
		$this->Cell(0, 1, "City/Town/Village", 0, 0, "L");
		$this->Cell(0, 1, "New York State County ", 0, 0, "L");

		$this->Cell(0, 1, "The address where you receive mail Skip if same as above", 0, 0, "L");
		$this->Cell(0, 1, "P.O. Box", 0, 0, "L");
		$this->Cell(0, 1, "City/Town/Village", 0, 0, "L");

		$this->Cell(0, 1, "Voting history", 0, 0, "L");
		$this->Cell(0, 1, "Have you voted before?", 0, 0, "L");
		$this->Cell(0, 1, "What year?", 0, 0, "L");

		$this->Cell(0, 1, "You nr ame was", 0, 0, "L");
		$this->Cell(0, 1, "You ar ddress was", 0, 0, "L");
		$this->Cell(0, 1, "Your previous state or New York State County was ", 0, 0, "L");

		$this->Cell(0, 1, "Political party", 0, 0, "L");
		$this->Cell(0, 1, "You must make 1 selection", 0, 0, "L");
		$this->Cell(0, 1, "Political party enrollment is optional but that, in order to vote in a primary election of a ", 0, 0, "L");
		$this->Cell(0, 1, "political party, a voter must enroll in that political party, unless state party rules allow ", 0, 0, "L");
		$this->Cell(0, 1, "otherwise.", 0, 0, "L");

		$this->Cell(0, 1, "Affidavit: I swear or affirm that", 0, 0, "L");
		$this->Cell(0, 1, "• 	I am a citizen of the United States.", 0, 0, "L");
		$this->Cell(0, 1, "• 	I will have lived in the county, city or village for at least 30 days before the election.", 0, 0, "L");
		$this->Cell(0, 1, "• 	I meet all requirements to register to vote in New York State. ", 0, 0, "L");
		$this->Cell(0, 1, "• 	This is my signature or mark in the box  below. ", 0, 0, "L");
		$this->Cell(0, 1, "• 	The above information is true, I understand that if it is not true, ", 0, 0, "L");
		$this->Cell(0, 1, "• 	I can be convicted and fined up to $5,000 and/or jailed for up to four years.", 0, 0, "L");

		$this->Cell(0, 1, "I need to apply for an Absentee ballot.", 0, 0, "L");
		$this->Cell(0, 1, "I would like to be an Election Day worker.", 0, 0, "L");

		$this->Cell(0, 1, "Optional questions", 0, 0, "L");
		$this->Cell(0, 1, "Sign", 0, 0, "L");
		$this->Cell(0, 1, "Date", 0, 0, "L");

		$this->Cell(0, 1, "Democratic party ", 0, 0, "L");
		$this->Cell(0, 1, "Republican party ", 0, 0, "L");
		$this->Cell(0, 1, "Conservative party ", 0, 0, "L");
		$this->Cell(0, 1, "Working Families party ", 0, 0, "L");
		$this->Cell(0, 1, "Green party ", 0, 0, "L");
		$this->Cell(0, 1, "Libertarian party ", 0, 0, "L");
		$this->Cell(0, 1, "Independence party ", 0, 0, "L");
		$this->Cell(0, 1, "SAM party", 0, 0, "L");
		$this->Cell(0, 1, "Other", 0, 0, "L");



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