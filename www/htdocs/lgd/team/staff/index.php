<?php
  if ( ! empty ($k)) { $MenuLogin = "logged";  }  
  $Menu = "team";

  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php";
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  
  $rmb = new Teams(0);
  $resultteam = $rmb->ListStaffTeam($URIEncryptedString["SystemUser_ID"]);

  $rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
  $rmbteam = $rmb->ListMyTeam($URIEncryptedString["SystemUser_ID"]);
  WriteStderr($rmbteam, "RMB Team In the Else from the Post");
  
  if ( ! empty ($rmbteam)) {
    foreach ($rmbteam as $var) {
      
      switch($var["TeamMember_Active"]) {
        case "banned": $ShowBannedMenu = 1; break;
        case "declined": $ShowDeclinedMenu = 1; break;
        case "no": $ShowUnsignedMenu = 1; break;
      }
      $ListTeamNames[$var["Team_Name"]] = $var["Team_ID"];
    }  
  }
  
  WriteStderr($ListTeamNames, "List of name");
  WriteStderr($URIEncryptedString, "URIEncryptedString after List of Names");
    
  $TopMenus = [ 
    ["k" => $k, "url" => "team/index", "text" => "Team Members"],
    ["k" => $k, "url" => "team/staff/index", "text" => "Staff Members"],
    ["k" => $k, "url" => "team/petitions/index", "text" => "Manage Petitions"],
  ];
                    
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
  if ( $MobileDisplay == true) {   $Cols = "col-12"; $SizeField = " SIZE=10"; } else { $Cols = "col-9"; }
?>

    <div class="row layout">
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
      <div class="main">
        <div class="col-full">
          <div class="Subhead">
            <h2 class="Subhead-heading">Staff Management</h2>
          </div>

          <?php  PlurialMenu($k, $TopMenus); ?>
          <div class="clearfix gutter">
<?php if ( count ($ListTeamNames) > 1) { ?>
            <DIV class="f40">
              <B>Current Team:</B> <?= $ActiveTeam ?>
          
<?php WriteStderr($ListTeamNames, "List of name inside the code that are not appearing."); ?>


              <FORM ACTION="" METHOD="POST">
                <SELECT  class="mobilebig" NAME="Team_ID">
<?php 
                foreach ($ListTeamNames as $var => $index) {                         
                  if (! empty ($var)) { ?>
                  <OPTION VALUE="<?= $index ?>"<?php if ($ActiveTeam_ID == $index) { echo " SELECTED"; } ?>><?= $var ?></OPTION>
<?php
                  }
                }
?>
                </SELECT>
                <button type="submit" class="submitred">Change Active Team</button>
              </FORM>
            </DIV>
<?php } ?>

            <FORM ACTION="" METHOD="POST">
              <div class="Box">
                <div class="Box-header pl-0">
                  <div class="table-list-filters d-flex">
                    <div class="table-list-header-toggle states flex-justify-start pl-3 f60">Team Members for <B><?= $ActiveTeam ?></B></div>
                  </div>
                </div>
       
                <P>
                  <div class="Box-body  js-collaborated-repos-empty f60">
  
<?php
                  if ( ! empty ($resultteam)) { ?>
                    <TABLE BORDER=1>
                      <TR>
                        <TH>First Name</TH>
                        <TH>Last Name</TH>
                        <TH>Email</TH>  
                        <TH>Active</TH>            
                        <TH>Privileges</TH>
                        <TH>ApprovedDate</TH>
                        <TH>&nbsp;</TH>
                      </TR>
                     
<?php  foreach ($resultteam as $var) { 
        if ( ! empty ($var)) { ?>
                       
                      <TR>
                        <TD><?= $var["SystemUser_FirstName"] ?></TD>
                        <TD><?= $var["SystemUser_LastName"] ?></TD>
                        <TD><?= $var["SystemUserTeamPending_email"] ?></TD>      
                        <TD><?= $var["TeamMember_Active"] ?></TD>      
                        <TD><?= $var["TeamMember_Privs"] ?></TD>      
                        <TD><?= $var["TeamMember_ApprovedDate"] ?></TD>      
                        <TD><A HREF="/<?= MergeEncode(["SystemUserTeamPending_ID" => $var["SystemUserTeamPending_ID"]]) ?>)/lgd/team/staff/updatestaff">Update</A></TD>                     
                      </TR>
<?php              }  
                 } ?>
                    </TABLE>
               
<?php } ?>

                    <P class="f40">
                      <I>Members in red have not been authorized by an admin.</I>
                    </P>  
                  </DIV>           
                </P>
              </div>
            </FORM>
          </div>
        </div>
      </div>
    </DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>
  </BODY>
</HTML>