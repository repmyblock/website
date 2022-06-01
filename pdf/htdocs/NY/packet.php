<?php
//date_default_timezone_set('America/New_York');
//If you are going to use merge of already created PDF function, RMBBlockInit need to be set to true.
$RMBBlockInit = true;

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/voterlist_class.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/NY/petition_class.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/script88/PDF_Code128.php';	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/fpdf_libs/fpdf_merge/fpdf_merge.php';

$r = new OutragedDems();
$db_NY_petition = $r;
$db_RMB_voterlist = $r;

$PageSize = "letter";
$PetitionFrameName = "2022";
$WalkSheetFrameName = "2022";

$PageSize = "letter";
$pdf_NY_petition = new PDF_NY_Petition('P','mm', $PageSize);
require_once $_SERVER["DOCUMENT_ROOT"] . '/NY/petition.php';

$pdf_RMB_walksheet = new PDF_RMB_VoterList('P','mm', $PageSize);
require_once $_SERVER["DOCUMENT_ROOT"] . '/rmb/voterlist.php';

// This comes after the initionalization.
// Run the petition.


$merge = new FPDF_Merge();
$merge->add_string($pdf_NY_petition->Output('s'));
$merge->add_string($pdf_RMB_walksheet->Output('s'));
$merge->output();

?>
