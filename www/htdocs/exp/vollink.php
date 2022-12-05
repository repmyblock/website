<?php 
	$BigMenu = "home";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 	

	/* User is logged */
	
?>


<div class="main">
	<DIV class="intro">
		<P>
			<h1 class="intro">Links for Volunteers.</H1>
		</P>
		
		<P class="f60">
			<A HREF="https://github.com/repmyblock/website/issues/new" TARGET="new">Report a problem about the website</A> <i>(Require a GitHub password)</I><BR>
			<A HREF="https://github.com/repmyblock/mobile_ios/issues/new" TARGET="new">Report a problem about iPhone Mobile App</A> <i>(Require a GitHub password)</I><BR>
			<A HREF="https://github.com/repmyblock/mobile_android/issues/new" TARGET="new">Report a problem about the Android Mobile App</A> <i>(Require a GitHub password)</I><BR>
		</P>

		<P class="f60">
			<A HREF="https://apps.apple.com/us/app/testflight/id899247664" TARGET="new">Download the TestFlight application to get the Beta Version of the RepMyBlock iPhone app.</A>
		</P>
		
	</DIV>
	
	<P class="f80 center"><A HREF="/exp/<?= $middleuri ?>/login">Back to main page</A></P>


</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>