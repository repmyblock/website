<?php
	$Menu = "profile";  
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();	
	$rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);
		
	// Put the POST HERE because we need to reread the data 
	if ( ! empty ($_POST)) {	
		$ProfileArray = array (	"bio" => $_POST["profile_bio"], 
														"URL"=> $_POST["URL"],
														"Location" => $_POST["Location"]);

		if ( $rmbperson["SystemUser_FirstName"] != $_POST["FirstName"] ) {
			$ProfileArray["Change"]["SystemUser_FirstName"] = $_POST["FirstName"];
			$FirstName = $_POST["FirstName"];
		} 
			
		if ( $rmbperson["SystemUser_LastName"] != $_POST["LastName"] ) {
			$ProfileArray["Change"]["SystemUser_LastName"] = $_POST["LastName"];
			$LastName = $_POST["LastName"];
		}
		if ( $rmbperson["SystemUser_email"] != $_POST["Email"] ) {
			$ProfileArray["Special"]["SystemUser_email"] = $_POST["Email"];
			$ProfileArray["Special"]["SystemUser_emaillinkid"] = hash("md5", PrintRandomText(40));
		}
		
		$rmbperson = $rmb->UpdatePersonUserProfile($URIEncryptedString["SystemUser_ID"], $ProfileArray, $rmbperson);
		
		if ( $rmbperson["ChangeEmail"] == 1) {			
			$infoarray["FirstName"] = $rmbperson["SystemUser_FirstName"];
			require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";			
			SendChangeEmail($rmbperson["SystemUser_email"], $rmbperson["SystemUser_emaillinkid"], 
											$rmbperson["SystemUser_username"], $infoarray); 
		}	
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
	$Party = NewYork_PrintParty($UserParty);
	
	$TopMenus = array ( 
							array("k" => $k, "url" => "profile", "text" => "Public Profile"),
							array("k" => $k, "url" => "profilevoter", "text" => "Voter Profile"),
							array("k" => $k, "url" => "profilecandidate", "text" => "Candidate Profile")
						);
						
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
  	
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
	    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Personal Profile</h2>
			  </div>
			     
			<?php
				PrintVerifMenu($VerifEmail, $VerifVoter);
			 	PlurialMenu($k, $TopMenus);
			?>
		
				<div class="col-12">
					<form class="edit_user" id="" aria-labelledby="public-profile-heading" action="" accept-charset="UTF-8" method="post">
						
						<div>
							
							<dl class="form-group col-5 d-inline-block"> 			
								<dt><label for="user_profile_name">First Name</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="First" value="<?= $PersonFirstName ?>" name="FirstName" id="user_profile_name">
								</dd>
							</dl>
							
							<dl class="form-group col-5 d-inline-block"> 
								<dt><label for="user_profile_name">Last Name</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Last"  value="<?= $PersonLastName ?>" name="LastName" id="user_profile_name">
								</dd>
							</dl>
							
							<dl class="form-group">
								<dt><label for="user_profile_blog">Email</label></dt>
								<dd><input class="form-control" type="text" value="<?= $PersonEmail ?>" name="Email" id="user_profile_blog"></dd>
<?php 					if ($rmbperson["ChangeEmail"] == 1) { ?>
									<dt><label for="user_profile_blog"><FONT COLOR=GREEN><B>Email was changed, please verify your email.</B></FONT></label></dt>
<?php 					} else if ( $rmbperson["ChangeEmail"] == -1) { ?>
									<dt><label for="user_profile_blog"><FONT COLOR=BROWN><B>The email <?= $rmbperson["EmailToChangeTo"] ?> already exist in the database.</B></FONT></label></dt>
<?php						} ?>
							</dl>
							
							<dl class="form-group">
								<dt><label for="user_profile_bio">Bio - Please write any notes to the organizers.</label></dt>
								<dd class="user-profile-bio-field-container js-length-limited-input-container">
									<textarea class="form-control user-profile-bio-field js-length-limited-input" placeholder="Tell us a little bit about yourself" data-input-max-length="160" data-warning-text="{{remaining}} remaining" name="profile_bio" id="user_profile_bio"><?= $PersonBio ?></textarea>
									<p class="js-length-limited-input-warning user-profile-bio-message d-none"></p>
								</dd>
							</dl>
							
							<dl class="form-group">
								<dt><label for="user_profile_blog">URL</label></dt>
								<dd><input class="form-control" type="text" value="<?= $PersonURL ?>" name="URL" id="user_profile_url"></dd>
							</dl>
							
							<hr>
								<dl class="form-group">
									<dt><label for="user_profile_location">Location</label></dt>
									<dd><input class="form-control" type="text" value="<?= $PersonLocation ?>" name="Location" id="user_profile_location"></dd>
							</dl>
														
							<p class="note mb-2">
								All of the fields on this page are optional and can be deleted at any
								time, and by filling them out, you're giving us consent to share this
								data wherever your user profile appears. Please see our
								<a href="https://github.com/site/privacy">privacy statement</a>
								to learn more about how we use this information.
							</p>
							
							<p><button type="submit" class="btn btn-primary">Update profile</button></p>
						</div>
					</form>    
				</div>
			</DIV>
		</DIV>
	</DIV>
</DIV>
		



<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>