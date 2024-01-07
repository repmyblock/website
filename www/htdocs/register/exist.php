<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";		
?>

<div class="row">
	<div class="main">


		<P class="f80">
			The email <FONT COLOR=BROWN><?= $URIEncryptedString["Email"] ?></FONT> already exist in the system.
		</P>	

		<P class="f60">		
			Click here if you <A HREF="/<?= $middleuri ?>/user/forgotuser">forgot your username</A> or 
			here if you <A HREF="/<?= $middleuri ?>/user/forgotpwd">forgot your password</A>.
		</P>
				
		<p class="f80">
			Otherwise <A HREF="/<?= $middleuri ?>/user/login">click here for the login page.</A>
		</P>
		
		
		<p class="f60">
			The instructional video will show you what to expect once you login for the first time.
		</P>
			
		</P>
		
		<DIV class="videowrapper">
	 		<iframe src="https://www.youtube.com/embed/7_A5JlEyMc8?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</DIV>

		</P>
		
		<p class="f80">
			<A HREF="/<?= $middleuri ?>/user/login">Click here to the login page.</A>
		</P>
		
	</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>