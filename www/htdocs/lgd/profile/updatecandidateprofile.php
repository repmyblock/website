<?php
	$Menu = "profile";  
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();	
	
	// Put the POST HERE because we need to reread the data 
	if ( ! empty ($_POST)) {	
			
		$FileName = preg_replace("/[^A-Za-z0-9]/",'', $URIEncryptedString["FileNameName"]);
		$StateID = preg_replace("/^[A-Za-z][A-Za-z]0+(?!$)/", '', $URIEncryptedString["FileNameStateID"]);
    
		// This is to deal with the Picture itself and we must check it's type image/<something else>
		if (! empty ($_FILES["filepicture"]["type"])) {
			if (preg_match("#image/(.*)#", $_FILES["filepicture"]["type"], $matches, PREG_OFFSET_CAPTURE)) {
				$suffix = $matches[1][0];			
				$PictureFilename = "CAN" . $URIEncryptedString["Candidate_ID"] . "_" . $FileName . "_" . $StateID . "." . $suffix;
				preg_match('/(.{4})(.{4})(.{4})/', md5($PictureFilename), $matches, PREG_OFFSET_CAPTURE);
				$md5structure = $matches[1][0] . "/" . $matches[2][0] . "/" . $matches[3][0];
				$structure = $GeneralUploadDir . "/shared/pics/" . $md5structure . "/";
				mkdir($structure, 0777, true);
				$PicFilePath = $md5structure . "/" . $PictureFilename;
				print "PicFilePath: " . $PicFilePath . "<BR>";
				if (! move_uploaded_file($_FILES['filepicture']['tmp_name'], $structure . $PictureFilename)) {
					$error_msg = "Problem uploading the picture";
				} 
			} else {
				$error_msg = "Picture file not in jpeg or png format";
			}
		} 
		// This is to deal with the pdf
		if (! empty ($_FILES["pdfplatform"]["type"])) {
			if (preg_match("#application/(.*)#", $_FILES["pdfplatform"]["type"], $matches, PREG_OFFSET_CAPTURE)) {
				$suffix = $matches[1][0];			
				$PDFFilename = "CAN" . $URIEncryptedString["Candidate_ID"] . "_" . $FileName . "_" . $StateID . "." . $suffix;
				preg_match('/(.{4})(.{4})(.{4})/', md5($PDFFilename), $matches, PREG_OFFSET_CAPTURE);
				$md5structure = $matches[1][0] . "/" . $matches[2][0] . "/" . $matches[3][0];
				$structure = $GeneralUploadDir . "/shared/platforms/" . $md5structure . "/";
				mkdir($structure, 0777, true);
				$PDFFilePath = $md5structure . "/" . $PDFFilename;
				print "PicFilePath: " . $PDFFilePath . "<BR>";
				if (! move_uploaded_file($_FILES['pdfplatform']['tmp_name'], $structure . $PDFFilename)) {
				    $error_msg = "Problem uploading the pdf file";
				}
			}	else {
				$error_msg = "You can upload only PDF files.";
			}
		}
		
		// Add to the database the following tables.							
		$CandidateProfile = array(
				"Fist"	 =>  $_POST["FirstName"],
				"Last"	 =>  $_POST["LastName"],
				"Full"	 =>  $_POST["FullName"],
				"Email"	 =>  $_POST["Email"],
				"URL"	 =>  $_POST["URL"],
				"Phone"	 =>  $_POST["PhoneNumber"],
				"Fax"	 =>  $_POST["FaxNumber"],
				"Platform"	 =>  $_POST["CandidateProfileBio"],
				"Twitter"	 =>  $_POST["Twitter"],
				"Instagram"	 =>  $_POST["Instagram"],
				"Facebook"	 =>  $_POST["Facebook"],
				"YouTube"	 =>  $_POST["YouTube"],
				"TikTok"	 =>  $_POST["TikTok"],
				"Ballotpedia"	 =>  $_POST["Ballotpedia"],
				"PicFile" => $PicFilePath,
				"PDFFile" => $PDFFilePath,
		);
		
		$rmb->updatecandidateprofile($URIEncryptedString["Candidate_ID"], $CandidateProfile);
		echo "Continuing";
		header("Location:/" . $k . "/lgd/profile/updatecandidateprofile");
		
		exit();
	}
	
	
	$rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);
	$rmbcandidate = $rmb->ListCandidatePetitions($URIEncryptedString["Candidate_ID"]);
	
	WriteStderr($rmbcandidate, "RMBCandidate");
	WriteStderr($rmbperson, "rmbperson array");
	
	if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}	
	$Party = PrintParty($UserParty);
	
	if ($rmbperson["SystemUser_emailverified"] == "both") {								
		$TopMenus = array (
						array("k" => $k, "url" => "profile/user", "text" => "Public Profile"),
						array("k" => $k, "url" => "profile/profilevoter", "text" => "Voter Profile"),
						array("k" => $k, "url" => "profile/profilecandidate", "text" => "Candidate Profile"),
						array("k" => $k, "url" => "profile/profileteam", "text" => "Team Profile")
		);
								
	}							
	

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	// if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
  	
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
	    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Candidate Profile</h2>
			  </div>
			     
			<?php
			 	PlurialMenu($k, $TopMenus);
			?>
			
			<P>
				This profile will be presented to every person that visits the Rep My Block website. You 
				will be able to publish a two-page PDF 
				of your platform that will be used to create a voter booklet that a voter 
				will download and email.
			</P>
			
			<P>
				<B><?= $rmbcandidate["Candidate_DispName"]; ?></B>
			</P>
		
				<div class="col-12">
					<form class="edit_user" id="" enctype="multipart/form-data" aria-labelledby="public-profile-heading" action="" accept-charset="UTF-8" method="post">
						
						<?php /* 	[Candidate_ID] => 3 */ ?>
						<div>
												
							<?php /* [Candidate_StatementPicFileName] */ ?>
							
							<dl class="form-group col-5 d-inline-block"> 			
								<dt><label for="user_profile_name">First Name</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="First" value="<?= $rmbcandidate["CandidateProfile_FirstName"]; ?>" name="FirstName" id="user_profile_name">
								</dd>
							</dl>
							
							<dl class="form-group col-5 d-inline-block"> 
								<dt><label for="user_profile_name">Last Name</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Last"  value="<?= $rmbcandidate["CandidateProfile_LastName"]; ?>" name="LastName" id="user_profile_name">
								</dd>
							</dl>
							
							<dl class="form-group">
								<dt><label for="user_profile_blog">Public Facing Name</label></dt>
								<dd><input class="form-control" type="text" value="<?= $rmbcandidate["CandidateProfile_Alias"]; ?>" name="FullName"></dd>
							</dl>
							
							<dl class="form-group">
									<dt><label for="user_profile_location">Upload a picture</label></dt>
									<dd><input type="file" name="filepicture"></dd>
							</dl>

							<hr>   
   
							<dl class="form-group">
								<dt><label for="user_profile_blog">Campaign Email</label></dt>
								<dd><input class="form-control" type="text" value="<?= $rmbcandidate["CandidateProfile_Email"]; ?>" name="Email"></dd>
							</dl>
							
							<dl class="form-group">
								<dt><label for="user_profile_blog">Campaign Website</label></dt>
								<dd><input class="form-control" type="text" value="<?= $rmbcandidate["CandidateProfile_Website"]; ?>" name="URL"></dd>
							</dl>
							
							<hr>
								<dl class="form-group">
									<dt><label for="user_profile_location">Phone Number</label></dt>
									<dd><input class="form-control" type="text" value="<?= $rmbcandidate["CandidateProfile_PhoneNumber"]; ?>" name="PhoneNumber" ></dd>
							</dl>
							
								<dl class="form-group">
									<dt><label for="user_profile_location">Fax Number</label></dt>
									<dd><input class="form-control" type="text" value="<?= $rmbcandidate["CandidateProfile_FaxNumber"]; ?>" name="FaxNumber" ></dd>
							</dl>

							<hr>
							
							<dl class="form-group">
								<dt><label for="user_profile_bio">Campaign Statement.</label></dt>
								<dd class="user-profile-bio-field-container js-length-limited-input-container">
									<textarea class="form-control user-profile-bio-field js-length-limited-input" placeholder="Tell us a little bit about yourself" data-input-max-length="160" data-warning-text="{{remaining}} remaining" name="CandidateProfileBio"><?= $rmbcandidate["CandidateProfile_Statement"] ?></textarea>
									<p class="js-length-limited-input-warning user-profile-bio-message d-none"></p>
								</dd>
							</dl>
							
						
							<dl class="form-group">
									<dt><label for="user_profile_location">Upload your PDF platform</label></dt>
									<dd><input type="file" name="pdfplatform"></dd>
							</dl>						
														
							<hr>
								<dl class="form-group">
									<dt><label for="user_profile_location">Twitter</label></dt>
									<dd><input class="form-control" type="text" value="<?= $rmbcandidate["CandidateProfile_Twitter"]; ?>" name="Twitter"></dd>
							</dl>

							<dl class="form-group">
								<dt><label for="user_profile_blog">Instagram</label></dt>
								<dd><input class="form-control" type="text" value="<?= $rmbcandidate["CandidateProfile_Instagram"]; ?>" name="Instagram"></dd>
							</dl>
							
							<dl class="form-group">
								<dt><label for="user_profile_blog">Facebook</label></dt>
								<dd><input class="form-control" type="text" value="<?= $rmbcandidate["CandidateProfile_Facebook"]; ?>" name="Facebook"></dd>
							</dl>
							
							<dl class="form-group">
								<dt><label for="user_profile_blog">YouTube</label></dt>
								<dd><input class="form-control" type="text" value="<?= $rmbcandidate["CandidateProfile_YouTube"]; ?>" name="YouTube"></dd>
							</dl>

							<dl class="form-group">
								<dt><label for="user_profile_blog">TikTok</label></dt>
								<dd><input class="form-control" type="text" value="<?= $rmbcandidate["CandidateProfile_TikTok"]; ?>" name="TikTok"></dd>
							</dl>

							<dl class="form-group">
								<dt><label for="user_profile_blog">Ballotpedia</label></dt>
								<dd><input class="form-control" type="text" value="<?= $rmbcandidate["CandidateProfile_BallotPedia"]; ?>" name="Ballotpedia"></dd>
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