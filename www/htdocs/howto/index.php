<?php 
	$BigMenu = "howto";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php"; 	

	/* User is logged */
	
?>

<div class="main">
	<div class="row">
		<div class="register">				<P>
			<h1 CLASS="intro">How to file</H1>
		</P>
		
		<P CLASS="f60">
			<B>How to file the documents.</B>
		</P>

		<P CLASS="f40">
			The filing period will begin on <B>March 30<SUP>th</SUP></B> and end at midnight on April 2<SUP>nd</SUP>. 
			<B>You do not need to drop your petitions before March 30<SUP>th</SUP>.</B>
		<BR>
			Before you drop your petitions, you will need to apply for a Pre Assigned ID Number by 
			<B><A HREF="<?= $FrontEndPDF ?>/NYS/NYC/CRU_PreFile" TARGET="CRU">completing the Petition Pre Assigned Identification Number Application</A></B>
			and mailing it to the Candidate Record Unit at the Board of Election.
		<BR>
		 <I>(If you have used the RepMyBlock system, <A HREF="/login"><B>log into your account</B></A> to download a custom pre-filed one.)</I>
		</P>
		
		<P>
			<IMG SRC="BOECalendar.png">
		</P>
	</DIV>
	</DIV>
</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php"; ?>
