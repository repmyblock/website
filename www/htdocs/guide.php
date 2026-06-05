<?php 
$middleuri = $_GET['beg'] . "_" . $_GET["end"];
require_once $_SERVER["DOCUMENT_ROOT"] . "/voter/detail.php";
echo "\n<!--- I AM IN THE GUIDE\n";
echo "Beg: " . $_GET['beg'] . "\n";
echo "Beg: " . alphatonumber($_GET['beg']) . "\n";
echo "End: " . $_GET['end'] . "\n";
echo "---->";
exit();
?>
