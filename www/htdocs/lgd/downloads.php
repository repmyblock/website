<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "downloads";
	$BigMenu = "represent";	

	require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();

	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);
	$result = $rmb->ListCandidateInformation($SystemUser_ID);
				
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
		if ($VerifEmail == true) { 
			include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_emailverif.php";
		} else if ($VerifVoter == true) {
			include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_voterinfo.php";
		} 
	?>          
         


<?php
		$NewKEncrypt = EncryptURL($Decrypted_k . "&Candidate_ID=" . $result[0]["Candidate_ID"]);
		
		
?>	
		<P>
			<FONT SIZE=+2>
				Download a 
				<A TARGET="BLANKPETITION1" HREF="<?= $FrontEndPDF ?>/multipetitions/?k=<?= $NewKEncrypt ?>">blank petition</A>
				<A TARGET="BLANKPETITION1" HREF="<?= $FrontEndPDF ?>/multipetitions/?k=<?= $NewKEncrypt ?>"><i class="fa fa-download" aria-hidden="true"></i></A> and a
				<A TARGET="BLANKPETITION2" HREF="<?= $FrontEndPDF ?>/voterlist/?k=<?= $NewKEncrypt ?>">list of voters</A>
				<A TARGET="BLANKPETITION2" HREF="<?= $FrontEndPDF ?>/voterlist/?k=<?= $NewKEncrypt ?>"><i class="fa fa-download" aria-hidden="true"></i></A>
			</FONT>
			<BR>for <?= $result[0]["Candidate_ID"] ?>
				 
		</P>
					  
			 
			
			<P>
				Once you collect the  <?= $NumberOfSignatures ?> plus a few more, you need to wait until April 1<sup>st</sup> to take them
				to the board of elections. <B>Just follow the 
			<A HREF="<?= $FrontEndWeb ?>/howto">instruction posted on the FAQ</A>.</B>
			</P>

			<P>
				<B>Download : <A TARGET="BLANKPETITION3" HREF="<?= $FrontEndPDF ?>/NYS/NYC/CRU_PreFile/?petid=<?= $result[0]["CandidatePetitionSet_ID"] ?>">the Petition-Pre Assigned form</A></B> and 
				mail it to the Candidate Record Unit of the Board of Election.
			</P>

      

  </div>

  
		
</DIV>
			
		
	

	</div>
</DIV>






<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>