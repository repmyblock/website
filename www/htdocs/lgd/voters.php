<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "voters";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ($MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>

<div class="row">
  <div class="main">



<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>


<div class="<?= $Cols ?> float-left">
	
	<div class="Subhead">
  	<h2 class="Subhead-heading">Voters</h2>
	</div>

	<?php 
		if ($VerifEmail == true) { 
			include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_emailverif.php";
		} else if ($VerifVoter == true) {
			include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_voterinfo.php";
		} 
	?>

	<A HREF="/lgd/<?= $k ?>/voterlist">List of voters in district</A><BR>
	<A HREF="/lgd/<?= $k ?>/voterquery">Query for a voter</A>
			


	
</div>

</div>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
