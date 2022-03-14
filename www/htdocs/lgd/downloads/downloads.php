<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "downloads";
	// $BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();
	$Party = PrintParty($URIEncryptedString["UserParty"]);
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$result = $rmb->ListCandidateInformation($URIEncryptedString["SystemUser_ID"]);	
	
	include_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/DeadlineDates.php";  
	$NumberOfElectors = $rmbperson["SystemUser_NumVoters"];
	$NumberOfSignatures = intval($NumberOfElectors * $SigsRequired["NY"]) + 1;
	
	WriteStderr($result, "Result");
		
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
	<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>

		<div class="col-9 float-left">
			
			<div class="Subhead">
		  	<h2 class="Subhead-heading">Download</h2>
			</div>			
				<?php 
					WriteStderr($Decrypted_k, "Decrypted_k:");
					$NewKEncrypt = CreateEncoded (array("Candidate_ID" => $result[0]["Candidate_ID"]));
				?>	
				<P CLASS="f60">
						Download a 
						<A TARGET="BLANKPETITION1" HREF="<?= $FrontEndPDF ?>/E<?= $result[0]["Candidate_ID"] ?>/<?= $rmbperson["DataState_Abbrev"] ?>/petition">blank petition</A>
						<A TARGET="BLANKPETITION1" HREF="<?= $FrontEndPDF ?>/E<?= $result[0]["Candidate_ID"] ?>/<?= $rmbperson["DataState_Abbrev"] ?>/petition"><i class="fa fa-download" aria-hidden="true"></i></A> 
						
						
						
						and a
						
						<A TARGET="BLANKPETITION2" HREF="<?= $FrontEndPDF ?>/<?= $NewKEncrypt ?>/rmb/voterlist">list of voters</A>
						<A TARGET="BLANKPETITION2" HREF="<?= $FrontEndPDF ?>/<?= $NewKEncrypt ?>/rmb/voterlist"><i class="fa fa-download" aria-hidden="true"></i></A>
						
				
				</P>
				
				<P CLASS="f40">
					If the petition says <B>VOID</B> in red or pink, do not use it. Send us an email to
					<B><A HREF="mailto:petitionvoid@repmyblock.org">petitionvoid@repmyblock.org</A></B> 
					with a copy of the petition so we can investigate the matter.
				</P>

				<P CLASS="f40">
					Once you printed the petition, all you need to do is to collect <?= $NumberOfSignatures ?> from the 
					list of voters. In this video, Paperboy Prince explain how easy is to collect the signatures.
				</P>


				<DIV class="videowrapper">
					<CENTER>
				 		<iframe src="https://www.youtube.com/embed/XUGFbBCcIS4?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</CENTER>
				</DIV>

				<P CLASS="f40">
					Once you collected the  <?= $NumberOfSignatures ?> or more signatures, you need to wait until 
					April 1<sup>st</sup> to take them to the board of elections. <B>Just follow the 
					<A HREF="/<?= $k ?>/exp/toplinks/howto">instruction posted on the FAQ</A>.</B>
				</P>
				
				<P CLASS="f40">
					If you petitioned with another candidate, contact that other candidate directly to get the specific 
					instructions for turning in your petitons.
				</P>

				<P CLASS="f40">
					<B>Download : <A TARGET="BLANKPETITION3" HREF="<?= $FrontEndPDF ?>/NYS/petid<?= $result[0]["CandidatePetitionSet_ID"] ?>/CRU_PreFile">the Petition-Pre Assigned form</A></B> and 
					mail it to the Candidate Record Unit of the Board of Election.
				</P>
				
			</div>	
		</DIV>
		
	</div>
</DIV>






<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
