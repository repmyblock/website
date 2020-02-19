<?php 
	$BigMenu = "home";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php"; 	

	/* User is logged */
	
?>


<div class="main">
	<DIV CLASS="intro center">
		<P>
			<h1 CLASS="intro">Policies.</H1>
		</P>
		
		<P CLASS="f60">
			<B>
				Rep My Block is a non-partisan effort to collect, organize and make 
				accessible the full membership of the county committees in New York State. 
				New York State's county committees are the basis of local government and 
				are made up of publicly elected representatives. However, county committee 
				membership information has traditionally been hard to access. 
			</B>
		</P>
		
		<P CLASS="f60">
			<B>
				Here goes the policies.
			</B>
		</P>
	</DIV>
	
	<P CLASS="f80 center"><A HREF="/register">Register on the Rep My Block website</A></P>


</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php"; ?>