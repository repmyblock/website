<?php
//date_default_timezone_set('America/New_York'); 
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";		
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/NY/NYC/PetHearing_NoticeAppearance.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/script88/PDF_Code128.php';

$r = new OutragedDems();
$result = $r->SelectObjections($k);

//echo "<PRE>";
//print_r($result);
//echo "</PRE>";

$PageSize = "letter";
$pdf = new PDF_Multi('P','mm', $PageSize);
//$pdf = new PDF('P','mm', $PageSize);
//$CanPetitionSet_ID = trim($_GET["petid"]);


$pdf->AliasNbPages();
$pdf->SetTopMargin(8);
$pdf->SetLeftMargin(5);
$pdf->SetRightMargin(5);
$pdf->SetAutoPageBreak(1, 38);

if ( ! empty ($result)) {
	foreach ($result as $var) {
		if (! empty($var)) {
			$pdf->DateAppear = PrintShortDate($var["FillingObjections_DateAppear"]); 										// "June 23rd, 2020";
			$pdf->County = $var["DataCounty_Name"]; 														// New York";
			$pdf->SpecificationNumber = $var["FillingObjections_SpecificationNumber"]; 	// 28";
			$pdf->PetitionNumber = $var["FillingObjections_PetitionNumber"]; 						// NY2000525";
			$pdf->ObjectorName = $var["FillingObjections_ObjectorName"]; 								// Robles Nobles";
			$pdf->CandidateName = $var["FillingObjections_CandidateName"]; 							// Theo Chino";

			$pdf->CheckRep = $var["FillingObjections_CheckRep"]; 												// ;
			$pdf->RepType = $var["FillingObjections_RepType"]; 													// candidate";

			$pdf->RepreName = $var["FillingObjections_RepreName"]; 											// Theo Chino";
			$pdf->RepreFirm = $var["FillingObjections_RepreFirm"]; 											// None";
			$pdf->RepAddress1 = $var["FillingObjections_RepAddress1"]; 									// 640 Riverside Drive";
			$pdf->RepAddress2 = $var["FillingObjections_RepAddress2"]; 									// New York, NY 10031";
			$pdf->RepTel = $var["FillingObjections_RepTel"]; 														// (212) 694-9968";
			$pdf->RepFax = $var["FillingObjections_RepFax"]; 														// (917) 398-1513";
			$pdf->RepEmail = $var["FillingObjections_RepEmail"];

			$pdf->SignedDate = PrintShortDate($var["FillingObjections_SignedDate"]); 										// June 23rd, 2020";
			$pdf->AddPage();
		}
	}
}

$Petition_FileName = "NYCCRU_Hearing_Form_" . $pdf->CandidateName . ".pdf";

$pdf->Output("I", $Petition_FileName);

?>

