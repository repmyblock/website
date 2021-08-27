<?php 
	$BigMenu = "home";
	$MapShow = true;
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 	
	
	WriteStderr($URIEncryptedString, "Result Of the Proposal");		

?>

<div class="main">
	<DIV CLASS="right f80">Nominate</DIV>
	

		<P CLASS="f60">
		 Thanks <?= $URIEncryptedString["RefName"] ?>,	
		</P>
		
		
		
		<P CLASS="f40">
			We sent an email to your friend <?= $URIEncryptedString["FirstName"] ?> with a link to where to accept the nomination.
		</P>
		
	
		
		<P CLASS="f40">
			Petitioning for the County Committee will start in February 2022. To participate, you must ensure you are a 
			member of one of the four parties recognized in New York State; Conservative, Working Families, Republican or Democrat. 
			Feel free to reach out to any of the parties for more information.
		</P>
		
		
		
		<P CLASS="f40">
			We want to invite you to check out the preview of this documentary called "County." A 
			Democratic Party Queens county committee member is currently putting the finishing touches on. 
			If you want to help him in his project, you can help him by donating a few dollars to his 
			project <A HREF="https://www.gofundme.com/f/county-film">on his GoFundMe page</A>.
		</P>
		
	
		
		<P CLASS="center">
			<iframe width="560" height="315" src="https://www.youtube.com/embed/cP5PMTccc1k" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</P>
		
	
		
		<P CLASS="f40">
			<B>
				Rep My Block is a non-partisan effort to get New Yorkers to a party leadership that represent their collective value. 
			</B>
		</P>

		
				
							
							

<?php /*		
		<P>
			<link rel="stylesheet" href="/maps/RepMyBlockMaps.1f948dd0.css">
			<div id="map" class="map"></div>
		  <span id="status"></span>
		  <script src="/maps/RepMyBlockMaps.c7bbff3b.js"></script>
	  </P>
	 */ ?>
		
		<P CLASS="f80 center"><A HREF="/exp/<?= $middleuri ?>/register">Register on the Rep My Block website</A></P>
	</DIV>

</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>