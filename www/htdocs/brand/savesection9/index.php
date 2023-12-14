<?php
	$HeaderTwitter = "yes";
	$HeaderTwitterTitle = "Save Section 9 - Rep My Block";
	$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/paste/SaveSection9.jpg";
	$HeaderTwitterDesc = "Save Section 9, Run for Presidential Delegate.";
	$HeaderOGTitle = "Save Section 9, Run for Presidential Delegate.";
	$HeaderOGDescription = "Save Section 9, Run for Presidential Delegate.";
	$HeaderOGImage = "https://static.repmyblock.org/pics/paste/SaveSection9.jpg"; 
	$HeaderOGImageWidth = "960";
	$HeaderOGImageHeight = "541";
	
	$imgtoshow = "/brand/savesection9/SaveSection9.png";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80">Run Biden Presidential Delegates</DIV>
	
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
				<A HREF="/<?= $middleuri ?>/brand/savesection9/search">Click here to check your registration</A>
			</P>
			
			<P class="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services.
			</P>
			
			<P class="f50">
				This page is maintained by the <B><A HREF="https://www.facebook.com/groups/savesection9" TARGET="SS9">Save Section 9</A></B>.
				Check their facebook page at <B><A HREF="https://www.facebook.com/groups/savesection9" TARGET="SS9">https://www.facebook.com/groups/savesection9</A>.
			</P>
		
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
