<?php
//date_default_timezone_set('America/New_York'); 
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";		
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/CRU_PreFileForm.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/script88/PDF_Code128.php';



$PageSize = "letter";
$pdf = new PDF_Multi('P','mm', $PageSize);
//$pdf = new PDF('P','mm', $PageSize);

$CanPetitionSet_ID = trim($_GET["petid"]);
// $pdf->DateEvent = $ElectionDateShort;
// $pdf->Election = "PRIMARY";

$pdf->XonDesign = "X";	
$pdf->Total = 1;
$pdf->Election = "PRIMARY";
$pdf->DateEvent = "06/23/2020";
$pdf->PartyName = "DEMOCRATIC";

if (is_numeric($CanPetitionSet_ID)) { 
	$r = new OutragedDems();
	$result = $r->ListCandidatePetitionSet($CanPetitionSet_ID);

	if ( ! empty ($result)) {
		$result = $result[0];
		$pdf->BarCode = $result["CanPetitionSet_ID"] . "#000000";
		
		$pdf->XonDesign = "X";	
		preg_match("/(.*)\n(.*)/", $result["Candidate_DispResidence"], $matches);
		$pdf->AddressLine1 = $matches[1];
		$pdf->AddressLine2 = $matches[2];
		
		$pdf->Election = strtoupper($result["Elections_Type"]);
    $pdf->PrintName = $result["Candidate_DispName"];
    $pdf->Representing = "Self";
    $pdf->PartyName = NewYork_PrintPartyAdjective($result["CanPetitionSet_Party"]);
   
		$pdf->Total = 0;
		switch ($result["DataCounty_Name"]) {			
	 		case 'Queens': $pdf->TotalQN = 1; $pdf->Total += $pdf->TotalQN; break;
	 		case 'Bronx': $pdf->TotalBX = 1; $pdf->Total += $pdf->TotalBX; break;
	 		case 'Kings': $pdf->TotalKG = 1; $pdf->Total += $pdf->TotalKG; break;
	 		case 'Richmond': $pdf->TotalRC = 1;	$pdf->Total += $pdf->TotalRC;	break;
	 		case 'New York': $pdf->TotalNY = 1;	$pdf->Total += $pdf->TotalNY;	break;
	 	}
	 	
	 	$pdf->DateEvent = PrintThreeDigits($result["Elections_Date"]);
	}
}

$Petition_FileName = "NYCCRU_PreAssignedID_Form.pdf";

$pdf->AliasNbPages();
$pdf->SetTopMargin(8);
$pdf->SetLeftMargin(5);
$pdf->SetRightMargin(5);
$pdf->SetAutoPageBreak(1, 38);
$pdf->AddPage();

$pdf->Output("I", $Petition_FileName);

?>

