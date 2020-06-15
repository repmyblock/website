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
	
	if ( ! empty ($result)) {
		foreach ($result as $var) {
			if ( ! empty ($var)) {
				if ( $var["Candidate_Status"] == "published") {
					$NewResult[$var["DataCounty_Name"]][NewYork_PrintPartyAdjective($var["CanPetitionSet_Party"])][$var["CandidatePetitionSet_ID"]]
										[$var["CandidatePositions_Name"]][$var["CandidateElection_DBTableValue"]] 
						= $var["Candidate_DispName"];
				}
			}	
		}
	}	
	
	
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

		if ( ! empty ($NewResult)) {
			foreach ($NewResult as $County => $VarAftCty) {
				if ( ! empty ($County)) { 
					print "<h2><U>" . $County . " County</U></H2>\n";
						foreach ($VarAftCty as $Party => $VarAftParty) {
							print "<h3>" . $Party . " Party</H3>\n";
								foreach ($VarAftParty as $IDGroup => $VarAftID) {
								echo "<H5>";
									foreach ($VarAftID as $Position => $VarAftPosition) {
										foreach ($VarAftPosition as $Candidate ) {					
					?>
										<A TARGET=NewPetitions HREF="<?= $FrontEndPDF ?>/multipetitions/?setid=<?= $IDGroup ?>"><?= $Candidate ?></A> <I>(<?= $Position ?>)</I>
			
					<?php
								}	
							}
							echo "</H5>";
						
						}
						echo "<BR>";
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
