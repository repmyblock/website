<?php
  $Menu = "admin";
  $BigMenu = "represent";  

  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";  

  // Reset
  WipeURLEncrypted( array("SystemUser_ID", "MenuDescription", "SystemUser_Priv") );
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  if (empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}  

  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 
  $rmb = new repmyblock(0);
  $rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
  WriteStderr($rmbperson, "After SearchUserVoterCard rmbperson");
  
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

    <div class="row layout">
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
      <div class="main">
        <div class="col-full">
          <div class="Subhead">
            <h2 class="Subhead-heading">Admin Menu</h2>
          </div>         

          <div class="col-full f60">
<?php 
    if ($VerifEmail == true) {
      include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_emailverif.php";
    } else if ($VerifVoter == true) {
      include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_voterinfo.php";
    } 
?>
            <UL>
             <A HREF="/<?= $k ?>/admin/userlookup" class="mobilemenu">RepMyBlock User</A><BR>
             <A HREF="/<?= $k ?>/admin/team" class="mobilemenu">Admin Member Management</A><BR>
             <A HREF="/<?= $k ?>/admin/team_list" class="mobilemenu">Team Setup</A><BR>
             <A HREF="/<?= $k ?>/admin/voterlookup" class="mobilemenu">Voter Lookup</A><BR>
             <A HREF="/<?= $k ?>/admin/partycall" class="mobilemenu">Party Call</A><BR>
             <A HREF="/<?= $k ?>/admin/elections/index" class="mobilemenu">Elections Management</A><BR>
             <A HREF="/<?= $k ?>/admin/signaturecount" class="mobilemenu">Signature Count</A><BR>
             <A HREF="/<?= $k ?>/admin/track" class="mobilemenu">Petitions Tracker</A><BR>  
             <A HREF="/<?= $k ?>/admin/candidate/setup" class="mobilemenu">Candidates Maintenance</A><BR>  
             <A HREF="/<?= $k ?>/admin/setup_petitionset" class="mobilemenu">Petition Set Maintenance</A><BR>  
             <A HREF="/<?= $k ?>/admin/setup_positions" class="mobilemenu">Position Maintenance</A><BR>  
             <A HREF="/<?= $k ?>/admin/setup_petitions" class="mobilemenu">Petition Maintenance</A><BR>  
             <A HREF="/<?= $k ?>/admin/elected/list" class="mobilemenu">Elected Maintenance</A><BR>  
             <A HREF="/<?= $k ?>/admin/survey/lists" class="mobilemenu">Survey Information</A><BR>  
             <A HREF="/<?= $k ?>/admin/integrity_verif" class="mobilemenu">Verify Data Integrity</A><BR>  
             <A HREF="/<?= $k ?>/admin/stats" class="mobilemenu">Stats</A><BR>  
            </UL>
          </DIV>
        </DIV>
      </DIV>
    </DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>