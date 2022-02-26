<?php 
	$BigMenu = "contact";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 	

	/* User is logged */
	
?>

<div class="main">
		<P>
			<h1 CLASS="intro">Contact</H1>
		</P>
		
		<P CLASS="f60">
			Please email 	<B><A HREF="infos@repmyblock.nyc">infos@repmyblock.nyc</A></B> for general inquiries.
		</P>
		
		<P CLASS="f60">
			If you want to help grow the project, 
			<B><A HREF="/<?= $middleuri ?>/volunteer/tothecause">please check the volunteer page</A></B>.
		</P>

</DIV>
	


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
