<?php
  $Menu = "profile";  
  $BigMenu = "profile";
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
  $rmb = new repmyblock(); 
  if (! empty ($_POST)) {
    
    if ( $_POST["unhidde"] == 'yes') {
      $rmb->PublicProfileToggle(CandidateID: $URIEncryptedString["Candidate_ID"], flag: 'yes');      
    }
   
    header("Location: updatecandidateprofile");
  }
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
   
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
          <DIV class="clearfix gutter d-flex ">
    
            <FORM ACTION="" METHOD="POST">
                
              <DIV class="f80">
                <B>Once the profile is public, there is no hidding it.</B>
              </DIV>

              <P class="f60">
                 You will be able to change the content on the voter guide but won't be able to hide it back.
                 Any change in the profile will be immediatelly reflected in the voter guide.
              </P>
              
              <P class="f80">
                Check this box to indicate you understand the profile will be public: <INPUT TYPE="checkbox" NAME="unhidde" value='yes'>
              </P>
            
              <P class="f60"><button type="submit" class="submitred">Make Profile Public</button></p>                
          
              <DIV class="f80">
                 <B><A HREF="updatecandidateprofile">Return to the profile without making it public</A></B>
              </DIV>

              <P class="f60">
                <B>This profile will be presented to every person that visits the Rep My Block website.</B> You 
                will be able to upload a one-page PDF of your platform that will be used to create a voter 
                booklet that a voter will download and email.
              </P>
            </FORM>
                
          </DIV>
        </DIV>
      </DIV>
    </DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>

  </BODY>
</HTML>