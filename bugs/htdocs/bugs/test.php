<?php
	$Menu = "voters";
	$BigMenu = "represent";	
	
#	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
#	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_trac.php";  
#	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }

	$rmb = new Trac();	
	$result = $rmb->ListTickets();
	
	echo "<PRE>" . print_r($result, 1) . "</PRE>";

	if ( ! empty ($_POST)) {
		
		echo "<PRE>" . print_r($_POST, 1) . "</PRE>";
		exit();
	
		$TicketArray["type"]= $_POST[""];
		$TicketArray["time"] = $_POST[""]; 
		$TicketArray["changetime"]= $_POST[""];
		$TicketArray["component"]= $_POST[""];
		$TicketArray["severity"]= $_POST[""];
		$TicketArray["priority"]= $_POST[""];
		$TicketArray["owner"]= $_POST[""];
		$TicketArray["reporter"]= $_POST[""];
		$TicketArray["cc"]= $_POST[""];
		$TicketArray["version"]= $_POST[""];
		$TicketArray["milestone"]= $_POST[""];
		$TicketArray["status"]= $_POST[""];
		$TicketArray["resolution"]= $_POST[""];
		$TicketArray["summary"]= $_POST[""];
		$TicketArray["description"]= $_POST[""];
		$TicketArray["keywords"]= $_POST[""];
		
		$rmb->CreateTicket($TicketArray);
		echo "Saved the ticket information into the system";
		exit();
		
	}
?>	

<FORM ACTION="" METHOD="POST">
	<INPUT TYPE="hidden" NAME="ORIGINAL_K" VALUE="<?= $_REQUEST['k'] ?>">
	<INPUT TYPE="hidden" NAME="BUGREFERER" VALUE="<?= $_REQUEST['HTTP_REFERER'] ?>">
	<INPUT TYPE="hidden" NAME="ENDODING" VALUE="<?= $_REQUEST['HTTP_ACCEPT_ENCODING'] ?>">
	<INPUT TYPE="hidden" NAME="LANGUAGE" VALUE="<?= $_REQUEST['HTTP_ACCEPT_LANGUAGE'] ?>">
	<INPUT TYPE="hidden" NAME="REMOTE_ADDR" VALUE="<?= $_REQUEST['REMOTE_ADDR'] ?>">
	<INPUT TYPE="hidden" NAME="BUGREQUESTIME" VALUE="<?= $_REQUEST['REQUEST_TIME'] ?>">

	What were you doing?
	<TEXTAREA COLS=70 ROWS=10 NAME="Doing"></TEXTAREA>

	What were you expecting?
	<TEXTAREA COLS=70 ROWS=10 NAME="Expectations"></TEXTAREA>

	Result you saw?
	<TEXTAREA COLS=70 ROWS=10 NAME="Result"></TEXTAREA>	

</FORM>

