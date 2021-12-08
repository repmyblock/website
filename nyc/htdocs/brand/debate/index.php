<?php
	$imgtoshow = "/brand/RunWithMe/RunWithMe.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
	
?>
<DIV class="main">
		<DIV CLASS="right f80"><FONT SIZE=+3>Paperboys Games</FONT></DIV>
			
			<BR>
			
	<P>
		The Paperboy Games is a mix of artistery and political debates where every candidate is given a
		chance to debate publicly their oponent.
	</P>
			
	<P>
		This is a service offered to every candidates running for office in New York City. The goal is 
		to give a voice to every local candidate and also be entertaining.
	</P>
	
	<P>If you like to chalenge your chalenger, please email Theo Chino at <B>theo@repmyblock.nyc</B></P>
	
	<P>
	<A HREF="../debate">I am a candidate and would like to participate.</A><BR>
	<A TARGET="pbgames" HREF="https://www.paperboyprince.com/openmic">I am a NYC artist and would like to sign up to perform.</A><BR>
</P>
		
			<P>
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				it's services.
			</P>
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
