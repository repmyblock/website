<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";		
?>

<div class="row">
	<div class="main">
		<P CLASS="f60">
			We just sent you another email with the instructions on completing the registration. 
			<FONT COLOR=BROWN>You won't be able</FONT> to fully continue 
			using the Rep My Block until you complete the second email verification.
		</P>
		
		<P CLASS="f60">
			You will need <FONT COLOR=BROWN><B>to forward that second email</B></FONT> to 
			<B>notif@repmyblock.org</B> and then you will need <FONT COLOR=BROWN><B>to 
			click on the verification button</B></FONT>.		
		</P>

		<P CLASS="f60">
			While you wait for that second email, you can continue with the login process 
			and setup your personal profile.
		</P>
		
		<p CLASS="f60">
			<A HREF="/<?= $middleuri ?>/exp/login/login">Click here to the login page.</A>
		</P>
	</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>