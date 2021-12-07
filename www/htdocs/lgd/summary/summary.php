<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }  
	$Menu = "summary";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
	include_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/DeadlineDates.php";  
	
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); exit(); }
  
	$rmb = new RepMyBlock();
	$rmbperson = $rmb->FindPersonUser($URIEncryptedString["SystemUser_ID"]);
	$NumberPetitions = $rmb->GetPetitionsSumary($URIEncryptedString["SystemUser_ID"]);
	
	WriteStderr($rmbperson, "rmbperson");
	WriteStderr($NumberPetitions, "NumberPetition");
	
	/* Define numbers */
	
	preg_match('/([A-Z][A-Z])/', $rmbperson["Voters_UniqStateVoterID"], $matches, PREG_OFFSET_CAPTURE);
	$VoterState = $matches[1][0];
	$Party = PrintParty($rmbperson["SystemUser_Party"]);		
	$NumberOfElectors = $rmbperson["SystemUser_NumVoters"];
	$NumberOfSignatures = intval($NumberOfElectors * $SignaturesRequired) + 1;
	$Progress = round ((($NumberPetitions["CandidateSigned"] / $NumberOfElectors) * 100), 2);
	
	$NumberOfAddressesOnDistrict = 0;				

	/* Define the boxes here before we set the menu */
	if (empty ($URIEncryptedString["EDAD"])) { 	
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
	
	

	
	
	
	$PersonFirstName = $rmbperson["SystemUser_FirstName"];
	$PersonLastName  = $rmbperson["SystemUser_LastName"];
	$PersonEmail     = $rmbperson["SystemUser_Email"];


	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
	<div class="main">

		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>


			<div class="col-9 float-left">
			
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Summary</h2>
				</div>
						
				<?php 
					switch ($rmbperson["SystemUser_emailverified"]) {
						case "no": ?>
							<P>
								<B><FONT COLOR=BROWN>Please follow the instructions in the email from</FONT> infos@<?=  $MailFromDomain ?>.</B> 
								You won't be able to use the system until the email is verified.
							</P>
							
							<P>If you haven't received the email,
								you can send an email to infos@<?=  $MailFromDomain ?> with the subject: "Need to receive link, dbd22886cdb83"
								that step is performed.
							</P>		
						<?php break;
						
						case "link": ?>
							<P>
								<B><FONT COLOR=BROWN>Please forward the verification email to</FONT> verif@<?=  $MailFromDomain ?>.</B> 
								You won't be able to use the system until 
								that step is performed. If you deleted the verification email, click here for alternative instructions.
							</P>
						<?php break;
						
						case "reply": ?>
							<P>
								<B><FONT COLOR=BROWN>Please follow the instructions in the email from</FONT> infos@<?=  $MailFromDomain ?> and click
								on the link attached.</FONT></B>
								If you deleted the verification email, click here for alternative instructions.
							</P>
				<?php break; 
					} ?>


				
				<?php if ($MenuDescription == "District Not Defined") { ?>
							
				
					<P>
						<A HREF="/<?= $k ?>/lgd/profile/profile">Please update your Personal Profile so we can complete the summary information.</A>
					</P>		
					
				<?php } ?>
				   
	        
		    <div class="d-flex flex-column flex-md-row mb-3">
		    	<div class="col-12 py-3 px-4 col-md-4 mb-md-0 mb-3 mr-md-3 bg-gray rounded-1">
		        <h4 class="f5 text-normal text-gray"><?= $BoxInDistrict ?></h4>
		        <span class="f2 text-bold d-block mt-1 mb-2 pb-1"><?= $NumberOfElectors ?></span>
		    	</div>

		    	<div class="col-md-4 mr-md-3 col-12 py-3 px-4 mb-md-0 mb-3 bg-gray rounded-1">
		      	<h4 class="f5 text-normal text-gray">Required Signatures (Progress)</h4>
		  			<span class="f2 text-bold d-block mt-1 mb-2 pb-1"><?= $BoxSignatures ?></span>
			    </div>

			    <div class="col-md-4 col-12 py-3 px-4 mb-md-0 mb-3 bg-gray rounded-1">
			      <h4 class="f5 text-normal text-gray">Days to Go</h4>
			  		<span class="f2 text-bold d-block mt-1 mb-2 pb-1"><?= $DayToGo ?></span>						
			    </div>
			  </div>
			
				<P>
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