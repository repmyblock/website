<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
	
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
		
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	
?>
<DIV class="main">
		
	<DIV class="right f80">Check Email</DIV>

	<P class="f40">
		Dear <B><?= $URIEncryptedString["FirstName"] ?></B>, <BR>
		<BR>Please check your email at  <B><FONT COLOR="BROWN"><?= $URIEncryptedString["Email"] ?></FONT></B>.
	</P>
	
	<P class="f40">
		You should be receiving all the information to use the RepMyBlock tools to help with the 
		<B><FONT COLOR="BROWN"><?= $URIEncryptedString["Campaign"] ?></FONT></B> 
		campaign.
	</P>

</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>