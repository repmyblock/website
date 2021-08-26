<?php
	$Menu = "admin";  
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_sms.php";  
	
	WriteStderr($URIEncryptedString, "URIEncryptedString");		
 	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }

	$r = new sms();	
	
	if ( ! empty ($_POST)) {	
		WriteStderr($_POST, "POST");		
		$r->CreateNewCampaign($_POST["TextToSend"], $URIEncryptedString["SystemUser_ID"], 
													$_POST["candidate"], $_POST["accountholder"], $_POST["testplan"]);
		// CreateNewCampaign($Text, $SysID, $CandidateID, $SMSAccountHolder, $TestPlan)
		header("Location: report_texting");
		exit();																				
	}
	
	$CandidateList = $r->ListCandidate($URIEncryptedString["SystemUser_ID"]);
	$ListSMSAccount = $r->ListAccountHolders($URIEncryptedString["SystemUser_ID"]);
	#WriteStderr($CandidateList, "Candidate List");													
	// Put the POST HERE because we need to reread the data 
	
	if ( ! empty ($URIEncryptedString["SMSCampaign_ID"])) {
		$CampaignToCopy = $r->ListCampaigns($URIEncryptedString["SMSCampaign_ID"]);
		WriteStderr($CampaignToCopy, "CampaignToCopy");
	}
	
	
	if ( $VerifVoter == 1 && $rmbperson["Raw_Voter_ID"] > 0 ) { $VerifVoter = 0; }
	if ( $VerifEmail == 1 && $rmbperson["SystemUser_emailverified"] == 'yes') { $VerifEmail = 0; }
		
	$PersonFirstName = $rmbperson["SystemUser_FirstName"];
	$PersonLastName  = $rmbperson["SystemUser_LastName"];
	$PersonEmail     = $rmbperson["SystemUser_email"];
	$PersonBio       = $rmbperson["SystemUserProfile_bio"];
	$PersonURL       = $rmbperson["SystemUserProfile_URL"];
	$PersonLocation  = $rmbperson["SystemUserProfile_Location"];
	
	if ( $VerifVoter == 1) { $NewEncryptFile .= "&VerifVoter=1"; }
	if ( $VerifEmail == 1) { $NewEncryptFile .= "&VerifEmail=1"; }
	
	$EncodeString =
				array( 
					"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	"Raw_Voter_ID" => $resultPass["Raw_Voter_ID"],
					"FirstName" => $PersonFirstName, "LastName" => $PersonLastName,
					"VotersIndexes_ID" =>  $URIEncryptedString["VotersIndexes_ID"], "UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
					"UserParty" => $URIEncryptedString["UserParty"], "MenuDescription" => $URIEncryptedString["MenuDescription"],
					"SystemAdmin" => $URIEncryptedString["SystemAdmin"],
					"VerifVoter" => $URIEncryptedString["VerifVoter"], "VerifEmail" => $URIEncryptedString["VerifEmail"],
					"EDAD" => $URIEncryptedString["EDAD"]
				);
	$k = CreateEncoded ($EncodeString);
	if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}	
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
  	
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
	    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Create SMS Campaign</h2>
			  </div>
			  
				<div class="col-12">
					<form class="edit_user" id="" aria-labelledby="public-profile-heading" action="" accept-charset="UTF-8" method="post">
						
						<div>
							<P>
							<BR>			
								%UNIQID% => Unique ID
							</P>
																			
							<dl class="form-group">
								<dt class="mobilemenu"><label for="user_profile_name">Candidate</label><DT>
								<dd>
									<SELECT CLASS="mobilebig" NAME="candidate">
									<OPTION VALUE=""></OPTION>
									<?php if (! empty ($CandidateList)) foreach ($CandidateList as $var) { if (! empty ($var)) ?>
										<OPTION VALUE="<?= $var["Candidate_ID"] ?>"<?php if ($var["Candidate_ID"] == $CampaignToCopy["Candidate_ID"]) echo " SELECTED"; ?>><?= $var["Candidate_DispName"] . " - " . $var["Candidate_Party"] ?></OPTION>
									<?php } ?>
									</SELECT>
								</dd>	
							</dl>
							
							<dl class="form-group">
								<dt><label for="user_profile_bio">SMS Text</label></dt>
								<dd class="user-profile-bio-field-container js-length-limited-input-container">
									<textarea class="form-control user-profile-bio-field js-length-limited-input" placeholder="Text to send" name="TextToSend"><?= $CampaignToCopy["SMSCampaign_Text"] ?></textarea>
									<p class="js-length-limited-input-warning user-profile-bio-message d-none"></p>
								</dd>
							</dl>
							
							<dl class="form-group">
								<dt><label for="user_profile_blog">Test Plan</label></dt>
								<dd><input class="form-control" type="text" name="testplan" VALUE="<?= $CampaignToCopy["SMSTestPlan_ID"] ?>"></dd>
							</dl>
							
							<dl class="form-group">	
								<dt class="mobilemenu"><label for="user_profile_name">Account Holder</label><DT>
								<dd>
									<SELECT CLASS="mobilebig" NAME="accountholder">
									<OPTION VALUE=""></OPTION>						
									<?php if (! empty ($ListSMSAccount)) foreach ($ListSMSAccount as $var) { if (! empty ($var)) ?>
										<OPTION VALUE="<?= $var["SMSAccountHolder_ID"] ?>"<?php if ($var["SMSAccountHolder_ID"] == $CampaignToCopy["SMSAccountHolder_ID"]) echo " SELECTED"; ?>><?= $var["SMSAccountHolder_UserName"] ?></OPTION>
									<?php } ?>
									</SELECT>
								</dd>
							</dl>
							
							<p><button type="submit" class="btn btn-primary">Create SMS Campaign</button></p>
						</div>
					</form>    
				</div>
			</DIV>
		</DIV>
	</DIV>
</DIV>
		



<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>