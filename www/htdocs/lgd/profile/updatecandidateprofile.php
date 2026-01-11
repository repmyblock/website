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
    WriteStderr($_POST, "POST Candidate Profile:");
     
    if (empty ($CandidateProfileID)) {
      // Find the CandidateElections in table CandidateElectionID
      $ElectionsList = $rmb->CandidateElection($URIEncryptedString["DBTable"], 'X', NULL, NULL, $URIEncryptedString["Elections_ID"]);
      
      if ( empty ($ElectionsList)) {
        $DataTable = [
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
          "DBValue" => "X"
        ];
        $CandidateElectionID = $rmb->InsertCandidateElection($DataTable);  
      } else {
        $CandidateElectionID = $ElectionsList[0]["CandidateElection_ID"];
      }

      // Verify that the candidate doesn't exist.
      $CandidateInfo = $rmb->ListCandidateInformationByUNIQ($URIEncryptedString["VoterUniqID"], NULL, $CandidateElectionID);
       
      if ( empty ($CandidateInfo)) {
        // Create the Candidate Stuff
        $CandidateID = $rmb->InsertCandidate($rmbperson["SystemUser_ID"], $URIEncryptedString["VoterUniqID"], 
        																			$rmbperson["Voters_ID"], NULL, $CandidateElectionID,
        																			$rmbperson["SystemUser_Party"], trim($_POST["FullName"]), NULL, 
        																			$URIEncryptedString["DBTable"], NULL,  NULL, 'pending');
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
          $PictureFilename = "C" .   $CandidateID . "_" . $_POST["FirstName"] . "_" . $_POST["LastName"];
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
            $PDFFilename = "C" .   $CandidateID . "_" . $_POST["FirstName"] . "_" . $_POST["LastName"];
            $PDFFilename = preg_replace("/[^A-Za-z0-9_-]/",'', $PDFFilename) . "." . $suffix;
                          
            preg_match('/(.{4})(.{4})(.{4})/', md5($PDFFilename), $matches, PREG_OFFSET_CAPTURE);
            $PdfMD5Struct = $matches[1][0] . "/" . $matches[2][0] . "/" . $matches[3][0];
            
            @mkdir($PDFStructure . $PdfMD5Struct, 0777, true);
            $PDFFilename = $PdfMD5Struct . "/" . $PDFFilename;  
          }
                    
          // This is to handle the temp namespace 
          preg_match("|([a-f0-9]{4})/([a-f0-9]{4})/([a-f0-9]{4})/(.*)|", $PDFFilename, $PDFPathMatches, PREG_OFFSET_CAPTURE);
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
        "First"   =>  ucwords(strtolower(trim($_POST["FirstName"]))),
        "Last"   =>  ucwords(strtolower(trim($_POST["LastName"]))),
        "Full"   =>  ucwords(strtolower(trim($_POST["FullName"]))),
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
  $StatusMessage = "Save profile";
  
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

    <div class="row layout">
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
      <div class="main">
        <div class="col-full">
          <div class="Subhead">
            <h2 class="Subhead-heading">Candidate Profile</h2>
          </div>
          <?php  PlurialMenu($k, $TopMenus);  ?>
         
                <FORM ACTION="" METHOD="POST" ENCTYPE="multipart/form-data">
                	<input type="hidden" name="SelectedParty" id="SelectedParty">   
                	<textarea name="CandidateProfileBio" id="campaign-html" hidden></textarea>
                	
                  <P class="f60">
                    <B>This profile will be presented to every person that visits the Rep My Block website.</B> You 
                    will be able to upload a one-page PDF of your platform that will be used to create a voter 
                    booklet that a voter will download and email.
                  </P>
                                    
                  <?php if ($rmbcandidate["CandidateProfile_PublishProfile"] != 'yes') { ?>
                    <P class="f60">
                      <INPUT TYPE="CHECKBOX" NAME="PrivateRun" VALUE="yes"<?php if ($rmbcandidate["CandidateProfile_PublishProfile"] == 'yes') { echo " CHECKED"; } ?>>&nbsp;Publish the profile on the Rep My Block guide on the website.                    
                      <BR><FONT COLOR="RED"><B>ATTENTION:</B></FONT> Once you publish the information, this option disappear. Do not select this
                      option if you do not want your profile to be public.
                      <I>
                        (<B>Note:</B> once the information is on a public website, the 
                        information will automatically get updated, and this 
                        option will disappear.)
                      </I>
                    </P>
                    <p><button type="submit" class="submitred"><?= $StatusMessage ?></button></p>
                  <?php } ?>

                  <P class="f80"><B>Biographic Information</B></P>

                  <DIV>

                    <div class="field">
                      <input id="FirstName" type="text" class="input" name="FirstName" value="<?= htmlspecialchars($ProfileFirstName) ?>" required placeholder=" ">
                      <label for="FirstName">First Name</label>
                    </div>          

                    <div class="field">
                      <input id="LastName" type="text" class="input" name="FirstName" value="<?= htmlspecialchars($ProfileLastName) ?>" required placeholder=" ">
                      <label for="LastName">Last Name</label>
                    </div>              

                    <div class="field">
                      <input id="FullName" type="text" class="input" name="FullName" value="<?= htmlspecialchars($ProfileAlias) ?>" required placeholder=" ">
                      <label for="FullName">Public Facing Name</label>
                    </div>                
  
                    <DIV><button type="submit" class="submitred"><?= $StatusMessage ?></button></DIV>
                    
                    <HR>  
                      
                    <P class="f80"><B>Upload your picture</B></P>
 									    <?php 
                          $PicVar = (empty($rmbcandidate["CandidateProfile_PicFileName"])) ? 
                                        "0000/NoPicture.jpg" : $rmbcandidate["CandidateProfile_PicFileName"];
                      ?>
                      <DIV><IMG CLASS="candidate" SRC="/shared/pics/<?= $PicVar ?>?<?= time() ?>"></DIV>
                    </DIV>

                    <DIV class="f40">
                      <DIV>
                        <INPUT type="file" name="filepicture">
                        <INPUT type="hidden" name="oldfilename" value="<?= $rmbcandidate["CandidateProfile_PicFileName"] ?>">
                      </DIV>
                    </DIV>

                    <p><button type="submit" class="submitred"><?= $StatusMessage ?></button></p>

                    <HR>  
                    
                     <P class="f80"><B>Campaign Information</B></P>
                    
                    <div class="field">
                      <input id="FullName" type="text" class="input" name="Email" value="<?= htmlspecialchars($rmbcandidate["CandidateProfile_Email"]) ?>" placeholder=" ">
                      <label for="FullName">Campaign Email</label>
                    </div>                


                    <div class="field">
                      <input id="FullName" type="text" class="input" name="URL" value="<?= htmlspecialchars($rmbcandidate["CandidateProfile_Website"]) ?>" placeholder=" ">
                      <label for="FullName">Campaign Website</label>
                    </div>                
                           
                  
                  
                    <div class="field">
                      <input id="FullName" type="text" class="input" name="PhoneNumber" value="<?= htmlspecialchars($rmbcandidate["CandidateProfile_PhoneNumber"]) ?>" placeholder=" ">
                      <label for="FullName">Campaign Phone Number</label>
                    </div>     
                  
                    <div class="field">
                      <input id="FullName" type="text" class="input" name="FaxNumber" value="<?= htmlspecialchars($rmbcandidate["CandidateProfile_FaxNumber"]) ?>" placeholder=" ">
                      <label for="FullName">Campaign Fax Number</label>
                    </div>       
                    
                                         
                  <div class="field">
                    <input id="donationlink" type="text" class="input" name="donationlink" value="<?= htmlspecialchars($rmbcandidate["CandidateProfile_Donation"]) ?>" placeholder=" ">
                    <label for="donationlink">Donation Link</label>
                  </div>       
                    
                  <p><button type="submit" class="submitred"><?= $StatusMessage ?></button></p>

                    <HR>  
                      
                    
                    	 <P class="f80"><B>Short Campaign Statement</B></P>
                                           
                        <?php /*
                        <TEXTAREA class="form-control" placeholder="Tell us a little bit about yourself" 
                          name="CandidateProfileBio"></TEXTAREA>
                      */ ?>
                                     
                       <style>
                      #html-output { white-space: pre-wrap;  }

                      .content {
                        box-sizing: border-box;
                        margin: 0 auto;
                        max-width: auto;
                        padding: 10px;
                      }

                      .save-button {
                        background-color: #04AA6D;
                        color: white;
                        padding: 12px 20px;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;
                        /* float: right; */
                      }
                      <?php require $_SERVER["DOCUMENT_ROOT"] . "/../libs/utils/External_Pell/dist/pell.min.css"; ?>
                       </STYLE>

                      <div class="content">
                      <div id="editor" class="pell"></div>
                      
                      <?php 
                        /*
                        <div style="margin-top:20px;">
                          <h3>Text output:</h3>
                          <div id="text-output"></div>
                        </div>
                        
                        <div style="margin-top:20px;">
                          <h3>HTML output:</h3>
                          <pre id="html-output"></pre>
                        </div>
                        */ 
                      ?>
                    </div>
                  </DIV>
                      
                      <p><button type="submit" class="submitred"><?= $StatusMessage ?></button></p>

                      
                  <HR> 
                  
        <STYLE>
							/* =====================================================
   BUTTON BASE
   ===================================================== */
.button2 {
  border: none;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 140px;
  height: 28px;
  font-size: 15px;
  font-weight: 600;
  color: #fff;
  transition: opacity .2s, transform .15s;
}

.button2:hover {
  transform: scale(1.05);
}

.button2-group {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}

/* =====================================================
   MODEL BUTTONS
   ===================================================== */
.model-btn {
  opacity: .35;
}

.model-btn[data-model="eu"] { background:#2b6cff; }
.model-btn[data-model="us"] { background:#cc0000; }

.model-btn.active {
  opacity: 1;
  border: 2px solid #000;
}

/* =====================================================
   AXIS BUTTONS
   ===================================================== */
.axis-btn {
  background:#6e6a6a;
  opacity:.35;
}

.axis-btn.active {
  opacity:1;
  border:2px solid #000;
}

/* axis colors (always present, visibility via opacity) */
.axis-left-red   { background:#cc0000; }
.axis-right-red  { background:#cc0000; }
.axis-left-blue  { background:#2b6cff; }
.axis-right-blue { background:#2b6cff; }

/* =====================================================
   PARTY GRID
   ===================================================== */
.party-row {
  display:flex;
  gap:16px;
  margin-bottom:12px;
}

.candidate {
  width: 64px;
  cursor: pointer;
  opacity: 0.35;
  transition: opacity .2s, transform .15s, box-shadow .15s;
}

.candidate.active {
  opacity: 1;
  /*   transform:scale(1.05); */
}

.candidate.selected {
  opacity: 1;
  transform: scale(1.1);
  box-shadow: 0 0 0 3px #000;
  border-radius: 6px;
  
  /*
   border:3px solid #000;
  padding:4px;
  box-sizing:border-box; 
  */
}


/* =====================================================
   TOOLTIP
   ===================================================== */
#party-tooltip {
  position:fixed;
  z-index:9999;
  background:#111;
  color:#fff;
  padding:10px 12px;
  border-radius:6px;
  max-width:260px;
  font-size:13px;
  opacity:0;
  pointer-events:none;
  transition:opacity .15s;
}

		</STYLE>
    
    <div>
		 
		   <P class="f80"><B>Political persuasion</B></P>

		  <div style="padding-bottom: 15px;">
		    Select the political persuasion that fits your belief system. We will <BR>
		    <A TARGET="persuation" HREF="/web/toplinks/about">For detailed information about political tendencies</A>.
		  </div>
		  

		  <div class="button2-group" style="padding-bottom: 15px;">
		    <button type="button" class="button2 model-btn" data-model="eu">European Model</button>
		    <button type="button" class="button2 model-btn" data-model="us">American Model</button>
		  </div>

		  <div class="button2-group" style="padding-bottom: 15px;">
				<button type="button" class="button2 axis-btn" data-axis="left">Left</button>
				<button type="button" class="button2 axis-btn" data-axis="center">Center</button>
				<button type="button" class="button2 axis-btn" data-axis="right">Right</button>
		  </div>
		</div>
		

  	<div id="party-container">
		  <div id="party-top" class="party-row">
		    <img class="candidate" id="pir" data-party="pir" alt="Pirate" src="/shared/teams/pirates/Pirate.png">
		    <img class="candidate" id="ipa" data-party="ipa" alt="International People's Party" src="/shared/teams/ipa/ipa.png">
		    <img class="candidate" id="isa" data-party="isa" alt="Socialist Alternative" src="/shared/teams/socalternative/ISAlternative.png">
		    <img class="candidate" id="com" data-party="com" alt="Communists" src="/shared/teams/communists/solidnet.png">
		    <img class="candidate" id="pri" data-party="pri" alt="Progressive International" src="/shared/teams/proginternational/ProgInternational.png">
		    <img class="candidate" id="gre" data-party="gre" alt="Greens" src="/shared/teams/greens/Greens.png">
		    <img class="candidate" id="soc" data-party="soc" alt="Socialists" src="/shared/teams/socialists/Socialists.png">
		    <img class="candidate" id="pra" data-party="pra" alt="Progressive Alliance" src="/shared/teams/progalliance/ProgAlliance.png">
		  </div>
								
			<div id="party-bottom" class="party-row">
        <IMG class="candidate" ALT="Liberals"  id="lib" class="candidate imglogo" SRC="/shared/teams/liberals/LiberalInternational.png">
        <IMG class="candidate" ALT="Christian Democrats"  id="cdu" class="candidate imglogo" SRC="/shared/teams/christiansdemocrats/IDC.png">
        <IMG class="candidate" ALT="Libertarians"  id="lbt" class="candidate imglogo" SRC="/shared/teams/libertarians/Libertarian.png">
        <IMG class="candidate" ALT="Democratic Union"  id="idu" class="candidate imglogo" SRC="/shared/teams/democrats/IDU.png">
        <IMG class="candidate" ALT="Indentity and Democracy"  id="con" class="candidate imglogo" SRC="/shared/teams/identity/Conservatives.png">
			</div>
		</div>						 									   
               									

<div id="party-tooltip"></div>

<script>
/* =========================================================
   DATA
   ========================================================= */

const MODELS = {
  eu: {
    top: ['pir','ipa','isa','com','pri','gre','soc','pra'],
    bottom: ['lib','cdu','lbt','idu','con']
  },
  us: {
    top: ['pir','ipa','isa','com','pri','gre','soc','pra','lib','cdu'],
    bottom: ['lbt','idu','con']
  }
};

const AXIS = {
  eu: {
    left:   ['pir','ipa','isa','com','pri','gre','soc','pra'],
    center: ['soc','pra','lib'],
    right:  ['lib','cdu','lbt','idu','con']
  },
  us: {
    left:   ['pir','ipa','isa','com','pri','gre','soc','pra','lib','cdu'],
    center: ['pra','lib','cdu'],
    right:  ['lbt','idu','con']
  }
};

const PARTY_INFO = {
  pir:{name:'Pirate Parties',desc:'Digital rights & transparency<BR><B>US:</B> Pirate Party'},
  ipa:{name:'People’s Party',desc:'International solidarity<BR><B>US:</B> Party for Socialism and Liberation'},
  isa:{name:'Socialist Alternative',desc:'Revolutionary socialism<BR><B>US:</B> Socialist Alternative'},
  com:{name:'Communists',desc:'Marxist traditions<BR><B>US:</B> Communist Party, USA'},
  pri:{name:'Progressive International',desc:'Global progressives<BR><B>US:</B> Democrat Socialists of America'},
  gre:{name:'Greens',desc:'Ecology & climate justice<BR><B>US:</B> Global Greens USA'},
  soc:{name:'Socialists',desc:'Social Democratic Socialism<BR><B>US:</B> Social Democrats of America'},
  pra:{name:'Progressive Alliance',desc:'Progressivism<BR><B>US:</B> Progressive Democrats of America'},
  lib:{name:'Liberals',desc:'Civil liberties & markets<BR><B>US:</B> Center for New Liberalism'},
  cdu:{name:'Christian Democrats',desc:'Social market economy<BR><B>US:</B> Frederick Douglass Foundation'},
  lbt:{name:'Libertarians',desc:'Individual liberty<BR><B>US:</B> Libertarian Party'},
  idu:{name:'Democratic Union',desc:'Conservative alliance<BR><B>US:</B> Republican National Committee'},
  con:{name:'Patriots',desc:'National conservatism<BR><B>US:</B> Conservative Party'}
};

/* =========================================================
   STATE
   ========================================================= */

let currentModel = null;
let currentAxis  = null;

/* =========================================================
   DOM
   ========================================================= */

const topRow   = document.getElementById('party-top');
const bottomRow= document.getElementById('party-bottom');
const tooltip  = document.getElementById('party-tooltip');

const modelBtns = document.querySelectorAll('.model-btn');
const axisBtns  = document.querySelectorAll('.axis-btn');
const candidates = document.querySelectorAll('.candidate');
const selectedInput = document.getElementById('SelectedParty');

/* =========================================================
   PARTY CLICK (POST FIX)
   ========================================================= */

candidates.forEach(img => {
  img.addEventListener('click', () => {

    // toggle logic
    if (img.classList.contains('selected')) {
      img.classList.remove('selected');
      selectedInput.value = '';
      return;
    }

    // single selection
    candidates.forEach(c => c.classList.remove('selected'));
    img.classList.add('selected');

    // 🔑 value sent via POST
    selectedInput.value = img.dataset.party || img.id;
  });

  // tooltip
  img.addEventListener('mouseenter', e => {
    const p = PARTY_INFO[img.id];
    if (!p) return;
    tooltip.innerHTML = `<strong>${p.name}</strong><br>${p.desc}`;
    tooltip.style.opacity = 1;
  });

  img.addEventListener('mousemove', e => {
    tooltip.style.left = e.clientX + 15 + 'px';
    tooltip.style.top  = e.clientY + 15 + 'px';
  });

  img.addEventListener('mouseleave', () => {
    tooltip.style.opacity = 0;
  });
});

/* =========================================================
   HELPERS
   ========================================================= */

function showAll() {
  candidates.forEach(c => c.classList.add('active'));
}

function setAxisEnabled(enabled) {
  axisBtns.forEach(b => {
    b.style.pointerEvents = enabled ? 'auto' : 'none';
    b.style.opacity = enabled ? '' : '0.35';
  });
}

function updateAxisColors(model) {
  const L = document.querySelector('[data-axis="left"]');
  const R = document.querySelector('[data-axis="right"]');

  L.classList.remove('axis-left-red','axis-left-blue');
  R.classList.remove('axis-right-red','axis-right-blue');

  if (model === 'us') {
    L.classList.add('axis-left-blue');
    R.classList.add('axis-right-red');
  } else {
    L.classList.add('axis-left-red');
    R.classList.add('axis-right-blue');
  }
}

function applyModel(model) {
  currentModel = model;

  const topFrag = document.createDocumentFragment();
  const bottomFrag = document.createDocumentFragment();

  MODELS[model].top.forEach(id => {
    const el = document.getElementById(id);
    if (el) topFrag.appendChild(el);
  });

  MODELS[model].bottom.forEach(id => {
    const el = document.getElementById(id);
    if (el) bottomFrag.appendChild(el);
  });

  // clear rows SAFELY
  while (topRow.firstChild) topRow.removeChild(topRow.firstChild);
  while (bottomRow.firstChild) bottomRow.removeChild(bottomRow.firstChild);

  // reattach
  topRow.appendChild(topFrag);
  bottomRow.appendChild(bottomFrag);

  updateAxisColors(model);

  if (currentAxis) {
    applyAxis(currentAxis);
  } else {
    showAll();
  }
}
function applyAxis(axis) {
  if (!currentModel) return;
  currentAxis = axis;

  const allowed = new Set(AXIS[currentModel][axis]);

  candidates.forEach(c => {
    c.classList.toggle('active', allowed.has(c.id));
  });
}

/* =========================================================
   EVENTS
   ========================================================= */

modelBtns.forEach(btn => {
  btn.onclick = () => {
    const model = btn.dataset.model;

    if (currentModel === model) {
      currentModel = null;
      modelBtns.forEach(b => b.classList.remove('active'));
      axisBtns.forEach(b => b.classList.remove('active'));
      setAxisEnabled(false);
      showAll();
      return;
    }

    modelBtns.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    setAxisEnabled(true);
    applyModel(model);
  };
});

axisBtns.forEach(btn => {
  btn.onclick = () => {
    axisBtns.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    applyAxis(btn.dataset.axis);
  };
});

/* =========================================================
   INIT
   ========================================================= */

showAll();
setAxisEnabled(false);
</script>


 									<p><button type="submit" class="submitred"><?= $StatusMessage ?></button></p>


                  <HR> 
                  
                  
                  <P class="f80"><B>Endorsement Screen</B></P>

										
                    <P class="f60">
                      <INPUT TYPE="CHECKBOX" NAME="PrivateRun" VALUE="yes"<?php if ($rmbcandidate["CandidateProfile_PublishProfile"] == 'yes') { echo " CHECKED"; } ?>>&nbsp;
                      <B>Select this option</B> if you are interested in applying for endorsements from organizations that share your values directly through the Rep My Block website.

										</P>
										
										<P class="f60">
											You will be provided with a list of organizations, based on their IRS tax status, whose values you may promote or which may choose to endorse you.
										</P>
										
									

 									<p><button type="submit" class="submitred"><?= $StatusMessage ?></button></p>
                             

                  <HR> 
                  
                  
                  <P class="f80"><B>Upload your PDF platform</B></P>
                  <DIV <I>(Max file size 1 Mb.)</I></DIV>
                    <DIV>
                      <INPUT type="file" name="pdfplatform">
                      <INPUT type="hidden" name="oldpdfname" value="<?= $rmbcandidate["CandidateProfile_PDFFileName"] ?>">
                    </DIV>
                        
                  
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
  
								   <P class="f80"><B>Social Media</B></P>
  
                  <div class="field">
                    <input id="Twitter" type="text" class="input" name="Twitter" value="<?= htmlspecialchars($rmbcandidate["CandidateProfile_Twitter"]) ?>" placeholder=" ">
                    <label for="Twitter">Twitter</label>
                  </div>                  
      
                  <div class="field">
                    <input id="Bluesky" type="text" class="input" name="Bluesky" value="<?= htmlspecialchars($rmbcandidate["CandidateProfile_Bluesky"]) ?>" placeholder=" ">
                    <label for="Bluesky">Bluesky</label>
                  </div>                         
                          
                  <div class="field">
                    <input id="Instagram" type="text" class="input" name="Instagram" value="<?= htmlspecialchars($rmbcandidate["CandidateProfile_Instagram"]) ?>" placeholder=" ">
                    <label for="Instagram">Instagram</label>
                  </div>       
                          
                  <div class="field">
                    <input id="Facebook" type="text" class="input" name="Facebook" value="<?= htmlspecialchars($rmbcandidate["CandidateProfile_Facebook"]) ?>" placeholder=" ">
                    <label for="Facebook">Facebook</label>
                  </div>       
                    
                  <div class="field">
                    <input id="YouTube" type="text" class="input" name="YouTube" value="<?= htmlspecialchars($rmbcandidate["CandidateProfile_YouTube"]) ?>" placeholder=" ">
                    <label for="YouTube">YouTube</label>
                  </div>       
                       
                  <div class="field">
                    <input id="TikTok" type="text" class="input" name="TikTok" value="<?= htmlspecialchars($rmbcandidate["CandidateProfile_TikTok"]) ?>" placeholder=" ">
                    <label for="TikTok">Tik Tok</label>
                  </div>       
                                 
                  <div class="field">
                    <input id="Ballotpedia" type="text" class="input" name="Ballotpedia" value="<?= htmlspecialchars($rmbcandidate["CandidateProfile_BallotPedia"]) ?>" placeholder=" ">
                    <label for="Ballotpedia">Ballotpedia</label>
                  </div>       
                    
                    
                    
                    <DIV><button type="submit" class="submitred"><?= $StatusMessage ?></button></DIV>
                    
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
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>
    <SCRIPT>
      <?php require $_SERVER["DOCUMENT_ROOT"] . "/../libs/utils/External_Pell/dist/pell.min.js"; ?>
    </SCRIPT>
    <script>
      var editor = window.pell.init({
        element: document.getElementById('editor'),
        defaultParagraphSeparator: 'p',
        
        actions: [
            'bold',
            'italic',
            'underline',        
            'olist',
            'ulist',
            'link',
          ],
               
        onChange: html => {
     		 // 🔑 store HTML for POST
		      document.getElementById('campaign-html').value = html;
		    }
		        
        	
       
        
      });
      
      
  </script>
  <script>
  const form = document.querySelector('form');
  const campaignField = document.getElementById('campaign-html');

  form.addEventListener('submit', e => {
    if (publishChecked && !campaignField.value.trim()) {
      alert('Campaign statement required to publish.');
      e.preventDefault();
    }
  });
</script>
 
  <SCRIPT>
  // Populate with HTML
  	editor.content.innerHTML = `<?= $rmbcandidate["CandidateProfile_Statement"] ?>`;
	</SCRIPT>	
	
  </BODY>
</HTML>