<?php 
	$BigMenu = "howto";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";		
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";
	
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php"; 	
	$r = new repmyblock();
	$result = $r->ListCandidatePetitions();
	/* User is logged */
	
?>



<div class="main">
	<div class="row">
		<div class="register">				<P>
			<h1 CLASS="intro">List of Available Petitions</H1>
		</P>
		
		<?php
if ( ! empty ($result)) {
	foreach ($result as $var) {
		if ( ! empty ($var)) {
			?>

		<P CLASS="f60">
			<B>
				<A TARGET=NewPetitions HREF="<?= $FrontEndPDF ?>/multipetitions/?setid=<?= $var["CandidatePetitionSet_ID"] ?>">Petition ID <?= $var["CandidatePetitionSet_ID"] ?></A><BR>
			</B>
		</P>
		
		<?php
		}
	}
}
?>

	</DIV>
	</DIV>
</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php"; ?>
