<?php
//date_default_timezone_set('America/New_York'); 
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";		
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/NYS/NYC/PetHearing_NoticeAppearance.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/script88/PDF_Code128.php';

$r = new OutragedDems();
$result = $r->SelectObjections();

//echo "<PRE>";
//print_r($result);
//echo "</PRE>";

$PageSize = "letter";
$pdf = new PDF_Multi('P','mm', $PageSize);
//$pdf = new PDF('P','mm', $PageSize);

$CanPetitionSet_ID = trim($_GET["petid"]);
$Petition_FileName = "NYCCRU_Hearing_Form.pdf";

$pdf->AliasNbPages();
$pdf->SetTopMargin(8);
$pdf->SetLeftMargin(5);
$pdf->SetRightMargin(5);
$pdf->SetAutoPageBreak(1, 38);

if ( ! empty ($result)) {
	foreach ($result as $var) {
		if (! empty($var)) {
			$pdf->DateAppear = PrintShortDate($var["Objections_DateAppear"]); 										// "June 23rd, 2020";
			$pdf->County = $var["DataCounty_Name"]; 														// New York";
			$pdf->SpecificationNumber = $var["Objections_SpecificationNumber"]; 	// 28";
			$pdf->PetitionNumber = $var["Objections_PetitionNumber"]; 						// NY2000525";
			$pdf->ObjectorName = $var["Objections_ObjectorName"]; 								// Robles Nobles";
			$pdf->CandidateName = $var["Objections_CandidateName"]; 							// Theo Chino";

			$pdf->CheckRep = $var["Objections_CheckRep"]; 												// ;
			$pdf->RepType = $var["Objections_RepType"]; 													// candidate";

			$pdf->RepreName = $var["Objections_RepreName"]; 											// Theo Chino";
			$pdf->RepreFirm = $var["Objections_RepreFirm"]; 											// None";
			$pdf->RepAddress1 = $var["Objections_RepAddress1"]; 									// 640 Riverside Drive";
			$pdf->RepAddress2 = $var["Objections_RepAddress2"]; 									// New York, NY 10031";
			$pdf->RepTel = $var["Objections_RepTel"]; 														// (212) 694-9968";
			$pdf->RepFax = $var["Objections_RepFax"]; 														// (917) 398-1513";
			$pdf->RepEmail = $var["Objections_RepEmail"];

			$pdf->SignedDate = PrintShortDate($var["Objections_SignedDate"]); 										// June 23rd, 2020";
			$pdf->AddPage();
		}
	}
}

$pdf->Output("I", $Petition_FileName);

?>

