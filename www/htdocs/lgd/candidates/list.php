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
				<P CLASS="f60">
					This is the current list of candidates that are running for office in New York State.
				</P>

				<P CLASS="f40">
					At this time, these candidates will need to get on the ballot. You can decide to help them
					by downloading a petition, signing it and returning it to their campaign headquarters.
				</P>
				
				<?php if ( ! empty ($result)) {
								foreach ($result as $var) {
									if ( ! empty ($var)) {
				?>	
				<P>
					
					Picutre; <?= $var["Candidate_StatementPicFileName"] ?><BR>					
					<B><FONT SIZE=+1><?= $var["Candidate_DispName"] ?></FONT></B>
					<I>(<?= PrintParty($var["Candidate_Party"]); ?>)</I>
				</P>			
				
				<P>
					<B>Website:</B> <A TARGET="CandidateWebsite" HREF="https://<?= $var["Candidate_StatementWebsite"] ?>"><?= $var["Candidate_StatementWebsite"] ?></A><BR>	
					<B>Email:</B> <A TARGET="CandidateWebsite" HREF="mailto://<?= $var["Candidate_StatementEmail"] ?>"><?= $var["Candidate_StatementEmail"] ?></A><BR>
					<B>Twitter:</B> <A TARGET="CandidateWebsite" HREF="https://twitter.com/<?= $var["Candidate_StatementTwitter"] ?>">@<?= $var["Candidate_StatementTwitter"] ?></A><BR>
					<B>Campaign Phone Number:</B> <?= $var["Candidate_StatementPhoneNumber"] ?><BR>
					<B>Candidate Statement</B><BR>
					<UL><?= $var["Candidate_StatementText"] ?></UL>
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
