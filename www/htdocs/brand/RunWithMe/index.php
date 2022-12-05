<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	$imgtoshow = "/brand/RunWithMe/RunWithMe.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80">Run With Me</DIV>
	
			<P class="f50">
				Paperboy Prince is running for Congress in every Congressional District, and you can 
				access his website at <a href="https://paperboyprince.com/volunteer">https://paperboyprince.com/volunteer</a>	</FONT>
			</P>
			
			<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/RunWithMe/download">Click here to download a petition to put Paperboy Love Prince on the June Ballot</A>
			</P>
			
			<P class="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services.
			</P>
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
