<?php
	include "brandheader.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80">Run Democratic and Republican Presidential Delegates</DIV>
	
			<P class="f50">
				Restore the Fourth oppose unconstitutional mass government surveillance
			</P>
			
			<P class="f50">
				Part of our mission is educating both the public and lawmakers about issues that threaten Americans' 
				Fourth Amendment rights. That's why we have been developing a series of issue briefs that explain common 
				Fourth Amendment issues from civil asset forfeiture to biometric surveillance technologies.
			</P>

			<P class="f50">
				If you want to support the cause, please signup to pledge your signature to one of the Restore the 4th petition 
				between December 18, 2023 and January 18, 2024.
			</P>
		
			<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/restorethe4th/search">Click here to check your registration</A>
			</P>
			
			<P class="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services.
			</P>
			
			<P class="f50">
				This page is maintained by the New York City <B><A HREF="https://restorethe4th.com" TARGET="RT4">Restore the Fourth</A></B>.
				Check the national website page at <B><A HREF="https://restorethe4th.com" TARGET="RT4">https://restorethe4th.com</A>.
			</P>
		
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
