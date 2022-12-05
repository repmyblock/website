<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
	
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";
	$r = new welcome(0);	
	$result = $r->CandidatesForElection();
	WriteStderr($result, "Voter Guide");
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
?>

<DIV class="main">		
	<DIV class="right f80">Voter Guide</DIV>
 	<DIV class="panels">		
	
	<P>
	
	
	<?php 
		if (! empty ($result)) {
			foreach($result as $var) {
				
				WriteStderr($var, "Voter Guide");
				if ( ! empty ($var)) {
					
					print "<H2>" . PrintShortDate($var["Elections_Date"]) . " - " . $var["Elections_Text"] . "</H2>";
					
					
				// if ( $var["CandidateProfile_PublishProfile"] != 'no' || $var["CandidateProfile_PublishPetition"] != 'no') { 
	?>
							
	<P>
		<DIV class='container2'>
			<DIV style="float:left;">
				<IMG SRC="<?= $FrontEndStatic ?>/shared/pics/<?= $var["CandidateProfile_PicFileName"] ?>" class='iconDetails'>
			</DIV>	
			<DIV class='container3'>
					<P>
							<FONT SIZE=+1><B><?= $var["CandidateProfile_Alias"] ?></B></FONT><BR>
							<I>Running for <?= $var["CandidateElection_PetitionText"] ?></I>
					</P>
					
							<P>
								<?php if (! empty ($var["CandidateProfile_Statement"])) { print $var["CandidateProfile_Statement"]; }  ?>
							</P>
							
							<P>
								<?php if (! empty ($var["CandidateProfile_Website"])) { ?><B>Website:</B> <A TARGET="NEW" HREF="<?= $var["CandidateProfile_Website"] ?>"><?= $var["CandidateProfile_Website"] ?></A> -<?php } ?> 
					      <?php if (! empty ($var["CandidateProfile_BallotPedia"])) { ?><A TARGET="NEW" HREF="<?= $var["CandidateProfile_BallotPedia"] ?>">Ballotpedia</A><?php } ?><BR>
					      <?php if (! empty ($var["CandidateProfile_Email"])) { ?><B>Email:</B> <A TARGET="NEW" HREF="mailto:<?= $var["CandidateProfile_Email"] ?>"><?= $var["CandidateProfile_Email"] ?></A><?php } ?>
					      <?php if (! empty ($var["CandidateProfile_PhoneNumber"])) { print "- <B>Telephone:</B> " . $var["CandidateProfile_PhoneNumber"]; } ?><BR>

					      <?php if (! empty ($var["CandidateProfile_Twitter"])) { ?>Twitter: <A TARGET="NEW" HREF="https://twitter.com/<?= $var["CandidateProfile_Twitter"] ?>">@<?= $var["CandidateProfile_Twitter"] ?></A> -<?php } ?> 
					     	<?php if (! empty ($var["CandidateProfile_Facebook"])) { ?>Facebook: <A TARGET="NEW" HREF="https://facebook.com/<?= $var["CandidateProfile_Facebook"] ?>"><?= $var["CandidateProfile_Facebook"] ?></A> -<?php } ?> 
					      <?php if (! empty ($var["CandidateProfile_Instagram"])) { ?>Instagram: <A TARGET="NEW" HREF="https://instagram.com/<?= $var["CandidateProfile_Instagram"] ?>">@<?= $var["CandidateProfile_Instagram"] ?></A> -<?php } ?> 
					      <?php if (! empty ($var["CandidateProfile_TikTok"])) { print $var["CandidateProfile_TikTok"] . " - "; } ?> 
					      <?php if (! empty ($var["CandidateProfile_YouTube"])) { print $var["CandidateProfile_YouTube"] . " - "; }  ?>
					      <?php if (! empty ($var["CandidateProfile_FaxNumber"])) { print $var["CandidateProfile_FaxNumber"]; }  ?><BR>
				      </P>
						
				<?php if ( ! empty ($var["CandidateProfile_PDFFileName"])) { ?>						
					<A TARGET="PDFCandidate" HREF="<?= $FrontEndStatic ?>/shared/platforms/<?= $var["CandidateProfile_PDFFileName"] ?>">Download <?= $var["CandidateProfile_Alias"] ?>'s Platform</A>
				<?php } ?>
			</DIV>
		</DIV>
	</P>

	<?php
				}
			}
		} else {
	?>
		<H2>The guide is empty at this time.</H2>
		
	
	<?php } ?>
	</P>

<P>
	<DIV class="right f60">	
		<A HREF="<?= PrintReferer() ?>">Return to previous menu</A></B>
	</DIV>
</P>

	
<P>
	<DIV class="right f80">Notice to voters and candidates</DIV>
	
	<P>
		If you are a voter and would like to receive an update on the election in your 
		district, you can <A HREF="/<?= $middleuri ?>/exp/register/register">register</A>, 
		and we'll email you with the latest voter guide before the election.
	</P>
	
	<P>
		We do not sell your information to any candidate, and we don't track you as per 
		our <A HREF="/<?= $middleuri ?>/policies/privacy">Privacy Policy</A>.
	</P>
	
	<P>
		Any candidate can update the voter guide by updating their information by
		<A HREF="/<?= $middleuri ?>/exp/register/register">registering</A>. 
	</P>
	
	
	<DIV class="right f60">	
		<A HREF="<?= PrintReferer() ?>">Return to previous menu</A></B>
	</DIV>
		
</P>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>