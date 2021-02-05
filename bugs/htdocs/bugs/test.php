<?php
	$Menu = "voters";
	$BigMenu = "represent";	
	
#	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
#	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_trac.php";  
#	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }

	

	if ( ! empty ($_POST)) {
		
		echo "<PRE>" . print_r($_POST, 1) . "</PRE>";
		
		
		
		$TicketArray["type"]= "defect";
		$TicketArray["time"] = $_POST[""]; 
		$TicketArray["changetime"]= $_POST[""];
		$TicketArray["component"]= "Main Website";
		$TicketArray["severity"]= "Broken";
		$TicketArray["priority"]= "critical";
		$TicketArray["owner"]= $_POST[""];
		$TicketArray["reporter"]= $_POST[""];
		$TicketArray["cc"]= $_POST[""];
		$TicketArray["version"]= "dev-2020-b40";
		$TicketArray["milestone"]= $_POST[""];
		$TicketArray["status"]= $_POST["new"];
		$TicketArray["resolution"]= $_POST[""];
		$TicketArray["summary"]= $_POST["Doing"]
		$TicketArray["description"]= "Expectations:<BR>" . $_POST["Expectation"] . "<BR>Result:<BR>" . $_POST["Result"] . "<BR>" . $_POST["ORIGINAL_K"];
		$TicketArray["keywords"]= $_POST[""];
		
		$rmb = new Trac();	
		$rmb->CreateTicket($TicketArray);
		echo "Saved the ticket information into the system";
		exit();
		
	}
?>	

<H1>Enterering Bugs.</H1>

<FORM ACTION="" METHOD="POST">
	<INPUT TYPE="hidden" NAME="ORIGINAL_K" VALUE="<?= $_REQUEST['k'] ?>">
	<INPUT TYPE="hidden" NAME="BUGREFERER" VALUE="<?= $_REQUEST['HTTP_REFERER'] ?>">
	<INPUT TYPE="hidden" NAME="ENDODING" VALUE="<?= $_REQUEST['HTTP_ACCEPT_ENCODING'] ?>">
	<INPUT TYPE="hidden" NAME="LANGUAGE" VALUE="<?= $_REQUEST['HTTP_ACCEPT_LANGUAGE'] ?>">
	<INPUT TYPE="hidden" NAME="REMOTE_ADDR" VALUE="<?= $_REQUEST['REMOTE_ADDR'] ?>">
	<INPUT TYPE="hidden" NAME="BUGREQUESTIME" VALUE="<?= $_REQUEST['REQUEST_TIME'] ?>">

<P>
	What were you doing?<BR>
	<TEXTAREA COLS=70 ROWS=10 NAME="Doing"></TEXTAREA>
</P>

<P>
	What were you expecting?<BR>
	<TEXTAREA COLS=70 ROWS=10 NAME="Expectations"></TEXTAREA>
</P>

<P>
	Result you saw?<BR>
	<TEXTAREA COLS=70 ROWS=10 NAME="Result"></TEXTAREA>	
</P>

<P>
	Please enter any confidential information on this window. <BR>
	<TEXTAREA COLS=70 ROWS=10 NAME="SecretInformation"></TEXTAREA>	
</P>

<INPUT TYPE="SUBMIT" NAME="" VALUE="Submit the problem">

</FORM>

