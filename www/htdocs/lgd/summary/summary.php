<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }  
	$Menu = "summary";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
	include_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/DeadlineDates.php";  
	
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); exit(); }
  
	$rmb = new RepMyBlock();
	
	if ( $URIEncryptedString["SystemUser_ID"] != "TMP") {
		
		WriteStderr("I am in URI not TMP");
		
		$rmbperson = $rmb->FindPersonUser($URIEncryptedString["SystemUser_ID"]);
		// $NumberPetitions = $rmb->GetPetitionsSumary($URIEncryptedString["SystemUser_ID"]);	
		WriteStderr($rmbperson, "rmbperson");
		WriteStderr($NumberPetitions, "NumberPetition");
	
		/* Define numbers */
	
		preg_match('/([A-Z][A-Z])/', $rmbperson["Voters_UniqStateVoterID"], $matches, PREG_OFFSET_CAPTURE);
		$VoterState = $matches[1][0];
		$Party = PrintParty($rmbperson["SystemUser_Party"]);		
		$NumberOfElectors = $rmbperson["SystemUser_NumVoters"];
		$NumberOfSignatures = intval($NumberOfElectors * $SignaturesRequired) + 1;
		$Progress = round ((($NumberPetitions["CandidateSigned"] / $NumberOfElectors) * 100), 2);
		
		$PersonFirstName = $rmbperson["SystemUser_FirstName"];
		$PersonLastName  = $rmbperson["SystemUser_LastName"];
		$PersonEmail     = $rmbperson["SystemUser_Email"];

		$EmailVerifiedType = $rmbperson["SystemUser_emailverified"];
		$LinkNameToEmail = $rmbperson["SystemUser_emaillinkid"];

	} else {
		
		WriteStderr("I am in URI is TMP");
		
		$EmailVerifiedType = $URIEncryptedString["EmailVerified"];
		$LinkNameToEmail = $URIEncryptedString["EmailLink"];
		$EmailAddress = $URIEncryptedString["SystemTemporaryEmail"];
		
	}
	
	WriteStderr($EmailVerifiedType, "Email Verified Type");
	
	$NumberOfAddressesOnDistrict = 0;				

	/* Define the boxes here before we set the menu */
	if (empty ($rmbperson["SystemUser_EDAD"])) { 	
		$BoxSignatures = "Not defined"; 
		$BoxInDistrict = "Number of voters";
		$NumberOfElectors = "Not defined";
		$DayToGo = "Not defined";
		
	} else {
		$BoxInDistrict = $Party . "s in your district";
		if ($VerifVoter == 1) { $BoxInDistrict = "Verify your voter info."; }
		$BoxSignatures = $NumberOfSignatures . " (" . $Progress . " %)";
		$DayToGo = intval(($ImportantDates[$VoterState]["UNIX"]["LastPetitionDay"] - time()) / 86400);
		$DateToWait = $ImportantDates[$VoterState]["LongDate"]["FirstSubmitDay"]; /// This need to be calculated.
	}	
	
	

	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
	<div class="main">

		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>


			<div class="col-9 float-left">
			
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Summary</h2>
				</div>
				
				<?php if ($MenuDescription == "District Not Defined") { ?>
					<P CLASS="f80">
						<B>
							<A HREF="/<?= $k ?>/lgd/profile/profile">Please update your Personal Profile so 
							we can complete the summary information</A>.
						</B>
					</P>							
				<?php } ?>
				
				<?php 
					switch ($EmailVerifiedType) {
						case "no": 
						preg_match('/^([0-9a-f]{4})(.*)([0-9a-f]{4})$/', $LinkNameToEmail, $matches, PREG_OFFSET_CAPTURE);
						$LinkNameToEmail = $matches[3][0] . $matches[1][0] . $matches[2][0];
						
						?>
							<P>
								<B><FONT COLOR=BROWN>Follow the instructions in the email that was sent from</FONT> 
								infos@<?=  $MailFromDomain ?>.</B> You won't be able to use the system until that email address is verified.
							</P>
							
							<P>If you haven't received the verification email at <B><?= $EmailAddress ?></B>,
								<A HREF="mailto:infos@<?=  $MailFromDomain ?>?subject=Need to 
								receive link <?= $LinkNameToEmail ?>&body=Reference <?= $LinkNameToEmail ?>"><B>you can send an email to 
								infos@<?=  $MailFromDomain ?></B></A>
								with the subject: <B><I>Need to receive link <?= $LinkNameToEmail ?></I></B>. 
							</P>
							
							<P>
								Make sure to include the code <FONT COLOR=BROWN><B><?= $LinkNameToEmail ?></B></FONT>
								either in the subject or the body of the email.
							</P>		
							
							<P>
								If <B><?= $EmailAddress ?></B> is not your correct email address, you can 
								change it in the <A HREF="/<?= $k ?>/lgd/profile/profile">the profile menu</A>.
							</P>
						<?php break;
						
						case "link": ?>
							<P>
								<B><FONT COLOR=BROWN>Please forward the verification email to</FONT> notif@<?=  $MailFromDomain ?>.</B> 
								You won't be able to use the system until 
								that step is performed. If you deleted the verification email, click here for alternative instructions.
							</P>
						<?php break;
						
						case "reply": ?>
							<P>
								<B><FONT COLOR=BROWN>Please follow the instructions in the email from</FONT> infos@<?=  $MailFromDomain ?> 
								and click on the link attached.</FONT></B>
								If you deleted the verification email, click here for alternative instructions.
							</P>
				<?php break; 
					} ?>

		    <div class="d-flex flex-column flex-md-row mb-3">
		    	<div class="col-12 py-3 px-4 col-md-4 mb-md-0 mb-3 mr-md-3 bg-gray rounded-1">
		        <h4 class="f5 text-normal text-gray"><P CLASS="f40"><?= $BoxInDistrict ?></P></h4>
		        <span class="f2 text-bold d-block mt-1 mb-2 pb-1 f60"><?= $NumberOfElectors ?></span>
		    	</div>

		    	<div class="col-md-4 mr-md-3 col-12 py-3 px-4 mb-md-0 mb-3 bg-gray rounded-1">
		      	<h4 class="f5 text-normal text-gray"><P CLASS="f40">Required Signatures (Progress)</P></h4>
		  			<span class="f2 text-bold d-block mt-1 mb-2 pb-1 f60"><?= $BoxSignatures ?></span>
			    </div>

			    <div class="col-md-4 col-12 py-3 px-4 mb-md-0 mb-3 bg-gray rounded-1">
			      <h4 class="f5 text-normal text-gray"><P CLASS="f40">Days to Go</P></h4>
			  		<span class="f2 text-bold d-block mt-1 mb-2 pb-1 f60"><?= $DayToGo ?></span>						
			    </div>
			  </div>
			
				<P CLASS="f40">
					Once you collect the  <?= $NumberOfSignatures ?> signatutes plus a few more, 
					you will need to wait until <?= $DateToWait ?> to take them
					to the board of elections. <B>Just follow the 
					<A HREF="/<?= $k ?>/exp/howto">instruction posted on the FAQ</A>.</B>
				</P>
			  
			</DIV>
		</DIV>
	</DIV>
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>