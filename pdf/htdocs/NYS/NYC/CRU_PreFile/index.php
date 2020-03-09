<?php
//date_default_timezone_set('America/New_York'); 
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";		
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/CRU_PreFileForm.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/script88/PDF_Code128.php';

$r = new OutragedDems();

$PageSize = "letter";
$pdf = new PDF_Multi('P','mm', $PageSize);
//$pdf = new PDF('P','mm', $PageSize);

$HasData = 1;
if ( $HasData == 1) {
	$pdf->Election = "PRIMARY";
//	$pdf->PartyName = "Democratic";

	$pdf->XonDesign = "X";
//	$pdf->XonIndepend = "X";
//	$pdf->XonOpportunity = "X";

//	$pdf->TotalBX= "1";
//	$pdf->TotalNY= "12";
//	$pdf->TotalKG= "14";
//	$pdf->TotalQN= "15";
//	$pdf->TotalRC= "99";
//	$pdf->Total= "1";

//	$pdf->PrintName = "Theo Chino";
//	$pdf->AddressLine1 = "640 Riverside Drive - 10B";
//	$pdf->AddressLine2 = "New York, NY 10031";
//	$pdf->Representing = "Self";

	//$pdf->PetWithoutID = "X";
	$pdf->DateEvent = "06 / 23 / 2020";
}

$Petition_FileName = "PreAssignedID.pdf";

$pdf->AliasNbPages();
$pdf->SetTopMargin(8);
$pdf->SetLeftMargin(5);
$pdf->SetRightMargin(5);
$pdf->SetAutoPageBreak(1, 38);
$pdf->AddPage();





$pdf->Output("I", $Petition_FileName);

?>

