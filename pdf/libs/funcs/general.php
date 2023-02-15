<?php

function WriteStderr($Data, $Message = "") {	
	global $Developping;
	 
	// if using NGNIX + FPM, check your
	// /var/log/php/ftp-error.log file and not web error.log 
	 
	// Need to save the information
	if ( $Developping == 1) {	
		if ( ! empty ($Message)) {
			error_log($Message . ": " . print_r($Data, 1));
		} else {
			error_log("Write Std Error: " . print_r($Data, 1));
		}
	}
}
function PrintRandomText($length = 9) {
  
  $alpha = "abcdefghijklmnopqrstuvwxyz";
	$alpha_upper = strtoupper($alpha);
	$numeric = "0123456789";
	$special = ".-+=_,!@$#*%<>[]{}";
	$chars = "";
 
	if (isset($_POST['length'])){
    // if you want a form like above
    if (isset($_POST['alpha']) && $_POST['alpha'] == 'on') $chars .= $alpha;
    if (isset($_POST['alpha_upper']) && $_POST['alpha_upper'] == 'on') $chars .= $alpha_upper;
    if (isset($_POST['numeric']) && $_POST['numeric'] == 'on') $chars .= $numeric;
    if (isset($_POST['special']) && $_POST['special'] == 'on') $chars .= $special;
    $length = $_POST['length'];
	} else {
    // default [a-zA-Z0-9]{9}
    $chars = $alpha . $alpha_upper . $numeric;
	}
 
	$len = strlen($chars);
	$pw = '';
 
	for ($i=0;$i<$length;$i++)
  	$pw .= substr($chars, rand(0, $len-1), 1);
 
	// the finished password
	return str_shuffle($pw); 
}

function PrintShortDate($Date) {
	if ( ! empty ($Date)) {
		return date("F jS, Y", strtotime( $Date ));
	}
}

function PrintThreeDigits($Date) {
	if ( ! empty ($Date)) {
		return date("m/d/Y", strtotime( $Date ));
	}
}

function PrintPartyAdjective($Party) {
	switch($Party) {
		case 'DEM': return "Democratic"; break;
		case 'REP': return "Republican"; break;
		case 'BLK': return "No party"; break;
		case 'CON': return "Conservatives"; break;
		case 'IND': return "Independence"; break;
		case 'WOR': return "Working Families"; break;
		case 'GRE': return "Green"; break;
		case 'LBT': return "Libertarian"; break;
		case 'OTH': return "Other"; break;
		case 'WEP': return "Women\'s Equality"; break;
		case 'REF': return "Reform"; break;
		case 'SAM': return "SAM"; break;
	}
}

function Redact ($string) {
	return str_repeat("X", strlen($string)); ;
	return $string;
}

function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}

function PrintAddress($Alternate, $pdf, $PrintAddress) {
	$pdf->Ln(6);
	if ($Alternate == 1) { $pdf->SetX(110); }
	$pdf->SetFont('Arial', 'B', 16);
	$pdf->Write(7, $PrintAddress);	
	$pdf->Ln(2);
}

function PrintApt($Alternate, $pdf, $ApartementNumber) {
	$pdf->Ln(6);
	if ($Alternate == 1) { $pdf->SetX(110); }
	$pdf->SetFont('Arial', '', 12);										
	$pdf->Write(2, "Apartment: " );
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->Write(2, $ApartementNumber);
	$pdf->Ln(6);													
}

function PrintVoterLine($Alternate, $pdf, $VoterPrintLine, $Status) {
	$LenghtString = $pdf->GetStringWidth($VoterPrintLine);
	
	if ($Alternate == 1) { 
		if ($pdf->GetX() + 110 + $LenghtString > 214 ) { $pdf->Ln(5); } 
		$pdf->SetX(110);
	} else {
		if ($pdf->GetX() + $LenghtString > 104 ) { $pdf->Ln(5); }
	}

	$MyGetX = $pdf->GetX();

	$pdf->SetFont('ZapfDingbats','', 15);
	$pdf->Write(1, "o" );												
	$pdf->SetFont('Arial', '', 10);
	$pdf->Write(1, " " );	
	
	if ( $Status == "Inactive") { $pdf->SetTextColor(255, 0, 0); }
	$pdf->Write(1, $VoterPrintLine . "  ");
	if ( $Status == "Inactive") { $pdf->SetTextColor(0); }
}

?>
