<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";		
?>
<DIV class="main">
		
	<DIV CLASS="right f80">Forgot My Username</DIV>

		<P CLASS="f60">
			Your username is <B><?= $URIEncryptedString["UserName"] ?></B>
		</P>
	
		<p CLASS="f60">
			<A HREF="/<?= $k ?>/exp/login/login">Click here to the login page.</A>
		</P>
	</DIV>
	
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>