<?php
  $Menu = "profile";  
  $BigMenu = "profile";
     
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
  WriteStderr($_POST, "\033[7;35m\033[1;35mENTERING THE FIXPICTURE NORMAL\033[0m\n\n");
      
  if (! empty ($_POST)) {
  	
		WriteStderr($_POST, "\033[7;35m\033[1;35mENTERING THE FIXPICTURE POST\033[0m\n\n");
  	
    if ( empty ($URIEncryptedString["PDFFilePath"])) {
      header("Location: updatecandidateprofile");
      exit();
    } else {
      header("Location: fixpdf");
      exit();
    }
  }
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  $rmb = new repmyblock();  
  
  $rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);
  WriteStderr($rmbperson, "rmbperson array");
                
  if ($rmbperson["SystemUser_emailverified"] == "both") {            
   $TopMenus = [
          ["url" => "profile/user", "text" => "Public Profile"],
          ["url" => "profile/voter/card", "text" => "Voter Profile"], 
          ["url" => "profile/candidate/public", "text" => "Candidate Profile"],
          ["url" => "profile/team/section", "text" => "Team Profile"]
     ];                
  }              

  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
  echo "<STYLE>";
  require $_SERVER["DOCUMENT_ROOT"] . "/../libs/utils/External_Croppie/croppie.css";
  echo "</STYLE>";
  if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
  
  $PicturePath = "/shared/pics/" . $URIEncryptedString["PicPath"] . "/TMP_" . $URIEncryptedString["PicName"];
  
  // Save the picture in the data
  WriteStderr($URIEncryptedString, "Updating Candidate Profile By Fields");
  $rmb->UpdateCandidateProfileByFields(
					CandidateProfile_ID: $URIEncryptedString["CandidateProfileID"], 
					TmpPicFileName: $URIEncryptedString["PicPath"] . "/TMP_" . $URIEncryptedString["PicName"]
 				);

  WriteStderr(null, "Updating done Updating the fields: " . $URIEncryptedString["PicPath"] . "/TMP_" . $URIEncryptedString["PicName"]);  
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
            <INPUT TYPE="HIDDEN" NAME="FixPicture">
            <DIV>
              <P class="f60">
                <B>Please adjust the picture for the guide to enable the picture.</B>               
              </P>
            </DIV>
           
            <DIV CLASS="f60">
              <div id="demo-basic"></div>
            </DIV>
     
            <DIV class="f60">
              <B>This profile will be presented to every person that visits the Rep My Block website.</B> You 
              will be able to upload a one-page PDF of your platform that will be used to create a voter 
              booklet that a voter will download and email.
            </DIV>

            <DIV class="f60">        
              <button id="cropBtn" class="submitred" type="button">Crop & Upload</button>
            </DIV>         
               
          </FORM>      
        </DIV>
      </DIV>
    </DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>
    <SCRIPT>
      <?php require $_SERVER["DOCUMENT_ROOT"] . "/../libs/utils/External_Croppie/croppie.min.js"; ?>
      <?php /* This need to be loaded by PHP and not the browser because there is custom PHP code in the JS */ ?>
      <?php require $_SERVER["DOCUMENT_ROOT"] . "/js/croppie.js"; ?>
    </SCRIPT>
  </BODY>
</HTML>