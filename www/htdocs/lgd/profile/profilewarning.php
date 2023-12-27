<?php
  $Menu = "profile";  
	$BigMenu = "profile";
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
  $rmb = new repmyblock(); 
  if (! empty ($_POST)) {
  	
  	if ( $_POST["unhidde"] == 'yes') {
  		echo "I am here";
  		$rmb->updatecandidateprofile($URIEncryptedString["CandidateProfileID"], array("Private" => 'yes'));		
  	}
  	
  	header("Location: updatecandidateprofile");
  
  }
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
   
  $rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);
  WriteStderr($rmbperson, "rmbperson array");
  
  	            
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
             	 		
              
              	<DIV>
              		<P class="f80">
                 		<B>Once the profile is public, there is no hidding it.</B>
                  </P>
              	</DIV>

              		<P class="f60">
               			You will be able to change the content on the voter guide but won't be able to hide it back.
               			Any change in the profile will be immediatelly reflected in the voter guide.
                  </P>
                  
                 <P class="f80">
                  Check this box to indicate you understand the profile will be public: <INPUT TYPE="checkbox" NAME="unhidde" value='yes'>
                </P>
              	
              	<P class="f60"><button type="submit" class="submitred">Make Profile Public</button></p>                
              
							

								<DIV>
              		<P class="f80">
                 	</B><A HREF="updatecandidateprofile">Return to the profile without making it public</A></B>
                  </P>
              	</DIV>


                

 								<P class="f60">
                    <B>This profile will be presented to every person that visits the Rep My Block website.</B> You 
                    will be able to upload a one-page PDF of your platform that will be used to create a voter 
                    booklet that a voter will download and email.
                  </P>
      
 
               
                   </DiV>
      
						      
                 
                      
                    
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