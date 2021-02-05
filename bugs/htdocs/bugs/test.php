<?php
	$Menu = "voters";
	$BigMenu = "represent";	
	
#	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
#	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_trac.php";  
#	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }

	$rmb = new RepMyBlock();	
	$result = $rmb->ListTickets();
	
	echo "<PRE>" . print_r($result, 1) . "</PRE>";

?>	