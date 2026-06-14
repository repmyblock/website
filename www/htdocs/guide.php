<?php 

$request = trim($_SERVER['REQUEST_URI'], '/');

if ($request === $_GET['beg'] . "_" . $_GET['end']) {
  $middleuri = $_GET['beg'] . "_" . $_GET["end"];
  require_once $_SERVER["DOCUMENT_ROOT"] . "/voter/detail.php";
    
} elseif ($request === $_GET['beg'] . "-" . $_GET['end']) {
	$middleuri = $_GET['beg'] . "-" . $_GET["end"];
	require_once $_SERVER["DOCUMENT_ROOT"] . "/voter/guide.php";

} else {
	$middleuri = $_GET['beg'] . ":" . $_GET["end"];
	require_once $_SERVER["DOCUMENT_ROOT"] . "/voter/guide.php";			
}

echo "\n<!--- I AM IN THE GUIDE\n";
echo "Beg: " . $_GET['beg'] . "\n";
echo "Beg: " . alphatonumber($_GET['beg']) . "\n";
echo "End: " . $_GET['end'] . "\n";
echo "---->";
exit();
?>
