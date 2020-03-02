<?php 
	$BigMenu = "howto";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";		
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";
	
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php"; 	
	$r = new repmyblock();
	$result = $r->ListCandidatePetitions("2020-02-24 00:00:00");
?>



<div class="main">
	<div class="row">
		<div class="register">			
			
		<P>
			<h1 CLASS="intro">List of Available Petitions</H1>
		</P>
		
		<P CLASS="f60">
				<B>
					<UL>
		<?php
		$Counter = 0;
			
if ( ! empty ($result)) {
	foreach ($result as $var) {
		if ( ! empty ($var)) {
			$Counter++;
			?>

		
					<A TARGET=NewPetitions HREF="<?= $FrontEndPDF ?>/multipetitions/?setid=<?= $var["CandidatePetitionSet_ID"] ?>">Petition ID <?= $var["CandidatePetitionSet_ID"] ?></A>
			
			
			<?php
			
			if ( ($Counter % 5) == 0) {
				print "<BR>";
			}
		
		
		}
	}
}
?>
</UL>
	</B>
			</P>
	</DIV>
	</DIV>
</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php"; ?>
