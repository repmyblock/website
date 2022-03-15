<?php
	$imgtoshow = "/brand/RunWithMe/RunWithMe.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV CLASS="right f80">Run With Me</DIV>

	
			<P CLASS="f50">
				Paperboy Prince is running for Congress in the 7<sup>th</sup> Congressional District and you can 
				access his website at <a href="https://paperboyprince.com/volunteer">https://paperboyprince.com/volunteer</a>	</FONT>
			</P>
			
			<P CLASS="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/RunWithMe/download">Click here to download a petition to put Paperboy Love Prince on the November Ballot</A>
			</P>
			
		
			<P CLASS="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				it's services.
			</P>
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
