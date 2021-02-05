<?php
	$Menu = "voters";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_trac.php";  
#	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	

	if ( ! empty ($_POST)) {
		
		echo "<PRE>" . print_r($_POST, 1) . "</PRE>";
				
		$TicketArray["type"]= "defect";
		$TicketArray["time"] = $_POST["PageRequestTime"] . "000000";
		$TicketArray["changetime"]= $_POST["BUGREQUESTIME"] . "000000";
		$TicketArray["component"]= "Main Website";
		$TicketArray["severity"]= "Broken";
		$TicketArray["priority"]= "critical";
		$TicketArray["owner"]= "";
		$TicketArray["reporter"]= "Bug Track";
		$TicketArray["cc"]= $_POST[""];
		$TicketArray["version"]= $_POST["Version"];
		$TicketArray["milestone"]= $_POST[""];
		$TicketArray["status"]= "new";
		$TicketArray["resolution"]= $_POST[""];
		$TicketArray["summary"]= $_POST["Doing"];
		$TicketArray["description"]= "**Expectations:**\n\\\\" . $_POST["Expectations"] . "\n\n**Result:**\n\\\\" . $_POST["Result"] . "\n\n";
		$TicketArray["keywords"]= $_POST[""];
		
		$rmb = new Trac();	
		$rmb->CreateTicket($TicketArray);
		echo "Saved the ticket information into the system";
		
		
			
		
		$NextScreen = "Thanks";
		header("Location: /bugs/" . $NextScreen . "/thanks");
		
		exit();
		
	}

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 	
	
	
	$Referer = $_SERVER['HTTP_REFERER'];
	preg_match('/.*\.repmyblock\.nyc\/([^\/]*)\/([^\/]*)\/(.*)/', $_SERVER['HTTP_REFERER'], $matches, PREG_OFFSET_CAPTURE);
	
	$URLRef = "/" . $matches[1][0] . "/" . $matches[3][0];
	
	if ( strlen( $matches[2][0]) > 64 ) {
		// echo "Matches: " . $matches[2][0] . "<BR>";		
		$URLRefDecode = urldecode($matches[2][0]);
		if ( ! empty ($URLRefDecode )) {	
			parse_str (DecryptURL($URLRefDecode), $URLRefDecrypt);
		}
	}

	if ( ! empty ($_GET["k"] )) {	
		parse_str (DecryptURL($_GET['k']), $DecryptInfo);
	//	print "<PRE>" . print_r($DecryptInfo, 1) . "</PRE>";
	}
	
	
?>	





<div class="main">
	<DIV CLASS="intro center">
		<P>
			<h1 CLASS="intro">Bug intake for page <?= $URLRef ?></H1>
		</P>
		
		<P>
			<FONT COLOR=BROWN><B>Please do not enter any confidencial or personal information</B></FONT> such as social security, password,
			credit card numbers, or any identifying information. All the bug information is visible by the world at large.
		</P>
		
		<P>
			If you need to enter an address or a telephone number, use the Confidential Information box 
			at the botton but remember that even protected, it is still shared with a number of developpers.
		</P>
		
<FORM ACTION="" METHOD="POST">
	<INPUT TYPE="hidden" NAME="SystemID" VALUE="<?= $URLRefDecrypt["SystemUser_ID"] ?>">
	<INPUT TYPE="hidden" NAME="Version" VALUE="<?= $DecryptInfo["Version"] ?>">
	<INPUT TYPE="hidden" NAME="PageRequestTime" VALUE="<?= $DecryptInfo["PageRequestTime"] ?>">
	<INPUT TYPE="hidden" NAME="OriginalK" VALUE="<?= $_GET["k"] ?>">
	<INPUT TYPE="hidden" NAME="BUGREFERER" VALUE="<?= $_SERVER["HTTP_REFERER"] ?>">
	<INPUT TYPE="hidden" NAME="ENDODING" VALUE="<?= $_SERVER["HTTP_ACCEPT_ENCODING"] ?>">
	<INPUT TYPE="hidden" NAME="LANGUAGE" VALUE="<?= $_SERVER["HTTP_ACCEPT_LANGUAGE"] ?>">
	<INPUT TYPE="hidden" NAME="REMOTE_ADDR" VALUE="<?= $_SERVER["REMOTE_ADDR"] ?>">
	<INPUT TYPE="hidden" NAME="BUGREQUESTIME" VALUE="<?= $_SERVER["REQUEST_TIME"] ?>">

<P>
	<H2>Enter a quick summary of what were you doing.</H2>
	<TEXTAREA COLS=70 ROWS=6 NAME="Doing"></TEXTAREA>
</P>

<P>
		<H2>What were you expecting?</H2>
	<TEXTAREA COLS=70 ROWS=6 NAME="Expectations"></TEXTAREA>
</P>

</P>
	<H2>Is this a cosmectic issue?</H2><BR>
	The website still works but it doesn't look good or it's confusing<BR>
	
			<INPUT TYPE="radio" VALUE="yes" NAME="cosmetic"> Yes&nbsp;&nbsp;
			<INPUT TYPE="radio" VALUE="no" NAME="cosmetic"> No
</P>

<P>
		<H2>What results did you experience?</H2>
	<TEXTAREA COLS=70 ROWS=6 NAME="Result"></TEXTAREA>	
</P>


</P>
	<H2>Did you have to stop using RepMyBlock?</H2><BR>
			The website wouldn't allow you to get futher.<BR>
			<INPUT TYPE="radio" VALUE="yes" NAME="blocker"> Yes&nbsp;&nbsp;
			<INPUT TYPE="radio" VALUE="no" NAME="blocker"> No
</P>


<P>
	<h2>Confidential information on this window.</H2>
	<TEXTAREA COLS=70 ROWS=6 NAME="SecretInformation"></TEXTAREA>	
</P>

<INPUT TYPE="SUBMIT" NAME="" VALUE="Submit the problem">

</FORM>

</DIV>

</div>
	<?php // print phpinfo(); ?>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>


