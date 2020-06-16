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
			<B>
				How to file the documents.
			</B>
		</P>

</DIV>
	


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
