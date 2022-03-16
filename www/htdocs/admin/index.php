<?php
	$Menu = "admin";
	$BigMenu = "represent";	

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if (empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	

	$rmb = new repmyblock();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
  
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
 			<A HREF="/<?= $k ?>/admin/voterlist">Voter Lookup</A><BR>
  		<A HREF="/<?= $k ?>/admin/track">Petitions Tracker</A><BR>	
  		<A HREF="/<?= $k ?>/admin/setup_candidate">Candidates Maintenance</A><BR>	
  		<A HREF="/<?= $k ?>/admin/setup_positions">Position Maintenance</A><BR>	
  		<A HREF="/<?= $k ?>/admin/setup_petitions">Petition Maintenance</A><BR>	
  		<A HREF="/<?= $k ?>/admin/integrity_verif">Verify Data Integrity</A><BR>	
  		<A HREF="/<?= $k ?>/admin/createcruform">Create a NYC CRU id form</A><BR>	
    </dd>
  </dl>

</DIV>
</DIV>
</DIV>
</DIV>






<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>