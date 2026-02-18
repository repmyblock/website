<?php
  $Menu = "profile";  
  $BigMenu = "profile";
   
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
      
  if (! empty ($_POST)) {
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
          ["k" => $k, "url" => "profile/user", "text" => "Public Profile"],
          ["k" => $k, "url" => "profile/voter/card", "text" => "Voter Profile"], 
          ["k" => $k, "url" => "profile/candidate/public", "text" => "Candidate Profile"],
          ["k" => $k, "url" => "profile/team/section", "text" => "Team Profile"]
     ];                
  }              

  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
  echo "<STYLE>";
  require $_SERVER["DOCUMENT_ROOT"] . "/../libs/utils/External_Croppie/croppie.css";
  echo "</STYLE>";
  if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
  
  $PicturePath = "/shared/pics/" . $URIEncryptedString["PicPath"] . "/TMP_" . $URIEncryptedString["PicName"];
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
      <?php require $_SERVER["DOCUMENT_ROOT"] . "/js/croppie.js"; ?>
    </SCRIPT>
  </BODY>
</HTML>