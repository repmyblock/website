<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
?>
<DIV class="main">
	<DIV CLASS="right f80">Forgot Password</DIV>

		<DIV>
			<P CLASS="f60 justify">
				We sent you an email with a link.
			</P>
		</DIV>
		
		<DIV>
			<P CLASS="f40">
				If you don't receive an email in the next few hours, 
				please sent an email to passwordissues@repmyblock.nyc
			</P>
		</DIV>
		
	</DIV>
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php"; ?>


