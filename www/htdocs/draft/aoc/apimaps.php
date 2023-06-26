<?php 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	$min =  gmdate("i", time());
	$hour =  gmdate("H", time());
	$rounded_min = floor($min/5) * 5;
	if ($rounded_min == 0 ) $rounded_min = "00";
	if ($rounded_min == 5 ) $rounded_min = "05";
	
	if ($rounded_min == 60) {
		$rounded_min = "00"; $hour++;
	  if ($hour == 24) {
	  	$hour = "00";
	  }
	}
	
	echo "# Hour: $hour Minute: $rounded_min\n";
	include $StatusDirectory . "/aocmap/" . $hour . "-" . $rounded_min . ".csv";
?>
