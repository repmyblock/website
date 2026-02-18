<?php
  $Menu = "profile";
  $BigMenu = "profile";

  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
  // WriteStderr($DebugInfo, "RepMyBlock");  
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php";
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  
  $FoundUserInTeam = 0; // This is to print in case I don't find a team.
  $FoundPublicCampaign = 0;
  
  $rmb = new Teams();
  if ( ! empty ($_POST)) {
        
    $Encrypted_URL = $Decrypted_k;
    foreach ($_POST["PositionRunning"] ?? [] as $var) {
      $Encrypted_URL .= "&Position[]=" . $var;
    }
    
    WriteStderr($_POST, "Post in ProfileTeam.php");
    // This is to remove the users
    if ( ! empty ( $_POST["TeamIDRmval"])) {
      foreach ($_POST["TeamIDRmval"] as $var) {
        $rmb->UpdateVolunteerTeam('no', $var, $URIEncryptedString["SystemUser_ID"], "Removed by self");
      }
    }

    // This is to add the users
    if ( ! empty ( $_POST["TeamIDAddtion"])) {
      foreach ($_POST["TeamIDAddtion"] as $var) {
        // function SaveTeamInfo($URIEncryptedString["SystemUser_ID"], $var, $Priv = NULL, $Active = 'yes') {
        $rmb->SaveTeamInfo($URIEncryptedString["SystemUser_ID"], $var, NULL, 'pending');
      }
    }
    
    if (! empty($_POST["TeamCode"])) {    
      $TrimmedAccess = trim($_POST["TeamCode"]);
      $CampaignTeam = $rmb->FindCampaignFromCode($TrimmedAccess);
      WriteStderr($CampaignTeam, "CampaignTeam");
      
      if ( ! empty ($CampaignTeam["Team_URLRedirect"])) {
        header("Location: /" . CreateEncoded ( array( 
                  "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
                  "SuccessMsg" => "1",
                ))  . $CampaignTeam["Team_URLRedirect"]);
        exit();        
      }
      
      if ( $CampaignTeam["Team_AccessCode"] == $TrimmedAccess ) {
        WriteStderr($CampaignTeam, "CampaignTeam: " . $URIEncryptedString["SystemUser_ID"] . " CampaignTema: " . $CampaignTeam["Team_ID"]);      
        $rmb->SaveTeamInfo($URIEncryptedString["SystemUser_ID"], $CampaignTeam["Team_ID"]);
        header("Location: /" . CreateEncoded ( array( 
                  "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
                  "SuccessMsg" => "1",
                ))  . "/lgd/profile/team/section");
      } 
    }
      
    header("Location: /" . CreateEncoded ( array( 
                "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
                "SuccessMsg" => "0",
                "ErrorMsg" => "Could not find access code",
              ))  . "/lgd/profile/team/section");
    exit();
  }

  if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}
  $Party = PrintParty($URIEncryptedString["UserParty"]);

  $rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);
  $rmbteams = $rmb->ListTeamsWithMembers($URIEncryptedString["SystemUser_ID"]);
  //WriteStderr($rmbteams, "Teams List");
  
  $TopMenus = array (
            array("k" => $k, "url" => "profile/user", "text" => "Public Profile"),
            array("k" => $k, "url" => "profile/voter/card", "text" => "Voter Profile"), 
            array("k" => $k, "url" => "profile/candidate/public", "text" => "Candidate Profile"),
            array("k" => $k, "url" => "profile/team/section", "text" => "Team Profile")
          );
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
  if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
  
?>
	<div class="row layout">
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
      <div class="main">
        <div class="col-full">
          <div class="Subhead">
            <h2 class="Subhead-heading">Team Profile</h2>
          </div>

          <?php  PlurialMenu($k, $TopMenus);  ?>  
          
          <div class="f60" STYLE="padding: 10px 0px;">
            <B><FONT COLOR=BROWN>If you are part of a team, your team leader will supply you a code</FONT></B>
          </DIV>

          <DIV class="clearfix gutter d-flex">

            <FORM ACTION="" METHOD="POST">
              <div class="voter-form">
                <div class="field" style="grid-column: span 6;">
                  <input id="TeamCode" class="input" type="text" name="TeamCode" <?php if (!empty ($TeamCode)) { echo " VALUE=" . $TeamCode; } ?> placeholder=" ">
                  <label for="TeamCode">Team Code</label>
                </div>
              </DIV>
              
              <DIV class="">
                <INPUT class="f60bold" TYPE="Submit" NAME="SaveInfo" VALUE="Apply the Team Code">
              </DIV>

              <div class="f80bold" STYLE="padding: 10px 0px;">Teams</div>
<?php       
          if ( ! empty ($rmbteams)) {
            foreach ($rmbteams as $var) {
              if ( $var["SystemIDFromTeam"] == $URIEncryptedString["SystemUser_ID"]) {
                if ( $var["TeamMember_Active"] == "yes" || $var["TeamMember_Active"] == "pending") {
                  $FoundUserInTeam = true;
                  $TeamFoundInAssigned[$var["Team_ID"]] = true;
?>    
      
              <DIV>
                <div class="filtered f60">            
                  <INPUT TYPE="CHECKBOX" NAME="TeamIDRmval[]" VALUE="<?= $var["TeamMember_ID"] ?>" style="padding: 10px;">
                  <?= $var["Team_Name"] ?><?php if ($var["TeamMember_Active"] == "pending") { ?> <I>(pending approval)</I><?php } ?>
                </div>
              </DIV>
<?php           }
              }  
            } 

            if ($FoundUserInTeam == true) { 
?>
              <DIV STYLE="padding: 20px 0px ;">
                <INPUT class="f60bold" TYPE="Submit" NAME="SaveInfo" VALUE="Remove me from the selected campaigns">
              </div>
<?php       }
          } 
         
          if ($FoundUserInTeam == false) { 
?>
              <DIV>
                <div class="filtered f60" style="padding-left: 20px;">
                  You don't belong to any team.
                </div>
              </DIV>             
<?php     } ?>     
         
              <div class="f80bold" STYLE="padding: 10px 0px;">Campaigns Seeking Voluteers</div>
        
<?php       
          if ( ! empty ($rmbteams)) {
            foreach ($rmbteams as $var) {
              if ( (empty ($var["SystemIDFromTeam"]) &&  $var["Team_Public"] == "public") || $var["TeamMember_Active"] == "no") {               
              	if ( $TeamFoundInAssigned[$var["Team_ID"]] != true) { 	              
	               	$TeamToPrint[$var["Team_ID"]] = $var["Team_Name"];
  	           	}
          	 	}
          	}
           
           	foreach ($TeamToPrint as $teamvalue => $teamname) {
           		$FoundPublicCampaign = true;
?>
              <DIV>
                <div class="filtered f60">
                  <INPUT TYPE="CHECKBOX" NAME="TeamIDAddtion[]" VALUE="<?= $teamvalue ?>" style="padding: 10px;">    
                  <?= $teamname ?>
                </div>
              </DIV>
<?php      
        		}
        	
           
        	if (  $FoundPublicCampaign == true ) { 
?>
            <DIV STYLE="padding: 10px 0px ;">
              <INPUT class="f60bold" TYPE="Submit" NAME="SaveInfo" VALUE="Request information from selected campaigns">
            </div>
<?php   	}  
        
      	} 
        if (  $FoundPublicCampaign == false ) { 
?>
               <DIV>
                 <div class="filtered f60" style="padding-left: 20px;">
                   There aren't any campaign seeking volunteers.
                 </div>
               </DIV> 
<?php   } ?>   

            </FORM>
          </DIV>
        </DIV>
      </DIV>
    </DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>
  </BODY>
</HTML>