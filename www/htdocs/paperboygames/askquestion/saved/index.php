<?php
	$imgtoshow = "/RunWithMe/RunWithMe.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers_paperboygames.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
		
		
?>
<DIV class="main">
	<DIV CLASS="right f80"><FONT SIZE=+3>Paperboys Games</FONT></DIV>
			
			<BR>
			
	<P>
		<FONT SIZE=+1><B>Your question has been saved.</B></FONT>
	</P>
	
	<P>
		<B><A HREF="https://nycabsentee.com/">Request your Absentee Ballot Online</A></B>
	</P>


	<P>
		<A HREF="../../">Return to the main page.</A>
	</P>
		
			
	
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php"; ?>
