<?php
//date_default_timezone_set('America/New_York'); 
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";		
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/NY/NYC/PetHearing_NoticeAppearance.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/script88/PDF_Code128.php';

$r = new OutragedDems();
$result = $r->SelectObjections("noticeappearance");

#echo "<PRE>";
#print_r($result);
#echo "</PRE>";

#exit();

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
			$pdf->DateAppear = $var["FillingDoc_Fld1"]; 										// "June 23rd, 2020";
			$pdf->County = $var["FillingDoc_Fld2"]; 														// New York";
			$pdf->SpecificationNumber = $var["FillingDoc_Fld3"]; 	// 28";
			$pdf->PetitionNumber = $var["FillingDoc_Fld4"]; 						// NY2000525";
			$pdf->ObjectorName = $var["FillingDoc_Fld5"]; 								// Robles Nobles";
			$pdf->CandidateName = $var["FillingDoc_Fld6"]; 							// Theo Chino";

			$pdf->CheckRep = $var["FillingDoc_Fld7"]; 												// ;
			$pdf->RepType = $var["FillingDoc_Fld8"]; 													// candidate";

			$pdf->RepreName = $var["FillingDoc_Fld9"]; 											// Theo Chino";
			$pdf->RepreFirm = $var["FillingDoc_Fld10"]; 											// None";
			$pdf->RepAddress1 = $var["FillingDoc_Fld11"]; 									// 640 Riverside Drive";
			$pdf->RepAddress2 = $var["FillingDoc_Fld12"]; 									// New York, NY 10031";
			$pdf->RepTel = $var["FillingDoc_Fld13"]; 														// (212) 694-9968";
			$pdf->RepFax = $var["FillingDoc_Fld14"]; 														// (917) 398-1513";
			$pdf->RepEmail = $var["FillingDoc_Fld15"];

			$pdf->SignedDate = $var["FillingDoc_Fld16"]; 										// June 23rd, 2020";
			$pdf->AddPage();
		}
	}
}

$Petition_FileName = "NYCCRU_Hearing_Form_" . $pdf->CandidateName . ".pdf";

$pdf->Output("I", $Petition_FileName);

?>

