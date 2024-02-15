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
			I am running against Hakeem Jeffries because I believe in Universal Basic Income, I am pro-choice, and Medicare for All. I am a Socialist, a Small Business 
			owner. I believe in the principle set forth by Marthin Luther King and I believe Hakeem Jeffries has forgotten them. Our district need someone that will 
			represent all of us and not make excuse on why we can have UBI, or Medicare for All.
			</P>

			
			<P class="f80bold center">
			If you believe in what I believe, then help me get on the ballot by 
				<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/search">checking your registration</A> and singing the petition.
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


