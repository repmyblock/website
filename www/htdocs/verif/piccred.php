<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_display.php";	
	$r = new display();
	$result = $r->findbadgepicture($_GET["k"]);
	header('Content-type: ' . $imageMimeType);
	header('Content-Length: ' . strlen($result["BadgeVerif_Picture"]));
	echo $result["BadgeVerif_Picture"];
	exit();
?>
