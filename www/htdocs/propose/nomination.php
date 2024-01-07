<?php 
	$BigMenu = "home";
	$MapShow = true;
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 	

	/* User is logged */
	$LongLat = "[-73.8710, 40.6928]"; $Zoom = 11;
	
?>

<div class="main">
	<DIV class="intro center">
		<P>
			<h1 class="intro">Rep My Block is a non partisan website.</H1>
		</P>
		
		<P class="f60">
			<B>
				Rep My Block is a non-partisan effort to collect, organize and make 
				accessible the full membership of the county committees in New York State. 
				New York State's county committees are the basis of local government and 
				are made up of publicly elected representatives. However, county committee 
				membership information has traditionally been hard to access. 
			</B>
		</P>

		<P>
			<link rel="stylesheet" href="/maps/RepMyBlockMaps.1f948dd0.css">
			<div id="map" class="map"></div>
		  <span id="status"></span>
		  <script src="/maps/RepMyBlockMaps.c7bbff3b.js"></script>
	  </P>
		
		<P class="f80 center"><A HREF="/<?= $middleuri ?>/register/user">Register on the Rep My Block website</A></P>
	</DIV>

</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>