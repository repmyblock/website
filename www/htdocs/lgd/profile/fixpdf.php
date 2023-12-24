<?php
  $Menu = "profile";  
	$BigMenu = "profile";
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
  
  if (! empty ($_POST)) {
  	
  	echo "<PRE>" . print_r($_POST, 1) . "</PRE>";
  	echo "<PRE>" . print_r($_FILES, 1) . "</PRE>";
  	
  	header("Location: updatecandidateprofile");
  	
  	exit();
  }
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  $rmb = new repmyblock();  
  
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
              	
              	 <FORM ACTION="" METHOD="POST" ENCTYPE="multipart/form-data">
              	<INPUT TYPE="HIDDEN" NAME="FixPDF">
              	<DIV>
              	<P class="f60">
                                       <B>We are testing the PDF to make sure it can be included into the voter guide.</B>

                   
                  </P>
              	</DIV>
              	
              	
              	<P CLASS="f60">
              		
								<div id="demo-basic">
							 
							 <embed src="/<?= $k ?>/lgd/profile/testmergepdf" width="500" height="600" type="application/pdf">
							 
							</div>
							
							<P class="f60"><A HREF="/<?= $k ?>/lgd/profile/testmergepdf" TARGET="NewPAge">Download test PDF</A></P>


</DiV>




                 

 <P class="f60">
                    <B>This profile will be presented to every person that visits the Rep My Block website.</B> You 
                    will be able to upload a one-page PDF of your platform that will be used to create a voter 
                    booklet that a voter will download and email.
                  </P>
      
 <P class="f60"><button type="submit" class="submitred">Save the PDF</button></p>                
               
                  
      
						      
                 
                      
                    
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