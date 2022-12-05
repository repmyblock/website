<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	$imgtoshow = "/brand/gop/gop.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80">Download a Republican County Committee petition</DIV>
	
			<P class="f50">
			Republicans are running a few candidates for congress and we need your help to get them on the ballot.
			</P>
			
			<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/gop/download">Click here to download a petition to put a Republican 
					candidate on the August Ballot</A>
			</P>
			
			<P class="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services.
			</P>
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
