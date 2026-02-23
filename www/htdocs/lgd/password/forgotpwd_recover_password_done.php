<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";		
?>
<DIV class="main">
		
	<DIV class="right f80">Forgot Password</DIV>

		<DIV class="f60bold">
			The password was changed.
		</DIV>
	
		<p class="f60">
			<A HREF="/<?= $middleuri ?>/user/login">Click here to the login page.</A>
		</P>
	</DIV>
	
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>