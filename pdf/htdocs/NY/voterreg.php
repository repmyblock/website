<?php
//date_default_timezone_set('America/New_York'); 
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";		
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
// require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/NY/voterreg_class.php';

$Type = "in";
switch($Type) {
	case "in": $Multi = 72; break;
	case "mm": $Multi = 0.35; break;
	case "cm": $Multi = 3.5; break;
	default: $Multi = 1; break;
}

//print $total = 4.125 / $Multi;

$PageSize = array( 8 * $Multi , 11 * $Multi);
#$PageSize = "letter";
//$pdf = new PDF_Multi('L','mm', $PageSize);
$pdf = new PDF('P','pt', $PageSize);

$CanPetitionSet_ID = trim($_GET["petid"]);
// $pdf->DateEvent = $ElectionDateShort;
// $pdf->Election = "PRIMARY";

$pdf->PermitNumber = "4339";
$pdf->PermitCity = "NEW YORK NY";

$pdf->AddressLine[0] = "BOARD OF ELECTIONS";
$pdf->AddressLine[1] = "32 BROADWAY 7 FL";
$pdf->AddressLine[2] = "NEW YORK NY 10275-0067";

$pdf->AddressStart = 1;
$pdf->MailStop = "saafdfadadffssadafdaddafffsdsaaafadaadddafssadsadsdfasaaafsddsdfs";


$Petition_FileName = "BOE_NYC_PreStamp.pdf";
$pdf->AddPage();
//$pdf->AliasNbPages();
//$pdf->SetTopMargin(0);
//$pdf->SetLeftMargin(0);
//$pdf->SetRightMargin(5);
//$pdf->SetAutoPageBreak(1, 38);
//$pdf->AddPage();

$pdf->Output("I", $Petition_FileName);

?>

