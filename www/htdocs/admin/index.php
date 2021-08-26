<?php
	$Menu = "admin";
	$BigMenu = "represent";	
		 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if (empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
  
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
	 		<A HREF="/admin/<?= $k ?>/userlookup" class="mobilemenu">RepMyBlock User</A><BR>	
 			<A HREF="/admin/<?= $k ?>/voterlookup">Voter Lookup</A><BR>
  		<A HREF="/admin/<?= $k ?>/track">Petitions Tracker</A><BR>	
  		<A HREF="/admin/<?= $k ?>/setup_elections">Election Maintenance</A><BR>	
  		<A HREF="/admin/<?= $k ?>/setup_positions">Position Maintenance</A><BR>	
  		<A HREF="/admin/<?= $k ?>/create_petition">Create a petition</A><BR>	
  		<A HREF="/admin/<?= $k ?>/report_texting">Create a texting report</A><BR>	
   		
    </dd>
  </dl>

</DIV>
</DIV>
</DIV>
</DIV>






<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>