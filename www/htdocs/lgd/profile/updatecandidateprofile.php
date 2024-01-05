<?php
	$MaxPDFSize = 1250000;
	$MaxPicSize = 1250000;

  $Menu = "profile";  
	$BigMenu = "profile";
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  $rmb = new repmyblock();  
  
  $rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);
  WriteStderr($rmbperson, "rmbperson array");
  
  $CandidateProfileID = $URIEncryptedString["CandidateProfileID"];
  $CandidateID = $URIEncryptedString["Candidate_ID"];
  
  if ( ! empty($CandidateProfileID > 0)) {
	  $rmbcandidate = $rmb->ListCandidateProfile($CandidateID, $CandidateProfileID);
  }
  WriteStderr($rmbcandidate, "rmbcandidate array");

  
  // Put the POST HERE because we need to reread the data 
  if ( ! empty ($_POST)) {  
  	WriteStderr($_POST, "POST");
  	 	
  	if (empty ($CandidateProfileID)) {
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
  		$candidateID = $rmbcandidate["Candidate_ID"];
  	}
  	 	
		$PicFilePath = $rmbcandidate["CandidateProfile_PicFileName"];  
		$PDFFilePath = $rmbcandidate["CandidateProfile_PDFFileName"];  
	 
    // This is to deal with the Picture itself and we must check it's type image/<something else>
    if (! empty ($_FILES["filepicture"]["type"])) {
			$PicStructure = $GeneralUploadDir . "/shared/pics/";
		
    	if ( $_FILES["filepicture"]["type"] < $MaxPicSize) {
	      preg_match("#image/(.*)#", $_FILES["filepicture"]["type"], $matches, PREG_OFFSET_CAPTURE);
	      	
      	if (empty($PicFilePath)) {
	        $suffix = $matches[1][0];      
	        $PictureFilename = "C" . 	$CandidateID . "_" . $_POST["FirstName"] . "_" . $_POST["LastName"];
	        $PictureFilename = preg_replace("/[^A-Za-z0-9_-]/",'', $PictureFilename) . "." . $suffix;
	  	        	        
  	      preg_match('/(.{4})(.{4})(.{4})/', md5($PictureFilename), $matches, PREG_OFFSET_CAPTURE);
    	    $PicMD5Struct = $matches[1][0] . "/" . $matches[2][0] . "/" . $matches[3][0];
      	  
	      	@mkdir($PicStructure . $PicMD5Struct, 0777, true);
	      	$PicFilePath = $PicMD5Struct . "/" . $PictureFilename;
	      }
	      
	      // This is to handle the temp namespace 
	      preg_match("|([a-f0-9]{4})/([a-f0-9]{4})/([a-f0-9]{4})/(.*)|", $PicFilePath, $PicPathMatches, PREG_OFFSET_CAPTURE);	      
	      $PicFilePath = $PicPathMatches[1][0] . "/" . $PicPathMatches[2][0] . "/" . $PicPathMatches[3][0];
		    $PicFileName = $PicPathMatches[4][0];
	      $TmpPicFilePath = $PicFilePath . "/TMP_" .$PicFileName;
	      
	      if (empty ($TmpPicFilePath)) {
	      	echo "Catastrophic error for some reason<BR>";
	      	exit();
	      }
	      
        if (! move_uploaded_file($_FILES['filepicture']['tmp_name'], $PicStructure . $TmpPicFilePath)) {
          echo "Catastrophic error moving the picture the picture";
          exit();
        } 
        $PictureFile = true;
        
                
      } else {
      	$error_msg = "Current file size " . $_FILES["filepicture"]["type"] . " File size need to be smaller than 1 Mb";
      }
    } else {
      $error_msg = "Picture file not in jpeg or png format";
    }
     
    // This is to deal with the pdf
    
    if (! empty ($_FILES["pdfplatform"]["type"])) {
    	$PDFStructure = $GeneralUploadDir . "/shared/platforms/";
    	
    	if ( $_FILES["filepicture"]["type"] < $MaxPDFSize) {
	      if (preg_match("#application/(.*)#", $_FILES["pdfplatform"]["type"], $matches, PREG_OFFSET_CAPTURE)) {

					if (empty($PDFFilePath)) {
		        $suffix = $matches[1][0];      
		        $PDFFilename = "C" . 	$CandidateID . "_" . $_POST["FirstName"] . "_" . $_POST["LastName"];
		        $PDFFilename = preg_replace("/[^A-Za-z0-9_-]/",'', $PDFFilename) . "." . $suffix;
		  	        	        
			      preg_match('/(.{4})(.{4})(.{4})/', md5($PDFFilename), $matches, PREG_OFFSET_CAPTURE);
		  	    $PdfMD5Struct = $matches[1][0] . "/" . $matches[2][0] . "/" . $matches[3][0];
		  	    
		      	@mkdir($PDFStructure . $PdfMD5Struct, 0777, true);
		      	$PDFFilename = $PdfMD5Struct . "/" . $PDFFilename;	
		      }
		      
		      // This is to handle the temp namespace 
		      preg_match("|([a-f0-9]{4})/([a-f0-9]{4})/([a-f0-9]{4})/(.*)|", $PDFFilePath, $PDFPathMatches, PREG_OFFSET_CAPTURE);
		    	$PDFFilePath = $PDFPathMatches[1][0] . "/" . $PDFPathMatches[2][0] . "/" . $PDFPathMatches[3][0];
		    	$PDFFileName = $PDFPathMatches[4][0];
		      $TmpPDFFilename = $PDFFilePath . "/TMP_" .$PDFFileName;
		      		     		
	 				if (! move_uploaded_file($_FILES['pdfplatform']['tmp_name'], $PDFStructure . $TmpPDFFilename)) {
	          echo "Catastrophic error moving the PDF File the picture: " . $PDFStructure . $TmpPDFFilename;
	          exit();
	        } 
	        $PDFFile = true;
	            
	      } else {
		     	$error_msg = "Current file size " . $_FILES["pdfplatform"]["type"] . " File size need to be smaller than 1 Mb";
	   	 }
	    }  else {
        $error_msg = "You can upload only PDF files.";
      }
    }
       
    // ADD to the database the following tables.    
    $CandidateProfile = array(
        "First"   =>  trim($_POST["FirstName"]),
        "Last"   =>  trim($_POST["LastName"]),
        "Full"   =>  trim($_POST["FullName"]),
        "Email"   =>  trim($_POST["Email"]),
        "URL"   =>  trim($_POST["URL"]),
        "Phone"   =>  trim($_POST["PhoneNumber"]),
        "Fax"   =>  trim($_POST["FaxNumber"]),
        "Platform"   =>  trim($_POST["CandidateProfileBio"]),
        "Twitter"   =>  trim($_POST["Twitter"]),
        "Instagram"   => trim( $_POST["Instagram"]),
        "Facebook"   =>  trim($_POST["Facebook"]),
        "YouTube"   =>  trim($_POST["YouTube"]),
        "TikTok"   =>  trim($_POST["TikTok"]),
        "Ballotpedia"   =>  trim($_POST["Ballotpedia"]),
        "Private" => (((!empty ($_POST["PrivateRun"])) && $_POST["PrivateRun"] == "yes") ? 'yes' : 'no'),
        "CandidateID" => $CandidateID,
    );
   
    // Check if something has changed before making another call to the database.
    $Result = 0;
    $Result += ($rmbcandidate["CandidateProfile_FirstName"] ==  $CandidateProfile["First"]) ? 0 : 1;
		$Result += ($rmbcandidate["CandidateProfile_LastName"] ==  $CandidateProfile["Last"]) ? 0 : 1;
		$Result += ($rmbcandidate["CandidateProfile_Alias"] ==  $CandidateProfile["Full"]) ? 0 : 1;
		$Result += ($rmbcandidate["CandidateProfile_Website"] ==  $CandidateProfile["URL"]) ? 0 : 1;
		$Result += ($rmbcandidate["CandidateProfile_Email"] ==  $CandidateProfile["Email"]) ? 0 : 1;
		$Result += ($rmbcandidate["CandidateProfile_Twitter"] ==  $CandidateProfile["Twitter"]) ? 0 : 1;
		$Result += ($rmbcandidate["CandidateProfile_Facebook"] ==  $CandidateProfile["Facebook"]) ? 0 : 1;
		$Result += ($rmbcandidate["CandidateProfile_Instagram"] ==  $CandidateProfile["Instagram"]) ? 0 : 1;
		$Result += ($rmbcandidate["CandidateProfile_TikTok"] ==  $CandidateProfile["TikTok"]) ? 0 : 1;
		$Result += ($rmbcandidate["CandidateProfile_YouTube"] ==  $CandidateProfile["YouTube"]) ? 0 : 1;
		$Result += ($rmbcandidate["CandidateProfile_BallotPedia"] ==  $CandidateProfile["Ballotpedia"]) ? 0 : 1;
		$Result += ($rmbcandidate["CandidateProfile_PhoneNumber"] ==  $CandidateProfile["Phone"]) ? 0 : 1;
		$Result += ($rmbcandidate["CandidateProfile_FaxNumber"] ==  $CandidateProfile["Fax"]) ? 0 : 1;
		$Result += ($rmbcandidate["CandidateProfile_Statement"] ==  $CandidateProfile["Platform"]) ? 0 : 1;
		
		// Need to deal with the two pictures.
		WriteStderr("Before");
		WriteStderr("PicFileName: " . $rmbcandidate["CandidateProfile_PicFileName"]);
		WriteStderr("Candidate Profile PicFile: " . $CandidateProfile["PicFile"]);
		WriteStderr("PDFFileName: " . $rmbcandidate["CandidateProfile_PDFFileName"]);
		WriteStderr("Canddate Profile PDFDile: " . $CandidateProfile["PDFFile"]);
		
		$CandidateProfile["PicFile"] = ($PictureFile != true && empty($rmbcandidate["CandidateProfile_PicFileName"])) ? NULL : 
																		((empty($rmbcandidate["CandidateProfile_PicFileName"])) ? $PicFilePath . "/" . $PicFileName : 
																		$rmbcandidate["CandidateProfile_PicFileName"]);
		$Result += ($rmbcandidate["CandidateProfile_PicFileName"] == $CandidateProfile["PicFile"]) ? 0 : 1;
		$CandidateProfile["PDFFile"] = ($PDFFile != true && empty($rmbcandidate["CandidateProfile_PDFFileName"])) ? NULL : 
																		((empty($rmbcandidate["CandidateProfile_PDFFileName"])) ? $PDFFilePath . "/" . $PDFFileName : 
																		$rmbcandidate["CandidateProfile_PDFFileName"]);
		$Result += ($rmbcandidate["CandidateProfile_PDFFileName"] == $CandidateProfile["PDFFile"]) ? 0 : 1;
		
		WriteStderr("After");
		WriteStderr("PicFileName: " . $rmbcandidate["CandidateProfile_PicFileName"]);
		WriteStderr("Candidate Profile PicFile: " . $CandidateProfile["PicFile"]);
		WriteStderr("PDFFileName: " . $rmbcandidate["CandidateProfile_PDFFileName"]);
		WriteStderr("Canddate Profile PDFDile: " . $CandidateProfile["PDFFile"]);

		if ( $Result > 0 ) {
  	  $CandidateProfileID = $rmb->updatecandidateprofile($CandidateProfileID, $CandidateProfile);
    }
						      	  										
    if ( $PictureFile == true || $PDFFile == true) {
 
  		if ($PictureFile == true) {  	
  	  	header("Location:/" . MergeEncode(
  	  														array(
  	  																	"PicPath" => $PicFilePath,
  	  																	"PicName" => $PicFileName,
  	  																	"PDFPath" => $PDFFilePath,
  	  																	"PDFName" => $PDFFileName,												
  	  																	"CandidateID" => $CandidateID,
  	  																	"CandidateProfileID" => $CandidateProfileID,
  	  																	"PublishWarning" => $_POST["PrivateRun"],
  														)) . "/lgd/profile/fixpicture");
  			exit();
  		} 
  		
  		if ($PDFFile == true) {
  	  	header("Location:/" . MergeEncode(
  	  														array(
  	  																	"PDFPath" => $PDFFilePath,
  	  																	"PDFName" => $PDFFileName,
  	  																	"CandidateID" => $CandidateID,
  	  																	"CandidateProfileID" => $CandidateProfileID,
  	  																	"PublishWarning" => $_POST["PrivateRun"],
  														)) . "/lgd/profile/fixpdf");
  			exit();
  		}   		
  	}
  	
  	if ( $_POST["PrivateRun"] == 'yes') {
  		header("Location: profilewarning");
  		exit();
  	}

    header("Location: updatecandidateprofile");
    exit();
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
                	                	
               	 	<?php if ($rmbcandidate["CandidateProfile_PublishProfile"] != 'yes') { ?>
                	 <P class="f60">
                  	<INPUT TYPE="CHECKBOX" NAME="PrivateRun" VALUE="yes"<?php if ($rmbcandidate["CandidateProfile_PublishProfile"] == 'yes') { echo " CHECKED"; } ?>>&nbsp;Publish the profile on the Rep My Block guide on the website.                  	
	                  <BR><FONT COLOR="RED"><B>ATTENTION:</FONT></B> Once you publish the information, this option disappear. Do not select this
  		              option if you do not want your profile to be public.</FONT>
                  	<I>(<B>Note:</B> once the information is on a public website, the information will 
                  		automatically get updated, and this option will disappear.)</I>
                  </P>

                  <p><button type="submit" class="submitred"><?= $StatusMessage ?></button></p>
	      					<?php } ?>
					
      
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
                    
                    <p><button type="submit" class="submitred"><?= $StatusMessage ?></button></p>
                      
                    <HR>  
                      
                    <DL class="f40">
                      <DT><LABEL>Upload your picture</LABEL><BR><I>(make sure it's 200 pixels in width by 300 pixels in height)</I></DT>
                      
                    
                  	<?php 
                  			$PicVar = (empty($rmbcandidate["CandidateProfile_PicFileName"])) ? 
                  										"0000/NoPicture.jpg" : $rmbcandidate["CandidateProfile_PicFileName"];
                    ?>
                    
                
                      <DT><IMG CLASS="candidate" SRC="/shared/pics/<?= $PicVar ?>?<?= time() ?>"></DT>
                    </DL>

										<DL class="f40">
											<DD>
                      	<INPUT type="file" name="filepicture">
                      	<INPUT type="hidden" name="oldfilename" value="<?= $rmbcandidate["CandidateProfile_PicFileName"] ?>">
                      </DD>
                      
                    </DL>

										<p><button type="submit" class="submitred"><?= $StatusMessage ?></button></p>

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
                      
                    <HR> 
                    
                    <DL class="f40">
                      <DT><LABEL>Upload your PDF platform</LABEL> <I>(Max file size 1 Mb.)</I></DT>
                      <DD>
                      	<INPUT type="file" name="pdfplatform">
 	                      <INPUT type="hidden" name="oldpdfname" value="<?= $rmbcandidate["CandidateProfile_PDFFileName"] ?>">
                      </DD>
                    </DL>            
                    
                    <?php if (! empty ($rmbcandidate["CandidateProfile_PDFFileName"])) { ?>
  									<P>
  	                                          
 	                  <B><A HREF="/shared/platforms/<?= $rmbcandidate["CandidateProfile_PDFFileName"] ?>" TARGET="Platform">Download PDF platform</A></B>
  	                                          
                  	<div id="demo-basic">
											<embed src="/shared/platforms/<?= $rmbcandidate["CandidateProfile_PDFFileName"] ?>" width="500" height="600" type="application/pdf">
										</div>
                    
	                  </P>
	                  <?php } ?>     
	                  
	                  <p><button type="submit" class="submitred"><?= $StatusMessage ?></button></p>
                                    
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
                    
                    <p><button type="submit" class="submitred"><?= $StatusMessage ?></button></p>
                    
                    <P class="f40">
                      All of the fields on this page are optional and can be deleted at any
                      time, and by filling them out, you're giving us consent to share this
                      data wherever your user profile appears. Please see our
                      <a HRef="https://github.com/site/privacy">privacy statement</a>
                      to learn more about how we use this information.
                    </P>

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