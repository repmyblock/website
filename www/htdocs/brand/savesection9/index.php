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
				Save Section 9 aims to stop the privatization of America's public housing. We work to secure the federal 
				funding necessary to preserve public housing. We work to educate, and empower tenants to advocate for 
				the preservation of their homes.
			</P>
			
			<P class="f50">
				In order to get the attention of the federal elected officials to properly fund Public Housing, we are 
				running a slate of NYCHA resident delegates everywhere.
			</P>

			<P class="f50">
				If you want to support the cause, please signup to pledge your signature to one of the NYCHA petition 
				between December 18, 2023 and January 18, 2024.
			</P>
		
			<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/search">Click here to check your registration</A>
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
