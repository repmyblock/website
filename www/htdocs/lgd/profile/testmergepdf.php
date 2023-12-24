<?php
//date_default_timezone_set('America/New_York');
//If you are going to use merge of already created PDF function, RMBBlockInit need to be set to true.
$RMBBlockInit = true;

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
#require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/voterlist_class.php';
#require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/NY/petition_class.php';
#require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/script88/PDF_Code128.php';	
#require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
#require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/fpdf_libs/fpdf_merge/fpdf_merge.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/PDFMerger/PDFMerger.php';

$MyPath = $_SERVER["DOCUMENT_ROOT"] . "/shared/platforms/";

use PDFMerger\PDFMerger;
$pdf = new PDFMerger; // or use $pdf = new \PDFMerger; for Laravel

$pdf->addPDF($MyPath . '/test/TestFirstPage.pdf', '1');
$pdf->addPDF($MyPath . $URIEncryptedString["PDFPath"], '1');
$pdf->addPDF($MyPath . '/test/TestMiddlePage.pdf', '1');
$pdf->addPDF($MyPath . $URIEncryptedString["PDFPath"], 'all');
$pdf->addPDF($MyPath . '/test/TestLastPage.pdf', '1');

#$pdf->merge('file', '/tmp/TEST2.pdf'); // generate the file
$pdf->merge('browser', 'TestVoterGuide_TheoBruceChinoTavarez.pdf'); // force download

?>
