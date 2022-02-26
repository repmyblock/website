<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";		
?>
<DIV class="main">
		
	<DIV CLASS="right f80">Forgot My Username</DIV>

		<P CLASS="f60">
			Could not find that Username in the database. <B>Make sure you copy the link in the
			email exactly.</B>
		</P>
	
		<p CLASS="f60">
			<A HREF="/<?= $k ?>/exp/login/login">Click here to the login page.</A>
		</P>
	</DIV>
	
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>