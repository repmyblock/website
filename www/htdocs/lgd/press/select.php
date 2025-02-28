<?php
	$MaxPDFSize = 1250000;
	$MaxPicSize = 1250000;

  $Menu = "press";  
	#$BigMenu = "press";
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_press.php";  
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  $rmb = new press();  
  
  // Put the POST HERE because we need to reread the data 
  if ( ! empty ($_POST)) {  
  	WriteStderr($_POST, "POST");
  	  	
  	 
  	  	
  	$rmb->SavePressPreferences(
  								$URIEncryptedString["SystemUser_ID"], $_POST["VendorID"],
  								htmlspecialchars($_POST["VendorName"]),
  								htmlspecialchars($_POST["VendorPitch"]),
  								htmlspecialchars($_POST["URL"])
  					);
  					
  					
  				
    header("Location: /" . CreateEncoded (
													array( 
														"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
														"FirstName" => $URIEncryptedString["FirstName"],	
														"LastName" => $URIEncryptedString["LastName"],	
														"EDAD" =>  $URIEncryptedString["EDAD"], 
														"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],	
														"ErrorMsg" => "Success"
													)) . "/lgd/press/select");
    exit();
  }
  
  $rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);
  WriteStderr($rmbperson, "rmbperson array");
    
	$rmblisttypenotif = $rmb->listnotifications(PERM_MENU_PRESS);
	WriteStderr($rmblisttypenotif, "rmblisttypenotif array");
	
	$rmbnotifforuser = $rmb->listnotifications($rmbperson["SystemUser_ID"]);
  WriteStderr($rmbnotifforuser, "rmbnotifforuser array");

  $StatusMessage = "Save profile";
  
  if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}  
  $Party = PrintParty($UserParty);
  
  if ( ! empty ($rmbvendor)) {
  	
  	$ProfileDisplayID = $rmbvendor[0]["Vendor_ID"];
	 	$ProfileDisplayName = $rmbvendor[0]["Vendor_Name"];
    $ProfileVendorName = $rmbvendor[0]["Vendor_Name"];
  	$ProfileVendorPitch = $rmbvendor[0]["Vendor_Pitch"];
   	$ProfileVendorURL = $rmbvendor[0]["Vendor_URL"];
    
  }
  
  
  /*
  if ($rmbperson["SystemUser_emailverified"] == "both") {                
    $TopMenus = array (
            array("k" => $k, "url" => "profile/user", "text" => "Public Profile"),
            array("k" => $k, "url" => "profile/profilevoter", "text" => "Voter Profile"),
            array("k" => $k, "url" => "profile/profilecandidate", "text" => "Candidate Profile"),
            array("k" => $k, "url" => "profile/profileteam", "text" => "Team Profile")
    );                
  } 
  */             

  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
  if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>
    <DIV class="row">
      <DIV class="main">
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
        <DIV class="<?= $Cols ?> float-left">
      
          <!-- Public Profile -->
          <DIV class="Subhead mt-0 mb-0">
            <h2 id="public-profile-heading" class="Subhead-heading">Update Report Notification Screen</h2>
          </DIV>
          <?php  PlurialMenu($k, $TopMenus);  ?>
          <DIV class="clearfix gutter d-flex flex-sHRink-0">
            <DIV class="row">
              <DIV class="main">
                <FORM ACTION="" METHOD="POST" ENCTYPE="multipart/form-data">
                	              
                	<P class="f80">         
                    <B><?= $ProfileDisplayName ?></B>
                  </P>      
                	        
                	              
                	 <P class="f80">
                    Current reports available to signup.
                  </P>
                  
                  <?php if ($URIEncryptedString["ErrorMsg"] == "Success") { ?>
                  	<P>
                  		<B><FONT COLOR="GREEN">Success, the vendor profile is saved</B></FONT><BR> 
                  		The vendor profile is visible at
                  		<B><A TARGET="NEWPROFILE" HREF="<?= $FrontEndWebsite ?>/vendors"><?= $FrontEndWebsite ?></A></B>.
                  	
                  	</P>
                  	
                  	
                  <?php	} ?>
                	      
                  <DIV>
                  	
                  	<INPUT TYPE="hidden" NAME="VendorID" VALUE="<?= $ProfileDisplayID ?>">
									<P>
										<UL>
                    	<INPUT TYPE="checkbox"> Candidate for NYC registering <I>(As it happens)</I>
                  	</UL>
                  </P> 
                     
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