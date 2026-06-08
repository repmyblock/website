<?php
  $MaxPDFSize = 1250000;
  $MaxPicSize = 1250000;

  $Menu = "profile";  
  $BigMenu = "profile";
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
  WriteStderr($_POST, "POST in UPDATECANDIDATEPROFILE after loading VERIF and DBFunctions:");
  
  // Process error message
  if (is_array($URIEncryptedString["ErrorMessage"])) {
    switch($URIEncryptedString["ErrorMessage"]) {  
      case "A": $IntErrorMsg = "This error."; break;
      case "B": $IntErrorMsg = "The Poisition running is not there."; break;
      case "C": $IntErrorMsg = "The image is bigger than 1mb."; break;
      case "D": $IntErrorMsg = "The image format is not recognized."; break;
      case "E": $IntErrorMsg = "The PDF file is bigger than 1 mb."; break;
      case "F": $IntErrorMsg = "You can only upload PDF files."; break;
     }  
    WipeURLEncrypted(null, "ErrorMessage");
  } 

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  $rmb = new repmyblock(0);  
  
  $rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);
  WriteStderr($rmbperson, "rmbperson array");
    
  $rmbcandidate = $rmb->ListProfilesForCandidates(
  													CandidateID: $URIEncryptedString["Candidate_ID"],
   													SQLTables: ["CandidateElection.CandidateElection_DBTableValue AS CanProfDBTableVal", "debugsql"]
  													)[0];
  WriteStderr($rmbcandidate, "rmbcandidate array");
 

  // Put the POST HERE because we need to reread the data 
  if ( ! empty ($_POST)) {  
    WriteStderr($_POST, "POST Update Candidate Profile:");
    $PicStructure = $GeneralUploadDir . "/shared/pics/";
    $PDFStructure = $GeneralUploadDir . "/shared/platforms/"; 
      
    // This is to deal with the Error messages.
    if ( empty ($_POST["positionrunning"]) && empty (trim($_POST["manuposition"]))) { 
      $ErrorMessage[] = "B"; 
    }
 
    // This is the common setup that create the candidate as needed
    $URIEncryptedString["DataStateID"] = empty($URIEncryptedString["DataStateID"]) ? $rmbcandidate["DataState_ID"] : $URIEncryptedString["DataStateID"];
    $URIEncryptedString["DateElection"] = empty($URIEncryptedString["DateElection"]) ? $rmbcandidate["Elections_Date"] : $URIEncryptedString["DateElection"];
    $URIEncryptedString["FirstName"] = empty($URIEncryptedString["FirstName"]) ? $rmbcandidate["FirstName"] : $URIEncryptedString["FirstName"];
    $URIEncryptedString["LastName"] = empty($URIEncryptedString["LastName"]) ? $rmbcandidate["LastName"] : $URIEncryptedString["LastName"];
    $URIEncryptedString["PositionID"] = empty($URIEncryptedString["PositionID"]) ? $rmbcandidate["ElectionsPosition_ID"] : $URIEncryptedString["PositionID"];
    $URIEncryptedString["CanElectID"] = empty($URIEncryptedString["CanElectID"]) ? $rmbcandidate["CandidateElection_ID"] : $URIEncryptedString["CanElectID"];
    require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/candprofile_commonsetup.php";
    
    // Check the files 
    if (! empty ($URIEncryptedString["Candidate_ID"]) && empty ($ErrorMessage)) {  
             
      WriteStderr(null, "Inside the check the files");
             
      $PicFilePath = $rmbcandidate["CandidateProfile_PicFileName"];  
      $PDFFilePath = $rmbcandidate["CandidateProfile_PDFFileName"];  
              
      // This is to deal with the Picture itself and we must check it's type image/<something else>
      $PictureFile = false;
      
      WriteStderr($_FILES, "Checking \$_FILES[\"filepicture\"][\"name\"]" . $_FILES["filepicture"]["name"] );
      if (! empty ($_FILES["filepicture"]["name"])) {
      
        switch ($_FILES["filepicture"]["error"]) {
          case 0:        
             
             
            if ( $_FILES["filepicture"]["size"] < $MaxPicSize) {
              preg_match("#image/(.*)#", $_FILES["filepicture"]["type"], $matches, PREG_OFFSET_CAPTURE);
                          
              if (empty($PicFilePath)) {
                WriteStderr(null, "I am inside Empty PicFilePath - CandidateID: " . $URIEncryptedString["Candidate_ID"]);
                $suffix = $matches[1][0];      
                $PictureFilename = $URIEncryptedString["Candidate_ID"] . "_" . $_POST["FirstName"] . "_" . $_POST["LastName"];
                $PictureFilename = preg_replace("/[^A-Za-z0-9_-]/",'', $PictureFilename) . "." . $suffix;
                              
                WriteStderr(null, "PictureFilename: $PictureFilename");
                              
                preg_match('/(.{4})(.{4})(.{4})/', md5($PictureFilename . time()), $matches, PREG_OFFSET_CAPTURE);
                $PicMD5Struct = $matches[1][0] . "/" . $matches[2][0] . "/" . $matches[3][0];
                
                @mkdir($PicStructure . $PicMD5Struct, 0777, true);
                $PicFilePath = $PicMD5Struct . "/" . $PictureFilename;
                
                WriteStderr(null, "I am finishing Empty PicFilePath: $PicFilePath");
                
              } else {
              	$PictureFilename = preg_replace('#(^|.*/)\KC_#', '', $PicFilePath);
           		}
              // This is to handle the temp namespace 
             #
              preg_match("|([a-f0-9]{4})/([a-f0-9]{4})/([a-f0-9]{4})/(.*)|", $PicFilePath, $PicPathMatches, PREG_OFFSET_CAPTURE);        
              $PicFilePath = $PicPathMatches[1][0] . "/" . $PicPathMatches[2][0] . "/" . $PicPathMatches[3][0];
              $PicFileName = $PicPathMatches[4][0];
              $TmpPicFilePath = $PicFilePath . "/TMP_" .$PicFileName;
              
              
              WriteStderr(null, "PicFileName: $PicFileName");
              WriteStderr(null, "TmpPicFilePath: $TmpPicFilePath");
           
              
              if (empty ($TmpPicFilePath)) {
                echo "Catastrophic error for some reason<BR>";
                exit();
              }

              WriteStderr(null, "Moving the file to " . $PicStructure . $TmpPicFilePath);              
              if (! move_uploaded_file($_FILES['filepicture']['tmp_name'], $PicStructure . $TmpPicFilePath)) {
                echo "Catastrophic error moving the picture the picture";
                exit();
              } 
              $PictureFile = true;
                              
            } else {
              $ErrorMessage[] = "C"; 
            }
            break;
            
          case 1:
            $ErrorMessage[] = "C"; 
            break;
            
           case 2:
            $ErrorMessage[] = "D"; 
            break;
        }
      }
      WriteStderr(null, "I am passing with PictureFile either True/False: $PictureFile");
      

      // This is to deal with the pdf
      $PDFFile = false;
      if (! empty ($_FILES["pdfplatform"]["name"])) {  
        switch ($_FILES["pdfplatform"]["error"]) {
          case 0:
            $PDFStructure = $GeneralUploadDir . "/shared/platforms/"; 
            
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
               $ErrorMessage[] = "E"; 

             }
            break;
             
          case 1:
            $ErrorMessage[] = "F";              
             break;
        }
      }
               
      if ( ! empty ($ErrorMessage)) {
       header("Location: /" . MergeEncode(['ErrorMessage' => $ErrorMessage]) . "/lgd/profile/candidate/updatecandidateprofile");
       exit();
      }

      
      // End of File Dealing.         
      // ADD to the database the following table
           
      $CandidateProfile = [
          "First"   =>  ucwords(strtolower(trim($_POST["FirstName"]))),
          "Last"   =>  ucwords(strtolower(trim($_POST["LastName"]))),
          "Full"   =>  ucwords(strtolower(trim($_POST["FullName"]))),
          "Email"   =>  trim($_POST["Email"]),
          "URL"   =>  trim($_POST["URL"]),
          "Phone"   =>  trim($_POST["PhoneNumber"]),
          "Fax"   =>  trim($_POST["FaxNumber"]),
          "Platform"   =>  trim($_POST["CandidateProfileBio"]),
          "Twitter"   =>  trim($_POST["Twitter"]),
          "BlueSky"   =>  trim($_POST["BlueSky"]),
          "Truth"   =>  trim($_POST["Truth"]),
          "Instagram"   => trim( $_POST["Instagram"]),
          "Facebook"   =>  trim($_POST["Facebook"]),
          "LinkedIn"   =>  trim($_POST["LinkedIn"]),
          "YouTube"   =>  trim($_POST["YouTube"]),
          "TikTok"   =>  trim($_POST["TikTok"]),
          "Donation" => trim($_POST["donationlink"]),
          "Ballotpedia"   =>  trim($_POST["Ballotpedia"]),
          "SelfAss" => substr($_POST["SelectedParty"], 0, 3),
          "SelfParty" => substr($_POST["SelectedCaucusParty"], 0, 3),
          "SelfCaucus" =>  intval($_POST["SelectedCaucusMask"]),
          "PicVerified" => 'yes', ### Always yes until I create a menu to verify
          "PicFile" =>  trim($_POST["oldfilename"]),
          "MakePublic" => (((!empty ($_POST["MakePublic"])) && $_POST["MakePublic"] == "yes") ? 'yes' : 'no'),
      ];   
     
     	WriteStderr($CandidateProfile, "After the Private and all that stuff CANDIDATEPROFILE:");
     
     	
     
			if ( ! empty ($_POST["oldtmpfilename"]) && empty ($_FILES["filepicture"]["full_path"]) && $_POST["SWAPIMAGE"] == 'yes') {
				WriteStderr($_POST, "POST inside the !empty Post OldFile with the PictureFilename -> $PictureFilename");

				if ( $_POST["SWAPIMAGE"] == 'yes' && $PictureFile == false) {
					$PictureFilename = preg_replace('#(^|.*/)\KCRP_#', '', $rmbcandidate["CandidateProfile_TmpPicFileName"]);
					WriteStderr(null, "Moving " . $rmbcandidate["CandidateProfile_TmpPicFileName"] . " TO " . $PictureFilename);
					copy($PicStructure . $rmbcandidate["CandidateProfile_TmpPicFileName"], $PicStructure . $PictureFilename . "_" . time());
					rename($PicStructure . $rmbcandidate["CandidateProfile_TmpPicFileName"], $PicStructure . $PictureFilename);
					$CandidateProfile["PicFile"] = $PictureFilename;
				
				}
			}

			if ( ! empty ($_POST["oldpdfname"]) && empty ($_FILES["pdfplatform"]["full_path"])) {
				$CandidateProfile["PDFFile"] = $_POST["oldpdfname"];
			}
          
      // Check if something has changed before making another call to the database.
      $Result = 0;
      $Result += ($rmbcandidate["CandidateProfile_FirstName"] ==  $CandidateProfile["First"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_LastName"] ==  $CandidateProfile["Last"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_Alias"] ==  $CandidateProfile["Full"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_Website"] ==  $CandidateProfile["URL"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_Email"] ==  $CandidateProfile["Email"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_Twitter"] ==  $CandidateProfile["Twitter"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_BlueSky"] ==  $CandidateProfile["BlueSky"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_Truth"] ==  $CandidateProfile["Truth"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_LinkedIn"] ==  $CandidateProfile["LinkedIn"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_Instagram"] ==  $CandidateProfile["Instagram"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_TikTok"] ==  $CandidateProfile["TikTok"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_YouTube"] ==  $CandidateProfile["YouTube"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_BallotPedia"] ==  $CandidateProfile["Ballotpedia"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_Donation"] ==  $CandidateProfile["Donation"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_PhoneNumber"] ==  $CandidateProfile["Phone"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_FaxNumber"] ==  $CandidateProfile["Fax"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_Statement"] ==  $CandidateProfile["Platform"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_PolSelfAss"] ==  $CandidateProfile["SelfAss"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_PolSelfParty"] ==  $CandidateProfile["SelfParty"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_PolSelfCaucus"] ==  $CandidateProfile["SelfCaucus"]) ? 0 : 1;
      $Result += ($rmbcandidate["CandidateProfile_PicFileName"] ==  $CandidateProfile["SelfCaucus"]) ? 0 : 1;
      
      // The files need to be handled a bit differntly.
      $ResultFile = 0;
      $ResultFile += ($rmbcandidate["CandidateProfile_PicFileName"] == $CandidateProfile["PicFile"]) ? 0 : 1;                                      
      $ResultFile += ($rmbcandidate["CandidateProfile_PDFFileName"] == $CandidateProfile["PDFFile"]) ? 0 : 1;
      
      if ( $Result > 0 || $ResultFile > 0) {
				WriteStderr($CandidateProfile, "Result to update Result: $Result");
        $CandidateProfileID = $rmb->UpdateCandidateProfileAutoCycle(
        																				$CandidateProfileID, $rmbcandidate["Candidate_ID"], 
                                                $CandidateProfile);
      } else {
      	$CandidateProfileID = $rmbcandidate["CandidateProfile_ID"];
      }
                  
      if ( $PictureFile == true || $PDFFile == true) {
        if ($PictureFile == true) {  
        	
        	WriteStderr($CandidateProfileID, "I AM IN THE Picture File and PDF File is true");
          header("Location:/" . MergeEncode([
                                          "PicPath" => $PicFilePath,
                                          "PicName" => $PicFileName,
                                          "PDFPath" => $PDFFilePath,
                                          "PDFName" => $PDFFileName,                        
                                          "CandidateID" => $CandidateID,
                                          "CandidateProfileID" => $CandidateProfileID,
                                          "PublishWarning" => $_POST["PrivateRun"],
                                ]) . "/lgd/profile/candidate/fixpicture");
          exit();
        } 
        
        if ($PDFFile == true) {        
          header("Location:/" . MergeEncode([
                                          "PDFPath" => $PDFFilePath,
                                          "PDFName" => $PDFFileName,
                                          "CandidateID" => $CandidateID,
                                          "CandidateProfileID" => $CandidateProfileID,
                                          "PublishWarning" => $_POST["PrivateRun"],
                                ]) . "/lgd/profile/candidate/fixpdf");
          exit();
        }       
      }
     	
      WriteStderr($rmbcandidate, "MakePublic: " . $_POST["MakePublic"] . " CandidateProfile:" . $CandidateProfile["MakePublic"] . "\n");
      if ( $CandidateProfile["MakePublic"] == 'yes' && $rmbcandidate["PublicProfile_PublishProfile"] != 'yes') {
        header("Location: profilewarning");
        exit();
      }

      header("Location: updatecandidateprofile");
      exit();
    }
   
  }
  
  $StatusMessage = "Save profile";
  
  if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}  
  $Party = PrintParty($UserParty);
  
  if ( ! empty ($URIEncryptedString["PublicProfileID"])) {
    if ( ! empty ($PublicProfile = $rmb->PublicProfileInfo($URIEncryptedString["PublicProfileID"]))) {   
      // This is done to make sure the DB Stuff is correct.
      $rmbcandidate["CandidateProfile_FirstName"] = $PublicProfile["CandidateProfile_FirstName"];
      $rmbcandidate["CandidateProfile_LastName"] = $PublicProfile["CandidateProfile_LastName"];
      #	The candidate table nevers get touched from the Profile since it controls the petitions.
      # $rmbcandidate["Candidate_DispName"] = $PublicProfile["CandidateProfile_FirstName"] . " " . $PublicProfile["CandidateProfile_LastName"];
      $rmbcandidate["CandidateProfile_Alias"] = $PublicProfile["CandidateProfile_Alias"];
      $rmbcandidate["CandidateProfile_ID"] = $PublicProfile["CandidateProfile_ID"];      
      $rmbcandidate["CandidateProfile_Email"] = $PublicProfile["CandidateProfile_Email"];
      $rmbcandidate["CandidateProfile_Website"]  = $PublicProfile["CandidateProfile_Website"];
      $rmbcandidate["CandidateProfile_PhoneNumber"] = $PublicProfile["CandidateProfile_PhoneNumber"];
      $rmbcandidate["CandidateProfile_FaxNumber"] = $PublicProfile["CandidateProfile_FaxNumber"];
      $rmbcandidate["CandidateProfile_Donation"] = $PublicProfile["CandidateProfile_Donation"];
      $rmbcandidate["CandidateProfile_Twitter"] = $PublicProfile["CandidateProfile_Twitter"];
      $rmbcandidate["CandidateProfile_BlueSky"] = $PublicProfile["CandidateProfile_BlueSky"];
      $rmbcandidate["CandidateProfile_Truth"] = $PublicProfile["CandidateProfile_Truth"];
      $rmbcandidate["CandidateProfile_Instagram"] = $PublicProfile["CandidateProfile_Instagram"];
      $rmbcandidate["CandidateProfile_Facebook"] = $PublicProfile["CandidateProfile_Facebook"];
      $rmbcandidate["CandidateProfile_LinkedIn"] = $PublicProfile["CandidateProfile_LinkedIn"];
      $rmbcandidate["CandidateProfile_YouTube"] = $PublicProfile["CandidateProfile_YouTube"];
      $rmbcandidate["CandidateProfile_TikTok"] = $PublicProfile["CandidateProfile_TikTok"];
      $rmbcandidate["CandidateProfile_BallotPedia"] = $PublicProfile["CandidateProfile_BallotPedia"];
      $rmbcandidate["CandidateProfile_Statement"] = $PublicProfile["CandidateProfile_Statement"];     
      $rmbcandidate["CandidateElection_DBTable"] = $PublicProfile["CandidateElection_DBTable"];
      $rmbcandidate["CandidateProfile_PolSelfCaucus"] = $PublicProfile["CandidateProfile_PolSelfCaucus"];
      $rmbcandidate["CandidateProfile_PolSelfParty"] = $PublicProfile["CandidateProfile_PolSelfParty"];
      $rmbcandidate["CandidateProfile_PolSelfAss"] = $PublicProfile["CandidateProfile_PolSelfAss"];
      $rmbcandidate["CandidateProfile_PicFileName"] = $PublicProfile["CandidateProfile_PicFileName"];
      $rmbcandidate["CandidateProfile_PDFFileName"] = $PublicProfile["CandidateProfile_PDFFileName"];
      $rmbcandidate["PublishedProfile"] = $PublicProfile["PublicProfile_PublishProfile"];
      $rmbcandidate["CandidateProfile_PicVerif"] = $PublicProfile["CandidateProfile_PicVerif"];
      $rmbcandidate["Private"] = $PublicProfile["PublicProfile_PublishProfile"];
    }
  }

	 WriteStderr($rmbcandidate, "RMBCandidate in the transfering");
   WriteStderr($PublicProfile, "PublicProfile in the transfering");

  if ( ! empty ($PublicProfile["CandidateElection_DBTable"])) {     
     $DistrictDefined = true;
   } 
   
   // This is to build the list of positions.
   $rmbpositions = $rmb->ListDBTablesFromPositions($rmbcandidate["ElectionsPosition_ID"]);
   
  // This is to update the minimum profile if empty.
  if ( ! empty  ($rmbcandidate["Candidate_DispName"])) {
    $ProfileAlias = $rmbcandidate["Candidate_DispName"];
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
    $TopMenus = [
          ["url" => "profile/user", "text" => "Public Profile"],
          ["url" => "profile/voter/card", "text" => "Voter Profile"], 
          ["url" => "profile/candidate/public", "text" => "Candidate Profile"],
          ["url" => "profile/team/section", "text" => "Team Profile"]
     ];                
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
          <DIV>
            <FORM ACTION="" METHOD="POST" ENCTYPE="multipart/form-data">
              <!--- Profile ID: <?= $rmbcandidate["CandidateProfile_ID"] ?> --->

              <DIV class="f60">
                <B>This profile will be presented to every person that visits the Rep My Block website.</B> You 
                will be able to upload a one-page PDF of your platform that will be used to create a voter 
                booklet that a voter will download and email.
              </DIV>


              <?php if (! empty ($IntErrorMsg)) { ?>
                <TABLE BGCOLOR=YELLOW BORDER=1 WIDTH=100%>
                <TR><TD ALIGN=CENTER><h1>Error Message</h1>
                <h1><?= $IntErrorMsg; ?></h1>
                </TD></TR>
                </TABLE>
              <?php } ?>

              <?php /*
              <P>
                <PRE><?= print_r($URIEncryptedString, 1) ?></PRE>
                <PRE><?= print_r($PublicProfile, 1) ?></PRE>
              </P>
              */ ?>

              <DIV class="f60">
                <B><A HREF="/<?= $k ?>/lgd/profile/candidate/delegate">If you want to delegate your 
                  public profile management to a staffer
                  click here to enter your chief of staff email</A></B>
              </DIV>

              <?php if ($rmbcandidate["PublicProfile_PublishProfile"] != 'yes') { ?>
                <DIV class="f60">
                  <INPUT TYPE="CHECKBOX" NAME="MakePublic" VALUE="yes">&nbsp;Publish the profile on the Rep My Block guide on the website.                    
                  <BR><FONT COLOR="RED"><B>ATTENTION:</B></FONT> Once you publish the information, this option disappear. Do not select this
                  option if you do not want your profile to be public.
                  <I>
                    (<B>Note:</B> once the information is on a public website, the 
                    information will automatically get updated, and this 
                    option will disappear.)
                  </I>
                </DIV>
                <DIV><button type="submit" class="submitred"><?= $StatusMessage ?></button></DIV>
                <HR>  
              <?php } else { ?>                
                <INPUT TYPE="hidden" NAME="MakePublic" VALUE="yes">
              <?php } ?>
                

              <?php if ($DistrictDefined == false) { ?>
                 <DIV class="f80"><B>District Information</B></DIV>
                                      
                 <DIV class="f60">
                  If the district is not listed, please type it in manually. For statewide districts, enter “Statewide.”
                 </DIV>                  

                <div class="field field-select">
                  <SELECT name="positionrunning" id="positionrunning" class="select">
                    <OPTION VALUE="">-- Select District --</OPTION>
                    <OPTION VALUE="MANUAL">It’s not listed</OPTION>
<?php 
                      if (!empty($rmbpositions)) {
                      foreach ($rmbpositions as $var) {
                        if (!empty($var)) {
                          $OptionValue = trim($var["CandidateElection_DBTable"]) . "-" . trim($var["CandidateElection_DBTableValue"]);
                          $SelectedValue = trim($rmbcandidate["CandidateElection_DBTable"]) . "-" . trim($rmbcandidate["CanProfDBTableVal"]);
?>
                    <OPTION VALUE="<?= $OptionValue ?>"<?= ($OptionValue === $SelectedValue) ? " SELECTED" : "" ?>><?= $var["CandidateElection_Text"] ?></OPTION>
<?php
                        }
                      }
                    } 
?>  
                  </SELECT>
                  
                  
                </div>

                <!-- Manual Entry (Hidden by Default) -->
                <div class="field" id="manualPositionWrapper" style="display:none;">
                  <input type="text" id="manualPositionInput" name="manuposition" class="input" placeholder="Enter district manually">
                  <label for="manualPositionInput">Manual District</label>
                </div>
                
                <p><button type="submit" class="submitred"><?= $StatusMessage ?></button></p>
                <HR>  
              <?php } else { ?>
                <INPUT TYPE="hidden" NAME="positionrunning" VALUE="<?= $rmbcandidate["CandidateElection_DBTable"] ?>">
              <?php } ?>
                
              <DIV class="f80"><B>Biographic Information</B></DIV>


              <div class="field">
                <input id="FirstName" type="text" class="input" name="FirstName" value="<?= htmlspecialchars($ProfileFirstName) ?>" required placeholder=" ">
                <label for="FirstName">First Name</label>
              </div>          

              <div class="field">
                <input id="LastName" type="text" class="input" name="LastName" value="<?= htmlspecialchars($ProfileLastName) ?>" required placeholder=" ">
                <label for="LastName">Last Name</label>
              </div>              

              <div class="field">
                <input id="FullName" type="text" class="input" name="FullName" value="<?= htmlspecialchars($ProfileAlias) ?>" required placeholder=" ">
                <label for="FullName">Public Facing Name</label>
              </div>                

              <DIV><button type="submit" class="submitred"><?= $StatusMessage ?></button></DIV>

<HR>

        <?php
$CurrentPicVar = empty($rmbcandidate["CandidateProfile_PicFileName"])
    ? "0000/NoPicture.jpg"
    : $rmbcandidate["CandidateProfile_PicFileName"];

$LoadedPicVar = empty($rmbcandidate["CandidateProfile_TmpPicFileName"])
    ? "0000/NoPicture.jpg"
    : $rmbcandidate["CandidateProfile_TmpPicFileName"];
?>

<style>
.picture-select {
    display: flex;
    gap: 30px;
    margin-top: 10px;
}

.picture-box {
    text-align: center;
}

.candidate {
    width: 150px;
    height: auto;
    cursor: pointer;
    opacity: 0.3;
    transition: opacity 0.2s;
    border: 3px solid transparent;
}

.candidate.selected {
    opacity: 1;
    border-color: #000;
}

.drop-zone {
    margin-top: 12px;
    padding: 20px;
    border: 2px dashed #888;
    cursor: pointer;
    width: 330px;
    text-align: center;
}

.drop-zone.dragover {
    border-color: #000;
    background: #eee;
}

#filepicture {
    display: none;
}
</style>

<div class="f80"><b>Upload your picture</b></div>

<DIV class="f60">To make your picture visible to the public, select the "<B>Loaded</B>" image and and click the 
	<B>"Save Profile"</B> button.</DIV>

<div class="picture-select">
    <div class="picture-box">
        <div style="padding: 0px 10px 30px 10px;font-weight: bold;font-size: 24px">Current</div>
        <img class="candidate selected" src="/shared/pics/<?= $CurrentPicVar ?>?<?= time() ?>" data-target="current">
    </div>

    <div class="picture-box">
         <div style="padding: 0px 10px 30px 10px;font-weight: bold;font-size: 24px">Loaded</div>
        <img class="candidate" id="loaded_preview" src="/shared/pics/<?= $LoadedPicVar ?>?<?= time() ?>" data-target="loaded">
    </div>
</div>

<div id="drop_zone" class="drop-zone">Drop picture here or click to select</div>
<input type="file" id="filepicture" name="filepicture" accept="image/*">
<input type="hidden" id="selected_picture" name="oldfilename" value="<?= $rmbcandidate["CandidateProfile_PicFileName"] ?>">
<input type="hidden" id="selected_picture" name="oldtmpfilename" value="<?= $rmbcandidate["CandidateProfile_TmpPicFileName"] ?>">
<input type="hidden" id="swapimage" name="SWAPIMAGE" value="no">


<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('filepicture');
    const dropZone = document.getElementById('drop_zone');
    const loadedPreview = document.getElementById('loaded_preview');
    const selectedPicture = document.getElementById('selected_picture');
    const swapImage = document.getElementById('swapimage');

    function selectPicture(target) {
        document.querySelectorAll('.candidate').forEach(img => {
            img.classList.remove('selected');
        });

        const selectedImg = document.querySelector(
            '.candidate[data-target="' + target + '"]'
        );

        if (selectedImg) {
            selectedImg.classList.add('selected');
        }

				/* selectedPicture.value =
			    (target === 'loaded') ? 'TMP_' + < ?= json_encode(basename($rmbcandidate["CandidateProfile_PicFileName"])) ?>
			    : < ?= json_encode($rmbcandidate["CandidateProfile_PicFileName"]) ?>; */
			  swapImage.value = (target === 'loaded') ? 'yes' : 'no';
    }

    document.querySelectorAll('.candidate').forEach(img => {
        img.addEventListener('click', function () {
            selectPicture(this.dataset.target);
        });
    });

    dropZone.addEventListener('click', function () {
        fileInput.click();
    });

    dropZone.addEventListener('dragover', function (e) {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });

    dropZone.addEventListener('dragleave', function () {
        dropZone.classList.remove('dragover');
    });

    dropZone.addEventListener('drop', function (e) {
        e.preventDefault();
        dropZone.classList.remove('dragover');

        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files;
            previewLoadedPicture(e.dataTransfer.files[0]);
        }
    });

    fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
            previewLoadedPicture(fileInput.files[0]);
        }
    });

    function previewLoadedPicture(file) {
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file.');
            return;
        }

        const reader = new FileReader();

        reader.onload = function (e) {
            loadedPreview.src = e.target.result;
            selectPicture('loaded');
        };

        reader.readAsDataURL(file);
    }

    selectPicture('current');
});
</script>






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

              <DIV class="f80"><B>Short Campaign Statement</B></DIV>                                 
              <STYLE><?php require $_SERVER["DOCUMENT_ROOT"] . "/../libs/utils/External_Pell/dist/pell.min.css"; ?></STYLE>

              <div class="">              
                <div class="field field-full">
                  <div id="editor" class="pell pell-input"></div>
                </DIV>
              </DIV>

              <DIV><button type="submit" class="submitred"><?= $StatusMessage ?></button></DIV>

              <HR> 
              <DIV class="f80"><B>Political persuasion</B></DIV>
               
              <DIV class="f60"><B>What caucus would you join if elected?</B></DIV>

              <div class="button2-group" style="padding-top: 10px; padding-bottom: 15px;">
                <button type="button" class="button2  caucus-btn" data-caucus="dem">Democrat</button>
                <button type="button" class="button2  caucus-btn" data-caucus="gop">Republican</button>
                <button type="button" class="button2  caucus-btn" data-caucus="trp">Third Party</button>

              </div>

              <div id="caucus-container">
                <div id="caucus-top" class="caucus-row">
                  <img class="caucus-candidate" id="cpc" data-party="cpc" alt="Congressional Progressive Caucus" src="/shared/teams/progressive/Progressive.png">
                  <img class="caucus-candidate" id="ndc" data-party="ndc" alt="New Democrat Coalition" src="/shared/teams/newdemcoal/NewDemCoal.png">
                  <img class="caucus-candidate" id="blu" data-party="blu" alt="Blue Dog Coalition" src="/shared/teams/bluedogs/BlueDogs.png">
                  <img class="caucus-candidate" id="rgg" data-party="rgg" alt="Republican Governance Group" src="/shared/teams/repgovern/RepGovern.png">
                  <img class="caucus-candidate" id="msd" data-party="msd" alt="Main Street Caucus" src="/shared/teams/mainstreet/MainStreet.png">
                  <img class="caucus-candidate" id="rsc" data-party="rsc" alt="Republican Study Committee" src="/shared/teams/studycom/StudyCom.png">
                  <img class="caucus-candidate" id="fre" data-party="fre" alt="Freedom Caucus" src="/shared/teams/freedom/Freedom.png">
                </div>
              </DIV>

              <DIV class="f60" style="padding-top: 25px;"><B>Your political persuasion</B></DIV>

              <div style="padding-top: 0px; padding-bottom: 15px;" class="f40">
                Select the political persuasion that fits your belief system. <BR>
                <A TARGET="persuation" HREF="/web/toplinks/about#tendencies">For detailed information about political tendencies</A>.
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

              <div id="party-container">
                <div id="party-top" class="party-row">
                  <img class="persuasion-candidate" id="pir" data-party="pir" alt="Pirate" src="/shared/teams/pirates/Pirate.png">
                  <img class="persuasion-candidate" id="ipa" data-party="ipa" alt="International People's Party" src="/shared/teams/ipa/ipa.png">
                  <img class="persuasion-candidate" id="isa" data-party="isa" alt="Socialist Alternative" src="/shared/teams/socalternative/ISAlternative.png">
                  <img class="persuasion-candidate" id="com" data-party="com" alt="Communists" src="/shared/teams/communists/solidnet.png">
                  <img class="persuasion-candidate" id="pri" data-party="pri" alt="Progressive International" src="/shared/teams/proginternational/ProgInternational.png">
                  <img class="persuasion-candidate" id="gre" data-party="gre" alt="Greens" src="/shared/teams/greens/Greens.png">
                  <img class="persuasion-candidate" id="soc" data-party="soc" alt="Socialists" src="/shared/teams/socialists/Socialists.png">
                  <img class="persuasion-candidate" id="pra" data-party="pra" alt="Progressive Alliance" src="/shared/teams/progalliance/ProgAlliance.png">
                </div>
                          
                <div id="party-bottom" class="party-row">
                  <IMG class="persuasion-candidate" ALT="Liberals"  id="lib" SRC="/shared/teams/liberals/LiberalInternational.png">
                  <IMG class="persuasion-candidate" ALT="Christian Democrats"  id="cdu"  SRC="/shared/teams/christiansdemocrats/IDC.png">
                  <IMG class="persuasion-candidate" ALT="Libertarians"  id="lbt"  SRC="/shared/teams/libertarians/Libertarian.png">
                  <IMG class="persuasion-candidate" ALT="Democratic Union"  id="idu"  SRC="/shared/teams/democrats/IDU.png">
                  <IMG class="persuasion-candidate" ALT="Indentity and Democracy"  id="con" SRC="/shared/teams/identity/Conservatives.png">
                </div>
              </div>       
                            
              <input type="hidden" name="SelectedParty" id="SelectedParty">
              <input type="hidden" name="SelectedCaucusMask" id="SelectedCaucusMask">
              <input type="hidden" name="SelectedCaucusParty" id="SelectedCaucusParty">
              <textarea name="CandidateProfileBio" id="campaign-html" hidden></textarea>

              <div id="party-tooltip"></div>

               <DIV style="padding-top: 15px;padding-bottom: 10px;"><button type="submit" class="submitred"><?= $StatusMessage ?></button></DIV>
              <HR>   
              
              <?php /*                 
              <div class="f80"><B>Endorsement Screen</B></div>                   
              <div class="f60">
                <INPUT TYPE="CHECKBOX" NAME="EndorseOption" VALUE="yes"<?php if ($rmbcandidate["CandidateProfile_PublishProfile"] == 'yes') { echo " CHECKED"; } ?>>&nbsp;
                <B>Select this option</B> if you are interested in applying for endorsements from organizations that share your values directly through the Rep My Block website.
              </div>

              <div class="f60">
                You will be provided with a list of organizations, based on their IRS tax status, whose values you may promote or which may choose to endorse you.
              </div>

              <div><button type="submit" class="submitred"><?= $StatusMessage ?></button></div>
               
              <HR>
              */ ?>              

              <DIV class="f80"><B>Upload your PDF platform</B></DIV>
              <DIV><I>(Max file size 1 Mb.)</I></DIV>
              <DIV>
                <INPUT type="file" name="pdfplatform">
                <INPUT type="hidden" name="oldpdfname" value="<?= $rmbcandidate["CandidateProfile_PDFFileName"] ?>">
              </DIV>
              <?php if (! empty ($rmbcandidate["CandidateProfile_PDFFileName"])) { ?>
              <DIV>                                       
                <B><A HREF="/shared/platforms/<?= $rmbcandidate["CandidateProfile_PDFFileName"] ?>" TARGET="Platform">Download PDF platform</A></B>                       
                <div id="demo-basic">
                  <embed src="/shared/platforms/<?= $rmbcandidate["CandidateProfile_PDFFileName"] ?>" width="500" height="600" type="application/pdf">
                </div>                  
              </DIV>
              <?php } ?>     
              <DIV><button type="submit" class="submitred"><?= $StatusMessage ?></button></DIV>


              <HR> 
              <DIV class="f80"><B>Social Media</B></DIV>

              <div class="field">
                <input id="Twitter" type="text" class="input" name="Twitter" value="<?= htmlspecialchars($rmbcandidate["CandidateProfile_Twitter"]) ?>" placeholder=" ">
                <label for="Twitter">Twitter</label>
              </div>                  

              <div class="field">
                <input id="BlueSky" type="text" class="input" name="BlueSky" value="<?= htmlspecialchars($rmbcandidate["CandidateProfile_BlueSky"]) ?>" placeholder=" ">
                <label for="BlueSky">BlueSky</label>
              </div>                         

              <div class="field">
                <input id="Truth" type="text" class="input" name="Truth" value="<?= htmlspecialchars($rmbcandidate["CandidateProfile_Truth"]) ?>" placeholder=" ">
                <label for="Truth">Truth</label>
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
                <input id="LinkedIn" type="text" class="input" name="LinkedIn" value="<?= htmlspecialchars($rmbcandidate["CandidateProfile_LinkedIn"]) ?>" placeholder=" ">
                <label for="LinkedIn">LinkedIn</label>
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

              <DIV class="f40">
                All of the fields on this page are optional and can be deleted at any
                time, and by filling them out, you're giving us consent to share this
                data wherever your user profile appears. Please see our
                <a HRef="https://github.com/site/privacy">privacy statement</a>
                to learn more about how we use this information.
              </DIV>
            </FORM>
          </DIV>
        </DIV>
      </DIV>
    </DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>
  
                  
    <STYLE> 
    .pell-input {
      min-height: 200px;
      padding: 18px 12px 12px;
      font-size: 16px;
      line-height: 1.5;
     
      border: 2px solid #4f5bd5;
      border-radius: 4px;
      background: #fff;
      box-sizing: border-box;
    }

    /* Toolbar border match */
    .pell-actionbar {
      border-bottom: 1px solid #4f5bd5;
    }
      
    /* Focus state */
    .pell-input:focus-within {
      outline: none;
      box-shadow: 0 0 0 1px #4f5bd5;
    }

    .field-full {
      max-width: 100%;
      width: 100%;
    }

    /* Ensure editor itself fills container */
    .field-full .pell-input {
      width: 100%;
    }
    </STYLE>

    <SCRIPT>
      const SAVED_SELF_ASS   = <?= json_encode($rmbcandidate["CandidateProfile_PolSelfAss"]) ?>;
      const SAVED_SELF_PARTY = <?= json_encode($rmbcandidate["CandidateProfile_PolSelfParty"]) ?>;
      const SAVED_SELF_CAUCUS= <?= json_encode((int)$rmbcandidate["CandidateProfile_PolSelfCaucus"]) ?>;
      <?php require $_SERVER["DOCUMENT_ROOT"] . "/../libs/utils/External_Pell/dist/pell.min.js"; ?>
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/js/pell_definedupdateprofile.js";  ?>
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/js/districtposition.js";  ?>
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/js/caucuschooser.js";  ?>
    </script>
  </BODY>
</HTML>