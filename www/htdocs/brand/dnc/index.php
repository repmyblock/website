<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	$imgtoshow = "/brand/dnc/democratic.png";
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
<DIV CLASS="right f80">Download a Democratic County Committee petition</DIV>
	
			<P CLASS="f50">
			Democrats are running a few candidates for congress and we need your help to get them on the ballot.
			</P>
			
			<P CLASS="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/dnc/download">Click here to download a petition to put a Socialist candidate on the August Ballot</A>
			</P>
			
			<P CLASS="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services.
			</P>
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>