<?php
  $Menu = "profile";  
	$BigMenu = "profile";
  
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
        $structure = $GeneralUploaDDir . "/shared/pics/" . $md5structure . "/";
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
        $structure = $GeneralUploaDDir . "/shared/platforms/" . $md5structure . "/";
        mkdir($structure, 0777, true);
        $PDFFilePath = $md5structure . "/" . $PDFFilename;
        print "PicFilePath: " . $PDFFilePath . "<BR>";
        if (! move_uploaded_file($_FILES['pdfplatform']['tmp_name'], $structure . $PDFFilename)) {
            $error_msg = "Problem uploading the pdf file";
        }
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
                <FORM ACTION="" METHOD="POST">

                  <P CLASS="f40">
                    This profile will be presented to every person that visits the Rep My Block website. You 
                    will be able to publish a two-page PDF of your platform that will be used to create a voter 
                    booklet that a voter will download and email.
                  </P>
      
                  <P>         
                    <B><?= $rmbcandidate["Candidate_DispName"]; ?></B>
                  </P>
         
                  <DIV>
            
                    <DL class="f40">       
                      <DT><LABEL>First Name</LABEL></DT>
                      <DD>
                        <INPUT class="form-control" type="text" placeholder="First Name" name="FirstName" value="<?= $rmbcandidate["CandidateProfile_FirstName"]; ?>">
                      </DD>
                    </DL>
                      
                    <DL class="f40"> 
                      <DT><LABEL>Last Name</LABEL><DT>
                      <DD>
                        <INPUT class="form-control" type="text" placeholder="Last Name" name="LastName" value="<?= $rmbcandidate["CandidateProfile_LastName"]; ?>">
                      </DD>
                    </DL>
                      
                    <DL class="f40">
                      <DT><LABEL>Public Facing Name</LABEL></DT>
                      <DD><INPUT class="form-control" type="text" placeholder="Your name to be displayed publicly" name="FullName" value="<?= $rmbcandidate["CandidateProfile_Alias"]; ?>"></DD>
                    </DL>
                      
                    <DL class="f40">
                      <DT><LABEL>Upload your picture</LABEL></DT>
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
                    
                      
                    <p><button type="submit" class="submitred">Update profile</button></p>

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