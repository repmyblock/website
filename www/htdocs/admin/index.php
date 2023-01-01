<?php
	$Menu = "admin";
	$BigMenu = "represent";	

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	

	// Reset
	WriteStderr($URIEncryptedString, "Before URIEncryptedString");
	$TempSysID = $URIEncryptedString["SystemUser_ID"];
	$TempMenuDesc = $URIEncryptedString["MenuDescription"];
	$TempSystemAdmin = $URIEncryptedString["SystemAdmin"];
	$URIEncryptedString = array("SystemUser_ID" => $TempSysID, "MenuDescription" => $TempMenuDesc, "SystemAdmin" => $TempSystemAdmin );
	WriteStderr($URIEncryptedString, "After URIEncryptedString");

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
 
  <dl class="form-group">
	 		<A HREF="/<?= $k ?>/admin/userlookup" class="mobilemenu">RepMyBlock User</A><BR>	
 			<A HREF="/<?= $k ?>/admin/team">Team Member Management</A><BR>
 			<A HREF="/<?= $k ?>/admin/team_list">Team Setup</A><BR>
 			<A HREF="/<?= $k ?>/admin/voterlookup">Voter Lookup</A><BR>
  		<A HREF="/<?= $k ?>/admin/track">Petitions Tracker</A><BR>	
  		<A HREF="/<?= $k ?>/admin/setup_candidate">Candidates Maintenance</A><BR>	
  		<A HREF="/<?= $k ?>/admin/setup_petitionset">Petition Set Maintenance</A><BR>	
  		<A HREF="/<?= $k ?>/admin/setup_positions">Position Maintenance</A><BR>	
  		<A HREF="/<?= $k ?>/admin/setup_petitions">Petition Maintenance</A><BR>	
  		<A HREF="/<?= $k ?>/admin/integrity_verif">Verify Data Integrity</A><BR>	
 	 		<A HREF="/<?= $k ?>/admin/stats">Stats</A><BR>	
    </dd>
  </dl>

</DIV>
</DIV>
</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>