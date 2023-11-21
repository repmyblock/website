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
<div class="row">
  <div class="main">
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>

<div class="col-9 float-left">

	<div class="Subhead">
  	<h2 class="Subhead-heading">Admin Menu</h2>
	</div>
	
	<?php 
		if ($VerifEmail == true) {
			include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_emailverif.php";
		} else if ($VerifVoter == true) {
			include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_voterinfo.php";
		} 
	?>
 
 	<P CLASS="f40">
 		<UL>
	 		<A HREF="/<?= $k ?>/admin/userlookup" class="mobilemenu">RepMyBlock User</A><BR>	
 			<A HREF="/<?= $k ?>/admin/team" class="mobilemenu">Admin Member Management</A><BR>
 			<A HREF="/<?= $k ?>/admin/team_list" class="mobilemenu">Team Setup</A><BR>
 			<A HREF="/<?= $k ?>/admin/voterlookup" class="mobilemenu">Voter Lookup</A><BR>
 			<A HREF="/<?= $k ?>/admin/partycall" class="mobilemenu">Party Call</A><BR>
 			<A HREF="/<?= $k ?>/admin/setup_elections" class="mobilemenu">Petition Election</A><BR>
 			<A HREF="/<?= $k ?>/admin/signaturecount" class="mobilemenu">Signature Count</A><BR>
  		<A HREF="/<?= $k ?>/admin/track" class="mobilemenu">Petitions Tracker</A><BR>	
  		<A HREF="/<?= $k ?>/admin/setup_candidate" class="mobilemenu">Candidates Maintenance</A><BR>	
  		<A HREF="/<?= $k ?>/admin/setup_petitionset" class="mobilemenu">Petition Set Maintenance</A><BR>	
  		<A HREF="/<?= $k ?>/admin/setup_positions" class="mobilemenu">Position Maintenance</A><BR>	
  		<A HREF="/<?= $k ?>/admin/setup_petitions" class="mobilemenu">Petition Maintenance</A><BR>	
  		<A HREF="/<?= $k ?>/admin/integrity_verif" class="mobilemenu">Verify Data Integrity</A><BR>	
 	 		<A HREF="/<?= $k ?>/admin/stats" class="mobilemenu">Stats</A><BR>	
 	 	</UL>
 	</P>
</DIV>
</DIV>
</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>