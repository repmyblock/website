<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
	
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";
	$r = new welcome();	
	
	$result = $r->CandidatesInfo();
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
?>

<DIV class="main">		
	<DIV CLASS="right f80">Voter Guide</DIV>
 	<DIV class="panels">		
	
	<P>
	<H2>New York Primary: June 18<SUP>th</SUP>, 2022</H2>
	
	<?php 
		if (! empty ($result)) {
			foreach($result as $var) {
				
				WriteStderr($var, "Voter Guide");
				if ( $var["CandidateProfile_PublishProfile"] != 'no' || $var["CandidateProfile_PublishPetition"] != 'no') { 
	?>
							
	<P>
		<DIV class='container2'>
			<DIV style="float:left;">
				<IMG SRC="<?= $FrontEndStatic ?>/shared/pics/<?= $var["CandidateProfile_PicFileName"] ?>" class='iconDetails'>
			</DIV>	
			<DIV class='container3'>
				<FONT SIZE=+1><B><?= $var["CandidateProfile_Alias"] ?></B></FONT><BR>
				<I>Running for Democratic Party County Commmittee Member for the 2nd Electoral District in the 71st Assembly District.</I>
				<BR>
				<P>
					<B>Website:</B> <A TARGET="NEW" HREF="<?= $var["CandidateProfile_Website"] ?>"><?= $var["CandidateProfile_Website"] ?></A> - 
		      <B>Email:</B> <A TARGET="NEW" HREF="mailto:<?= $var["CandidateProfile_Email"] ?>"><?= $var["CandidateProfile_Email"] ?></A><BR>
		      <A TARGET="NEW" HREF="https://twitter.com/<?= $var["CandidateProfile_Twitter"] ?>">@<?= $var["CandidateProfile_Twitter"] ?></A> - 
		     	<A TARGET="NEW" HREF="https://facebook.com/<?= $var["CandidateProfile_Facebook"] ?>"><?= $var["CandidateProfile_Facebook"] ?></A> - 
		      <A TARGET="NEW" HREF="https://instagram.com/<?= $var["CandidateProfile_Instagram"] ?>">@<?= $var["CandidateProfile_Instagram"] ?></A> - 
		      <?= $var["CandidateProfile_TikTok"] ?> - 
		      <?= $var["CandidateProfile_YouTube"] ?> - 
		      <?= $var["CandidateProfile_BallotPedia"] ?><BR>
		      <B>Telephone:</B> <?= $var["CandidateProfile_PhoneNumber"] ?> - 
		      <?= $var["CandidateProfile_FaxNumber"] ?><BR>
		      <?= $var["CandidateProfile_Statement"] ?><BR>
	      </P>
				<A TARGET="PDFCandidate" HREF="<?= $FrontEndStatic ?>/shared/platforms/<?= $var["CandidateProfile_PDFFileName"] ?>">Download <?= $var["CandidateProfile_Alias"] ?>'s Platform</A>
			</DIV>
		</DIV>
	</P>

	<?php
				}
			}
		}
	?>
	</P>

<P>
	<DIV CLASS="right f60">	
		<A HREF="<?= PrintReferer() ?>">Return to previous menu</A></B>
	</DIV>
</P>

	
<P>
	<DIV CLASS="right f80">Notice to voters and candidates</DIV>
	
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
	
	
	<DIV CLASS="right f60">	
		<A HREF="<?= PrintReferer() ?>">Return to previous menu</A></B>
	</DIV>
		
</P>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>