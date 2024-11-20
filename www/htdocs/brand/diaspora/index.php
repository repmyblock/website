<?php
	include "brandheader.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80 p10">Help candidates that represent your diaspora in New York State!</DIV>
	
		<P>
			Help elect candidates that represent your community across New York State in 2025.
		</P>
		
		<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/check">Click here to verify 
					your eligibility!</A>
		</P>
	
		<P>
	<DIV class="videowrapper center">
	<iframe width="560" height="315" src="https://player.pbs.org/viralplayer/3092354878/" allowfullscreen allow="encrypted-media" style="border: 0;"></iframe>
			</DIV>
		</P>
	
	
			
			<?php /*
			<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/check">Click here to verify your eligibility to run for the 
					New York or Richmond County Committee governance 
					board in June 2023.</A>
			</P>
			*/ ?>

				<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/check">Click here to verify 
					your eligibility!</A>
		</P>
			
			<P class="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services.
			</P>
			
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
