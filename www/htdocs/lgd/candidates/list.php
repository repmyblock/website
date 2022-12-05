<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "candidates";
	// $BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$result = $rmb->ListCandidatePetitions();	
	
	WriteStderr($result, "Result");
		
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
	<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>

		<div class="col-9 float-left">
			
			<div class="Subhead">
		  	<h2 class="Subhead-heading">Candidates</h2>
			</div>			
				<?php 
					WriteStderr($Decrypted_k, "Decrypted_k:");
					$NewKEncrypt = CreateEncoded (array("Candidate_ID" => $result[0]["Candidate_ID"]));
				?>	
				<P class="f60">
					This is the current list of candidates that are running for office in New York State.
				</P>

				<P class="f40">
					At this time, these candidates will need to get on the ballot. You can decide to help them
					by downloading a petition, signing it and returning it to their campaign headquarters.
				</P>
				
				<?php if ( ! empty ($result)) {
								foreach ($result as $var) {
									if ( ! empty ($var["CandidateProfile_PublishProfile"] != 'no' || $var["CandidateProfile_PublishPetition"] != 'no')) {
				?>	
				<P>
					<DIV class='container2'>
						<DIV style="float:left;">
							<IMG SRC="<?= $FrontEndStatic ?>/shared/pics/<?= $var["CandidateProfile_PicFileName"] ?>" class='iconDetails'>
						</DIV>	
						<DIV class='container3'>
					<P>
							<FONT SIZE=+1><B><?= $var["CandidateProfile_Alias"] ?></B></FONT><BR>
							<I>Running for <?= $var["CandidateElection_ID"] ?></I>
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
							<B>Download:</B> 
							<A TARGET="PDFCandidate" HREF="<?= $FrontEndStatic ?>/shared/platforms/<?= $var["CandidateProfile_PDFFileName"] ?>">Platform</A>
							<A TARGET="PDFPetition" HREF="<?= $FrontEndStatic ?>/petiton/<?= $var["CandidateProfile_PDFFileName"] ?>">Petition</A></B><BR>
						</DIV>
					</DIV>
				</P>

				<?php
									}
								}
							}
				?>	
				
			
				
			</div>	
		</DIV>
		
	</div>
</DIV>






<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
