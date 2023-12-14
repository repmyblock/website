<?php
	include "brandheader.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80"><?= $BrandingTitle ?></DIV>
	
			<P class="f50">
				Right now, we are facing the interlocking catastrophes of a rigged democracy, global pandemic, unimaginable and 
				growing wealth inequality, racial injustice, and the escalating impacts of the climate crisis. We're fighting back. 
				People like you are leading local Indivisible groups in every single state. Be part of history--join the Indivisible movement.
			</P>
			
			<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/search">Be part of history and run for County Committee.</A>
			</P>
			
			<P class="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services.
			</P>
			
			<P class="f50">
				<?= $BrandingMaintainer ?>
			</P>
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>


