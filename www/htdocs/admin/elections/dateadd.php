<?php
  if ( ! empty ($k)) { $MenuLogin = "logged"; }
  $Menu = "admin";
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
   require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_admin.php"; 
 
  if ( empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}  
  
  $rmb = new RMBAdmin();  
  $rmbstates = $rmb->ListStates();
  $rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
  // $rmbdate = $rmb->ListElectionsDates(NULL, NULL, NULL, NULL, $URIEncryptedString["Elections_ID"])[0];
  
  WriteStderr($rmbdate, "Date Table");
  
  if (! empty($_POST)) {
    // Need to add or update depending.
    
    $NewElectionDate = ToMysqlDate(($_POST["Election_Date"] != $_POST["Election_Date_Orig"]) ? $_POST["Election_Date"] : null);
    $NewElectionsText = ($_POST["Election_Text"] != $_POST["Election_Text_Orig"]) ? $_POST["Election_Text"] : null;
    $NewStateID = ($_POST["Election_StateID"] != $_POST["Election_StateID_Orig"]) ? $_POST["Election_StateID"] : null;
    $NewElectionType = ($_POST["Election_Type"] != $_POST["Election_Type_Orig"]) ? $_POST["Election_Type"] : null;

    if ($NewElectionDate == null || $NewElectionsText == null || $NewStateID == null || $NewElectionType == null) {
      $URIEncryptedString["ErrorMsg"] = "<FONT COLOR=BROWN><B>Missing one date</B></FONT>";
    } else {
      $rmb->AddElectionDates($NewElectionsText,  $NewElectionDate, $NewStateID, $NewElectionType);
      
      header("Location: /" .  CreateEncoded ( array( 
                    "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],  
                    "SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"]
            )) . "/admin/elections/datemgmt");
      exit();
    }
  }
  
  $ButtonText = "Update Date";
  $FormFieldParty = $URIEncryptedString["UserParty"];

/*
  if ( ! empty ($result["CandidatePositions_Name"])) { $FormFieldPositionName = $result["CandidatePositions_Name"]; }
  if ( ! empty ($result["CandidateElection_DBTable"])) { $FormFieldDBTable = $result["CandidateElection_DBTable"]; }
  if ( ! empty ($result["CandidatePositions_State"])) { $FormFieldState = $result["CandidatePositions_State"];  }
  if ( ! empty ($result["CandidatePositions_Order"])) { $FormFieldPosition = $result["CandidatePositions_Order"]; }
  if ( ! empty ($result["CandidatePositions_Explanation"])) { $FormFieldExplanation = $result["CandidatePositions_Explanation"]; }
  if ( ! empty ($result["CandidatePositions_Type"])) { $FormFieldType = $result["CandidatePositions_Type"]; }
*/
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>
    <div class="row layout">
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
      <div class="main">
        <div class="col-full">
          <div class="Subhead">
            <h2 class="Subhead-heading">Election Add New Date</h2>  
<?php 
        if ($VerifEmail == true) { 
          include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_emailverif.php";
        } else if ($VerifVoter == true) {
          include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_voterinfo.php";
        } 
?>
<?php if (! empty ($URIEncryptedString["ErrorMsg"])) {
          echo "<FONT COLOR=BROWN SIZE=+1><B>" . $URIEncryptedString["ErrorMsg"] . "</B></FONT>";
          echo "<BR><BR>";  
} ?>  
            <B>Edit elections dates</B>
                  
            <div class="col-12">
              <form class="" id="" action="" accept-charset="UTF-8" method="post">
              	
              	  
				              	
           		  <DIV style="padding: 0px 10px 10px 0px">
           		  	
             
 	
					        <div class="field" style="--field-height: 20px">
					        	
         		  	 <input type="hidden" name="Election_Text_Orig" VALUE="<?= $rmbdate["Elections_Text"] ?>">
           		 
					          <input id="ElectionText" type="text" name="Election_Text" required placeholder=" ">
					         
					          <label for="ElectionText">Election Text Description</label>
					          <fieldset>
					            <legend><span>Election Text Description</span></legend>
					          </fieldset>
					        </div>
				        </DIV>
               
                 <DIV style="padding: 0px 10px 10px 0px">
                 	   <input type="hidden" name="Election_Date_Orig" VALUE="<?= $rmbdate["Elections_Date"] ?>">
					       
					        <div class="field" style="--field-height: 20px">
					          <input id="ElectionDate" type="text" name="Election_Date" required placeholder=" ">
					          <label for="ElectionDate">Election Date</label>
					          <fieldset>
					            <legend><span>Election Date</span></legend>
					          </fieldset>
					        </div>
				        </DIV>

                   
                <div style="padding: 0px 10px 10px 0px">
                 <label for="user_profile_name">Position State</label>
                      <SELECT class="" NAME="Election_StateID">
                        <OPTION VALUE="">&nbsp;</OPTION>
<?php if (! empty ($rmbstates)) {
            foreach ($rmbstates as $state) {
              if (! empty ($state)) {  ?>
                        <OPTION VALUE="<?= $state["DataState_ID"] ?>"<?php if ( $rmbdate["DataState_Abbrev"] == $state["DataState_Abbrev"] ) { echo " SELECTED"; } ?>><?= $state["DataState_Name"] ?></OPTION>
<?php     }
        }
      } ?>
                      </SELECT>
                      <input type="hidden" name="Election_StateID_Orig" VALUE="<?= $rmbdate["DataState_ID"] ?>">

									</DIV>
                            
                  <DIV  style="padding: 0px 10px 10px 0px" >
                    <label for="user_profile_name">Election Type</label>
                    
                      <SELECT class="" NAME="Election_Type">
                        <OPTION VALUE="">&nbsp;</OPTION>
                        <OPTION VALUE="primary"<?php if ($rmbdate["Elections_Type"] == "primary") { echo " SELECTED"; } ?>>Primary</OPTION>
                        <OPTION VALUE="general"<?php if ($rmbdate["Elections_Type"] == "general") { echo " SELECTED"; } ?>>General</OPTION>
                        <OPTION VALUE="special"<?php if ($rmbdate["Elections_Type"] == "special") { echo " SELECTED"; } ?>>Special</OPTION>
                        <OPTION VALUE="runoff"<?php if ($rmbdate["Elections_Type"] == "runoff") { echo " SELECTED"; } ?>>Runoff</OPTION>
                        <OPTION VALUE="other"<?php if ($rmbdate["Elections_Type"] == "other") { echo " SELECTED"; } ?>>Other</OPTION>                  
                      </SELECT>
                      <input type="hidden" name="Election_Type_Orig" VALUE="<?= $rmbdate["Elections_Type"] ?>">
                  
                 
                </DIV>
                <p><button type="submit" class="submitred">Update election dates</button></p>
                
              </form> 
            </div>
          </div>
        </DIV>
      </div>
    </DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>
  </BODY> 
</HTML>