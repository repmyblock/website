<?php
  $Menu = "profile";  
	$BigMenu = "profile";
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  $rmb = new repmyblock();  
  
  $rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);
  WriteStderr($rmbperson, "rmbperson array");
  
  // Put the POST HERE because we need to reread the data 
  if ( ! empty ($_POST)) {  
  	
  	 WriteStderr($_POST, "POST");
  	 	
  	if ($URIEncryptedString["TypeOfRun"] == "NewCandidate") {
 			// Find the CandidateElections in table CandidateElectionID
 			$ElectionsList = $rmb->CandidateElection($URIEncryptedString["DBTable"], 'X', NULL, NULL, $URIEncryptedString["Elections_ID"]);
			
			if ( empty ($ElectionsList)) {
				$DataTable = array(
					"ElectionID" => $URIEncryptedString["Elections_ID"], 
					"ElectPosID" => $URIEncryptedString["ElectionsPosition_ID"],
					"PosType" => (($URIEncryptedString["Position"] == "office") ? 'electoral' :  $URIEncryptedString["Position"]),
					"Party" =>  $URIEncryptedString["Party"], 
					"PosText" => $URIEncryptedString["PositionName"], 
					"PetText" => $URIEncryptedString["PositionFullName"],
					"Order" => $URIEncryptedString["PositionOrder"], 
					"Display" => "no", 
					"Sex" => "both", 
					"DBTable" => $URIEncryptedString["DBTable"],
					"DBValue" => "X",
				);
			
				$CandidateElectionID = $rmb->InsertCandidateElection($DataTable);	
			} else {
				$CandidateElectionID = $ElectionsList[0]["CandidateElection_ID"];
			}

  		// Verify that the candidate doesn't exist.
  		  		
  		$CandidateInfo = $rmb->ListCandidateInformationByUNIQ($URIEncryptedString["VoterUniqID"], NULL, $CandidateElectionID);
 			
  		if ( empty ($CandidateInfo)) {
  			// Create the Candidate Stuff
  			$CandidateID = $rmb->InsertCandidate($rmbperson["SystemUser_ID"], $URIEncryptedString["VoterUniqID"], $rmbperson["Voters_ID"], 
  															NULL, $CandidateElectionID, $rmbperson["SystemUser_Party"], 
  															trim($_POST["FullName"]), NULL, $URIEncryptedString["DBTable"], NULL,	NULL, 'pending');
  		} else {
  			$CandidateID = $CandidateInfo[0]["Candidate_ID"];
  		}
  	} else {
  		
  		// This is to update the candidate only
  		
  		
  	}
  	
  	// I need to create a profile 
 
    $FileName = preg_replace("/[^A-Za-z0-9]/",'', $URIEncryptedString["FileNameName"]);
    $StateID = preg_replace("/^[A-Za-z][A-Za-z]0+(?!$)/", '', $URIEncryptedString["FileNameStateID"]);
    
    // This is to deal with the Picture itself and we must check it's type image/<something else>
    if (! empty ($_FILES["filepicture"]["type"])) {
      if (preg_match("#image/(.*)#", $_FILES["filepicture"]["type"], $matches, PREG_OFFSET_CAPTURE)) {
        $suffix = $matches[1][0];      
        $PictureFilename = "CAN" . 	$CandidateID . "_" . $FileName . "_" . $_POST["FirstName"] . "." . $suffix;
        preg_match('/(.{4})(.{4})(.{4})/', md5($PictureFilename), $matches, PREG_OFFSET_CAPTURE);
        $md5structure = $matches[1][0] . "/" . $matches[2][0] . "/" . $matches[3][0];
        $structure = $GeneralUploadDir . "/shared/pics/" . $md5structure . "/";
        mkdir($structure, 0777, true);
        $PicFilePath = $md5structure . "/" . $PictureFilename;
        
        
        print "PicFilePath: " . $PicFilePath . "<BR>";
        
        
        if (! move_uploaded_file($_FILES['filepicture']['tmp_name'], $structure . $PictureFilename)) {
          $error_msg = "Problem uploading the picture";
        } 
        $PictureFile = true;
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
        $PDFFile = true;
      }  else {
        $error_msg = "You can upload only PDF files.";
      }
    }
    
    // ADD to the database the following tables.              
    $CandidateProfile = array(
        "Fist"   =>  $_POST["FirstName"],
        "Last"   =>  $_POST["LastName"],
        "Full"   =>  $_POST["FullName"],
        "Email"   =>  $_POST["Email"],
        "URL"   =>  $_POST["URL"],
        "Phone"   =>  $_POST["PhoneNumber"],
        "Fax"   =>  $_POST["FaxNumber"],
        "Platform"   =>  $_POST["CandidateProfileBio"],
        "Twitter"   =>  $_POST["Twitter"],
        "Instagram"   =>  $_POST["Instagram"],
        "Facebook"   =>  $_POST["Facebook"],
        "YouTube"   =>  $_POST["YouTube"],
        "TikTok"   =>  $_POST["TikTok"],
        "Ballotpedia"   =>  $_POST["Ballotpedia"],
        "PicFile" => $PicFilePath,
        "PDFFile" => $PDFFilePath,
        "Private" => $_POST["PrivateRun"]
    );
    
    $rmb->updatecandidateprofile($CandidateID, $CandidateProfile);
    
    if ( $PictureFile == true || $PDFFile == true) {
    	echo "GOING TO THE UPLOAD SCREEN";
  		if ($PictureFile == true) {  	
  	  	header("Location:/" . MergeEncode(
  	  														array("PicPath" => $PicFilePath,
  	  																	"PDFPath" => $PDFFilePath,
  														)) . "/lgd/profile/fixpicture");
  		} 
  		
  		if ($PDFFile == true) {
  	  	header("Location:/" . MergeEncode(
  	  														array("PicPath" => $PicFilePath,
  	  																	"PDFPath" => $PDFFilePath,
  														)) . "/lgd/profile/fixpdf");
  		}   		
  	}
    
    exit();

  }
  
  
  if ( ! empty($URIEncryptedString["Candidate_ID"])) {
	  $rmbcandidate = $rmb->ListCandidatePetitions($URIEncryptedString["Candidate_ID"]);
  }
  
  WriteStderr($rmbcandidate, "RMBCandidate");
  $StatusMessage = "Create the profile";
  
  if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}  
  $Party = PrintParty($UserParty);
  
  if ( ! empty  ($rmbcandidate["Candidate_DispName"])) {
  	$ProfileAlias = $rmbcandidate["CandidateProfile_Alias"];
  	$ProfileDisplayName= $rmbcandidate["Candidate_DispName"]; 
   	$ProfileFirstName = $rmbcandidate["CandidateProfile_FirstName"];    
    $ProfileLastName = $rmbcandidate["CandidateProfile_LastName"];
  } else {
 	  $ProfileDisplayName = $rmbperson["SystemUser_FirstName"] . " " . $rmbperson["SystemUser_LastName"];
  	$ProfileAlias = $ProfileDisplayName;
   	$ProfileFirstName = $rmbperson["SystemUser_FirstName"];
    $ProfileLastName = $rmbperson["SystemUser_LastName"];
  }
		                 
  
  if ($rmbperson["SystemUser_emailverified"] == "both") {                
    $TopMenus = array (
            array("k" => $k, "url" => "profile/user", "text" => "Public Profile"),
            array("k" => $k, "url" => "profile/profilevoter", "text" => "Voter Profile"),
            array("k" => $k, "url" => "profile/profilecandidate", "text" => "Candidate Profile"),
            array("k" => $k, "url" => "profile/profileteam", "text" => "Team Profile")
    );
                
  }              

  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
  if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>
    <DIV class="row">
      <DIV class="main">
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
        <DIV class="<?= $Cols ?> float-left">
      
          <!-- Public Profile -->
          <DIV class="Subhead mt-0 mb-0">
            <h2 id="public-profile-heading" class="Subhead-heading">Candidate Profile</h2>
          </DIV>
          <?php  PlurialMenu($k, $TopMenus);  ?>
          <DIV class="clearfix gutter d-flex flex-sHRink-0">
            <DIV class="row">
              <DIV class="main">
                <FORM ACTION="" METHOD="POST" ENCTYPE="multipart/form-data">
                	              
                	              	       <P class="f60">
                    <B>This profile will be presented to every person that visits the Rep My Block website.</B> You 
                    will be able to upload a one-page PDF of your platform that will be used to create a voter 
                    booklet that a voter will download and email.
                  </P>
                	                	
                	 <P class="f60">
                  	<INPUT TYPE="CHECKBOX" NAME="PrivateRun" VALUE="yes">&nbsp;Publish the profile on the Rep My Block guide on the website.                  	
                  	<I>(<B>Note:</B> once the information is on a public website, the information will automatically get updated, and this option will disappear.)</I>
                  </P>

                  <p><button type="submit" class="submitred"><?= $StatusMessage ?></button></p>
      
					
      
                  <P class="f80">         
                    <B><?= $ProfileDisplayName ?></B>
                  </P>
         
                  <DIV>
            
                    <DL class="f40">       
                      <DT><LABEL>First Name</LABEL></DT>
                      <DD>
                        <INPUT class="form-control" type="text" placeholder="First Name" name="FirstName" value="<?= $ProfileFirstName  ?>">
                      </DD>
                    </DL>
                                     
                    <DL class="f40"> 
                      <DT><LABEL>Last Name</LABEL><DT>
                      <DD>
                        <INPUT class="form-control" type="text" placeholder="Last Name" name="LastName" value="<?= $ProfileLastName ?>">
                      </DD>
                    </DL>
                      
                    <DL class="f40">
                      <DT><LABEL>Public Facing Name</LABEL></DT>
                      <DD><INPUT class="form-control" type="text" placeholder="Your name to be displayed publicly" name="FullName" value="<?= $ProfileAlias ?>"></DD>
                    </DL>
                      
                    <DL class="f40">
                      <DT><LABEL>Upload your picture</LABEL><BR><I>(make sure it's 200 pixels in width by 300 pixels in height)</I></DT>
                      <DD><INPUT type="file" name="filepicture"></DD>
                    </DL>

                    <HR>  
           
                    <DL class="f40">
                      <DT><LABEL>Campaign Email</LABEL></DT>
                      <DD><INPUT class="form-control" type="text" placeholder="Your campaign email to be shared" name="Email" value="<?= $rmbcandidate["CandidateProfile_Email"]; ?>"></DD>
                    </DL>
                      
                    <DL class="f40">
                      <DT><LABEL>Campaign Website</LABEL></DT>
                      <DD><INPUT class="form-control" type="text" placeholder="Your campaign website" name="URL" value="<?= $rmbcandidate["CandidateProfile_Website"]; ?>"></DD>
                    </DL>
                      
                    <HR>  
                    
                    <DL class="f40">
                      <DT><LABEL>Phone Number</LABEL></DT>
                      <DD><INPUT class="form-control" type="text" placeholder="Your campaign office phone number" name="PhoneNumber" value="<?= $rmbcandidate["CandidateProfile_PhoneNumber"]; ?>"></DD>
                    </DL>
                      
                    <DL class="f40">
                      <DT><LABEL>Fax Number</LABEL></DT>
                      <DD><INPUT class="form-control" type="text" placeholder="Your campaign office fax number" name="FaxNumber" value="<?= $rmbcandidate["CandidateProfile_FaxNumber"]; ?>"></DD>
                    </DL>

                    <HR>  
                      
                    <DL class="f40">
                      <DT><LABEL>Campaign Statement.</LABEL></DT>
                      <DD class="">
                        <TEXTAREA class="form-control" placeholder="Tell us a little bit about yourself" name="CandidateProfileBio"><?= $rmbcandidate["CandidateProfile_Statement"] ?></TEXTAREA>
                      </DD>
                    </DL> 
                      
                    
                    <DL class="f40">
                      <DT><LABEL>Upload your PDF platform</LABEL></DT>
                      <DD><INPUT type="file" name="pdfplatform"></DD>
                    </DL>            
                                    
                    <HR> 
  
                      
                    <DL class="f40">
                      <DT><LABEL>Twitter</LABEL></DT>
                      <DD><INPUT class="form-control" type="text" placeholder="@" name="Twitter" value="<?= $rmbcandidate["CandidateProfile_Twitter"]; ?>"></DD>
                    </DL>

                    <DL class="f40">
                      <DT><LABEL>Instagram</LABEL></DT>
                      <DD><INPUT class="form-control" type="text" placeholder="@" name="Instagram" value="<?= $rmbcandidate["CandidateProfile_Instagram"]; ?>"></DD>
                    </DL>
                      
                    <DL class="f40">
                      <DT><LABEL>Facebook</LABEL></DT>
                      <DD><INPUT class="form-control" type="text" placeholder="https://facebook.org/" name="Facebook" value="<?= $rmbcandidate["CandidateProfile_Facebook"]; ?>"></DD>
                    </DL>
                      
                    <DL class="f40">
                      <DT><LABEL>YouTube</LABEL></DT>
                      <DD><INPUT class="form-control" type="text" placeholder="https://youtube.com" name="YouTube" value="<?= $rmbcandidate["CandidateProfile_YouTube"]; ?>"></DD>
                    </DL>

                    <DL class="f40">
                      <DT><LABEL>TikTok</LABEL></DT>
                      <DD><INPUT class="form-control" type="text" placeholder="https://tiktok.com" name="TikTok" value="<?= $rmbcandidate["CandidateProfile_TikTok"]; ?>"></DD>
                    </DL>

                    <DL class="f40">
                      <DT><LABEL>Ballotpedia</LABEL></DT>
                      <DD><INPUT class="form-control" type="text" placeholder="https://ballotpedia.org" name="Ballotpedia" value="<?= $rmbcandidate["CandidateProfile_BallotPedia"]; ?>"></DD>
                    </DL>
                    
                    <P class="f40">
                      All of the fields on this page are optional and can be deleted at any
                      time, and by filling them out, you're giving us consent to share this
                      data wherever your user profile appears. Please see our
                      <a HRef="https://github.com/site/privacy">privacy statement</a>
                      to learn more about how we use this information.
                    </P>
                    
                      
                    <p><button type="submit" class="submitred"><?= $StatusMessage ?></button></p>

                  </DIV>
                </FORM>
                
              </DIV>
            </DIV>
          </DIV>
        </DIV>
      </DIV>
    </DIV>
  </DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>