<?php
  $Menu = "profile";
  $BigMenu = "profile";

  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php";
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  $rmb = new Teams(0);
  
  if ( ! empty ($_POST)) {  
  	
  	if ( empty ($_POST["StaffDelegate"]) || empty (isVerifValidEmail($_POST["StaffDelegate"]))) {	
  		$ErrorMessage[] = "A"; 
  	} 
  	
  	if ( empty ($_POST["positionrunning"]) && empty (trim($_POST["manuposition"]))) { 
  		$ErrorMessage[] = "B"; 
  	}
  	
  	$SetupTeam = true;
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/candprofile_commonsetup.php";

		if (empty ($ErrorMessage)) {		
			// Update and give team access to the team screen
			
			$rmb->UpdateAutoTeam(PERM_MENU_TEAM, $URIEncryptedString["SystemUser_ID"]); 
			header("Location: /" . CreateEncoded([
									  "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
								    "FirstName" => $URIEncryptedString["FirstName"],
								    "LastName" => $URIEncryptedString["LastName"],
								    "PositionID" => $URIEncryptedString["PositionID"],
								    "DataStateID" => $URIEncryptedString["DataStateID"]
							]) . "/lgd/profile/candidate/updatecandidateprofile");                         					   	    
    	exit();
	  }	else {
			header("Location: /" . MergeEncode(['ErrorMessage' => $ErrorMessage]) . "/lgd/profile/candidate/delegate");
    	exit();  	
	  }
  }
  
  if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}
  $rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);
  $rmbpositions = $rmb->ListDBTablesFromPositions($URIEncryptedString["PositionID"]);
  
 
  WriteStderr($rmbperson, "RMBPerson");
  $TopMenus = [
          ["k" => $k, "url" => "profile/user", "text" => "Public Profile"],
          ["k" => $k, "url" => "profile/voter/card", "text" => "Voter Profile"], 
          ["k" => $k, "url" => "profile/candidate/public", "text" => "Candidate Profile"],
          ["k" => $k, "url" => "profile/team/section", "text" => "Team Profile"]
       ];
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
  if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>

    <div class="row layout">
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php";  ?>
      <div class="main">
        <div class="col-full">
          <div class="Subhead">
            <h2 class="Subhead-heading">Candidate Profile</h2>
          </div>
          <?php PlurialMenu($k, $TopMenus); ?>
   
          <DIV class="clearfix gutter d-flex ">
            <FORM ACTION="" METHOD="POST">
      
              <P class="f60">
                <B>Delegate the administration of your profile</B>
              </P>
              
              <?php if ( is_array($URIEncryptedString["ErrorMessage"]) == 1) { ?>
							
							<P class="f60">
                <FONT COLOR=BROWN><B>Error Message</B></FONT>
              	<UL>
              		                            	
              	<?php if (is_numeric(array_search("B", $URIEncryptedString["ErrorMessage"]))) { ?>
	              	<LI CLASS="f60"><B><FONT COLOR=BROWN>You must select the proper district</FONT></B></LI>
	              <?php } ?>
	              
              	<?php if (is_numeric(array_search("A", $URIEncryptedString["ErrorMessage"])))  { ?>            
	              	<LI CLASS="f60"><B><FONT COLOR=BROWN>You must enter a valid email address</FONT></B></LI>
	              <?php } ?>
							
								</UL>      		
              </P>
              		
              <?php	} ?>
              
             	<P class="f60">
              	You must use the email address that your staffer uses for their Rep My Block 
              	profile. <B>If you let your staffer create your profile</B> with their email and 
              	if they leave, you will lose control of your profile.
              </P>
              
              
               
             	<P class="f60">
              	If the district is not listed, please type it in manually. For statewide districts, enter “Statewide.”
              </P>
              
            
							  <div class="field field-select">
							  	
							    <SELECT name="positionrunning" id="positionrunning" class="select">
							      <OPTION VALUE="">-- Select District --</OPTION>
										<OPTION VALUE="MANUAL">It’s not listed</OPTION>
										 <?php if (! empty ($rmbpositions)) {
							      		foreach ($rmbpositions as $var) {
							        if (! empty ($var)) { ?>
							          <OPTION VALUE="<?= $var["CandidateElection_DBTable"] . "-" . $var["CandidateElection_DBTableValue"] ?>">
							            <?= $var["CandidateElection_Text"] ?>
							          </OPTION>
							      <?php } } } ?>
							    </SELECT>
							  </div>

							  <!-- Manual Entry (Hidden by Default) -->
							  <div class="field" id="manualPositionWrapper" style="display:none;">
							    <input type="text" id="manualPositionInput" name="manuposition" class="input" placeholder="Enter district manually">
							    <label for="manualPositionInput">Manual District</label>
							  </div>
              
              <P class="f60">
                <INPUT TYPE="CHECKBOX" NAME="DelegateAdmin" VALUE="yes"<?php if ($rmbcandidate["CandidateProfile_PublishProfile"] == 'yes') { echo " CHECKED"; } ?>>
                Check the box below if you want to delegate full administration of your 
                Rep My Block profile to this administrator.
              </P>

              <div class="field">
                <input id="StaffDelegate" class="input" type="text" name="StaffDelegate" placeholder=" " autocomplete="off">
                <label for="StaffDelegate">Staffer Email</label>
              </div>
                            
              <DIV class="">
                <INPUT class="f60bold" TYPE="Submit" NAME="SaveInfo" VALUE="Delegate profile">
              </DIV>
            </FORM>
          </DIV>
        </DIV>
      </DIV>
    </DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>
		<script>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/js/districtposition.js";  ?>
		</script>
  </BODY>
</HTML>