<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";		
?>

<div class="row">
	<div class="main">


		<P CLASS="f80">
			To continue, login with the credentials you just created.
		</P>
		
		<p CLASS="f80">
			<A HREF="/<?= $middleuri ?>/exp/login/login">Click here to the login page.</A>
		</P>
		
		
		<p CLASS="f60">
			The instructional video will show you what to expect once you login for the first time.
		</P>
			
		</P>
		<CENTER>
			<iframe width="560" height="315" src="https://www.youtube.com/embed/7_A5JlEyMc8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</CENTER>
		</P>
		
		<p CLASS="f80">
			<A HREF="/<?= $middleuri ?>/exp/login/login">Click here to the login page.</A>
		</P>
		
	</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>