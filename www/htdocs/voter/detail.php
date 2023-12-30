<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";
	
	$middleuri = $_GET["k"];
	preg_match('/(.*)_(\d+)/', $middleuri, $matches, PREG_OFFSET_CAPTURE);
	$CandidateProfileID = preg_replace('/[^0-9.]+/', '', $matches[2][0]);

	$r = new welcome(0);	
	$var = $r->CandidatesDetailed($CandidateProfileID);
	
	$HeaderTwitter = "yes";
	$HeaderTwitterTitle = "Rep My Block - Rep My Block";
	$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/paste/RepMyBlockVoterGuide.jpg";
	$HeaderTwitterDesc = "Rep My Block Voter Guide, the only voter guide that don't restrict the candidate.";
	$HeaderOGTitle = "Rep My Block Voter Guide.";
	$HeaderOGDescription = "Rep My Block Voter Guide, the only voter guide that don't restrict the candidate.";
	$HeaderOGImage = "https://static.repmyblock.org/pics/paste/RepMyBlockVoterGuide.jpg"; 
	$HeaderOGImageWidth = "941";
	$HeaderOGImageHeight = "477";
	
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
	
	WriteStderr($result, "Voter Guide");
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 



?>



<DIV class="main">		
	<DIV class="right f80bold">Voter Guide</DIV>
 	<DIV class="panels">		

	<P>
	
	
	<?php 
		if (! empty ($var)) {
			
			WriteStderr($var, "Voter Guide");
			
			print "<br style=\"clear:both\" />";
			
			$DateDesc = PrintShortDate($var["Elections_Date"]) . " - " . $var["Elections_Text"];
			
			$PrevDateDesc = $DateDesc;
			$PicturePath = (empty($var["CandidateProfile_PicFileName"]) ? "NoPicture.jpg" : $var["CandidateProfile_PicFileName"]);
		 
?>
						
<P>
	<DIV>
		
			<P>
						<DIV class="f80"><B><?= $var["CandidateProfile_Alias"] ?></B></DIV>
					
				</P>
		
		
	
				
		
	<DIV class='container2'>
		<DIV>
			<?php if (! empty ($var["CandidateProfile_Website"])) { ?><A TARGET="NEW" HREF="<?= $var["CandidateProfile_Website"] ?>"><?php } ?><IMG class="candidate" style="float: left; margin: 0px 15px 0px 15px;" SRC="/shared/pics/<?= $PicturePath ?>" class='iconDetails'><?php if (! empty ($var["CandidateProfile_Website"])) { ?></A><?php } ?>
						<DIV class="f60"><B><?= $DateDesc ?></B></DIV>
						<P class="f40" style="text-margin: 0px 0px 0px 0px;">
							<I>Running for <?= $var["CandidateElection_PetitionText"] ?></I>
							<?php if (! empty ($var["CandidateProfile_Statement"])) { print $var["CandidateProfile_Statement"]; }  ?>
						</P>
						</DIV>	
		<br style="clear:both">
		<DIV class='container3'>

						
						<P class="f60">
							<?php if (! empty ($var["CandidateProfile_Website"])) { ?><B>Website:</B> <A TARGET="NEW" HREF="<?= $var["CandidateProfile_Website"] ?>"><?= $var["CandidateProfile_Website"] ?></A><BR><?php } ?> 
				      <?php if (! empty ($var["CandidateProfile_BallotPedia"])) { ?><A TARGET="NEW" HREF="<?= $var["CandidateProfile_BallotPedia"] ?>">Ballotpedia</A><BR><?php } ?>
				      <?php if (! empty ($var["CandidateProfile_Email"])) { ?><B>Email:</B> <A TARGET="NEW" HREF="mailto:<?= $var["CandidateProfile_Email"] ?>"><?= $var["CandidateProfile_Email"] ?></A><?php } ?>
				      <?php if (! empty ($var["CandidateProfile_PhoneNumber"])) { print " <B>Telephone:</B> " . $var["CandidateProfile_PhoneNumber"] . "<BR>"; } ?>
				      <?php if (! empty ($var["CandidateProfile_Twitter"])) { ?>Twitter: <A TARGET="NEW" HREF="https://twitter.com/<?= $var["CandidateProfile_Twitter"] ?>">@<?= $var["CandidateProfile_Twitter"] ?></A><?php } ?> 
				     	<?php if (! empty ($var["CandidateProfile_Facebook"])) { ?>Facebook: <A TARGET="NEW" HREF="https://facebook.com/<?= $var["CandidateProfile_Facebook"] ?>"><?= $var["CandidateProfile_Facebook"] ?></A><?php } ?> 
				      <?php if (! empty ($var["CandidateProfile_Instagram"])) { ?>Instagram: <A TARGET="NEW" HREF="https://instagram.com/<?= $var["CandidateProfile_Instagram"] ?>">@<?= $var["CandidateProfile_Instagram"] ?></A><?php } ?> 
				      <?php if (! empty ($var["CandidateProfile_TikTok"])) { print $var["CandidateProfile_TikTok"] . " - "; } ?> 
				      <?php if (! empty ($var["CandidateProfile_YouTube"])) { print $var["CandidateProfile_YouTube"] . " - "; }  ?>
				      <?php if (! empty ($var["CandidateProfile_FaxNumber"])) { print $var["CandidateProfile_FaxNumber"]; }  ?>
			      </P>
					
			<?php if ( ! empty ($var["CandidateProfile_PDFFileName"])) { ?>						
				<P class="f40"><A TARGET="PDFCandidate" HREF="<?= $FrontEndStatic ?>/shared/platforms/<?= $var["CandidateProfile_PDFFileName"] ?>">Download <?= $var["CandidateProfile_Alias"] ?>'s Platform</A></P>
			<?php } ?>
		</DIV>
	</DIV>
</DIV>
</P>

<?php
			
	} else {
		header("Location:/error/404.php");
	}
	
	
 ?>
	</P>
</DIV>

<br style="clear:both">


<?php if ( empty ($var["SystemUser_ID"])) { ?>
						<P CLASS="f80"><A HREF="/<?= $var["CandidateProfile_ID"] ?>/voter/claim">Claim this profile</A></FONT>
					<?php } ?>

<P>
	<DIV class="right f60">	
		<A HREF="guide">Return to previous menu</A></B>
	</DIV>
</P>



</DIV>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>