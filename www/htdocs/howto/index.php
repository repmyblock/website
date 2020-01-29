<?php 
	$BigMenu = "howto";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php"; 	

	/* User is logged */
	
?>

<div class="main">
	<div class="row">
		<div class="register">				<P>
			<h1 CLASS="intro">How to file</H1>
		</P>
		
		<P CLASS="f60">
			<B>
				How to file the documents.
			</B>
		</P>

	</DIV>
	</DIV>
</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php"; ?>
