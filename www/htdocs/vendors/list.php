<?php
	// $imgtoshow = "/brand/RunWithMe/RunWithMe.png";
	$HeaderTwitter = 1;
	$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/paste/VendorListCompilation.jpg";
	$HeaderTwitterDesc = "Vendors.";   
	$HeaderTwitterTitle = "Compilation of Political Vendors for your campaign.";   
	
	$HeaderOGImage = $HeaderTwitterPicLink;
	$HeaderOGDescription = $HeaderTwitterDesc;
	$HeaderOGImageWidth = "450";
	$HeaderOGImageHeight = "253";
			
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_display.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
		
	$r = new display();
	$Title = $r->listvendors();
?>
<DIV class="main">
	<DIV class="right f80">Vendor List</DIV>

	<BR>&nbsp;<BR>
	<?php /* <h4><P class="f60"></P></h4> */ ?>

	<UL>
	<?php if (! empty ($Title)) {
		foreach ($Title as $Var) {
			if ( !empty ($Var)) { ?>
				
		<P>
			<B><U><?= $Var["Vendor_Name"] ?></U></B>
			<BR>
			<UL>
				<?= $Var["Vendor_Pitch"] ?><BR>
				<B><A HREF="<?= $Var["Vendor_URL"] ?>" TARGET="TESTNEW"><?= $Var["Vendor_URL"] ?></A></B>
			</UL>
		</P>
	<?php }
		}
	} ?>
	</UL>
	
	<P>
		If you are a vendor and wish to be added to our vendor list, please email 
		<A HREF="mailto://vendor@register.repmyblock.org">vendor@register.repmyblock.org</A>.
	</P>
			
	<P class="f40">
		Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
		it's services.
	</P>
			
</DIV>		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
