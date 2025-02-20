<?php
	$MaxPDFSize = 1250000;
	$MaxPicSize = 1250000;

  $Menu = "vendors";  
	$BigMenu = "vendors";
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_vendors.php";  
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  $rmb = new vendors();  
  
  // Put the POST HERE because we need to reread the data 
  if ( ! empty ($_POST)) {  
  	WriteStderr($_POST, "POST");
  	  	
  	$rmb->SaveVendorPitch(
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
													)) . "/lgd/vendors/update");
    exit();
  }
  
  $rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);
  WriteStderr($rmbperson, "rmbperson array");
    
	$rmbvendor = $rmb->listvendors($rmbperson["SystemUser_ID"]);
  WriteStderr($rmbvendor, "rmbvendor array");

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
            <h2 id="public-profile-heading" class="Subhead-heading">Update Vendor Profile</h2>
          </DIV>
          <?php  PlurialMenu($k, $TopMenus);  ?>
          <DIV class="clearfix gutter d-flex flex-sHRink-0">
            <DIV class="row">
              <DIV class="main">
                <FORM ACTION="" METHOD="POST" ENCTYPE="multipart/form-data">
                	              
                	<P class="f80">         
                    <B><?= $ProfileDisplayName ?></B>
                  </P>      
                	        
                	              
                	 <P class="f40">
                    This vendor profile will be available on the vendor page of the Rep My Block website.
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
           
                    <DL class="f40">
                      <DT><LABEL>Vendor Name</LABEL></DT>
                      <DD><INPUT class="form-control" type="text" name="VendorName" placeholder="Your Company Name" value="<?= $ProfileVendorName ?>"></DD>
                    </DL>
                    
                    
                     <DL class="f40">
                      <DT><LABEL>Your Sales Pitch</LABEL></DT>
                      <DD class="">
                        <TEXTAREA ROWS=10 cols=60 class="form-control" placeholder="Tell us a little bit about yourself" name="VendorPitch"><?= $ProfileVendorPitch ?></TEXTAREA>
                      </DD>
                    </DL> 
           
                      
                    <DL class="f40">
                      <DT><LABEL>Vendor Website</LABEL> (add https:// to the URL)</DT>
                      <DD><INPUT class="form-control" type="text" placeholder="https://" name="URL" value="<?= $ProfileVendorURL ?>"></DD>
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