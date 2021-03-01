<?php 
	$BigMenu = "howto";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 	

	/* User is logged */
	
?>

<div class="main">
		<P>
			<h1 CLASS="intro">Contact</H1>
		</P>
		
		<P CLASS="f60">
				To contact us, send an email at <B><A HREF="mailto:infos@repmyblock.nyc">infos@repmyblock.nyc</A></B>.<BR>
				To report an issue with the website, <B><A HREF="<?= $FrontEndBugs ?>/bugs/<?= CreateEncoded ( array( 	
																																							"Referer" =>  $_SERVER['HTTP_REFERER'],
																																							"URI" => $_SERVER['REQUEST_URI'],
																																							"DocumentRoot" => $_SERVER['DOCUMENT_ROOT'],
																																							"Version" => $BetaVersion,
																																							"PageRequestTime" => $_SERVER['REQUEST_TIME']
																																				))?>/intake">please report it on our bug intake page</A></B>.
		</P>

</DIV>
	


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
