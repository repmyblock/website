<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "downloads";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();
	$Party = PrintParty($URIEncryptedString["UserParty"]);
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$result = $rmb->ListCandidateInformation($URIEncryptedString["SystemUser_ID"]);	
	
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
				<P>
					<FONT SIZE=+2>
						Download a 
						<A TARGET="BLANKPETITION1" HREF="<?= $FrontEndPDF ?>/<?= $rmbperson["DataState_Abbrev"] ?>/E<?= $result[0]["Candidate_ID"] ?>/petition">blank petition</A>
						<A TARGET="BLANKPETITION1" HREF="<?= $FrontEndPDF ?>/<?= $rmbperson["DataState_Abbrev"] ?>/E<?= $result[0]["Candidate_ID"] ?>/petition"><i class="fa fa-download" aria-hidden="true"></i></A> 
						
						<?php /*
						
						and a
						
						<A TARGET="BLANKPETITION2" HREF="<?= $FrontEndPDF ?>/<?= $rmbperson["DataState_Abbrev"] ?>/<?= $NewKEncrypt ?>/voterlist">list of voters</A>
						<A TARGET="BLANKPETITION2" HREF="<?= $FrontEndPDF ?>/<?= $rmbperson["DataState_Abbrev"] ?>/<?= $NewKEncrypt ?>/voterlist"><i class="fa fa-download" aria-hidden="true"></i></A>
						*/ ?>
					</FONT>
				</P>

				<P>
					Once you collect the  <?= $NumberOfSignatures ?> plus a few more, you need to wait until April 1<sup>st</sup> to take them
					to the board of elections. <B>Just follow the 
					<A HREF="/exp/<?= $k ?>/howto">instruction posted on the FAQ</A>.</B>
				</P>

				<P>
					<B>Download : <A TARGET="BLANKPETITION3" HREF="<?= $FrontEndPDF ?>/NYS/petid<?= $result[0]["CandidatePetitionSet_ID"] ?>/CRU_PreFile">the Petition-Pre Assigned form</A></B> and 
					mail it to the Candidate Record Unit of the Board of Election.
				</P>
				
			</div>	
		</DIV>
		
	</div>
</DIV>






<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
