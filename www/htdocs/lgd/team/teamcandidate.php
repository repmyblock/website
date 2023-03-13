<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";
	// $BigMenu = "represent";	
	 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }

	$rmb = new repmyblock();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	WipeURLEncrypted( array("ActiveTeam", "ActiveTeam_ID") );
	
	if (empty ($URIEncryptedString["ActiveTeam_ID"])) {
		print "<PRE>" . print_r($URIEncryptedString, 1) . "</PRE>";
		print "Problem with TeamID => " . $URIEncryptedString["Team_ID"] . "<BR>";
		exit();
	}
	  
	// Check if there are Candidates associated to this userid.
	// $ListPetitions = $rmb->ListCandidateInformation($URIEncryptedString["SystemUser_ID"]);
	// WriteStderr($ListPetitions, "ListPetitions");	

	$TopMenus = array ( 
						array("k" => $k, "url" => "team/index", "text" => "Team Members"),
						array("k" => $k, "url" => "team/teampetitions", "text" => "Manage Petitions"),
						array("k" => $k, "url" => "team/teamcandidate", "text" => "Setup Teams")
					);
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) {	 $Cols = "col-12"; $SizeField = " SIZE=10"; } else { $Cols = "col-9"; }
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>

	<div class="<?= $Cols ?> float-left f60">

	<div class="Subhead mt-0 mb-0">
  	<h2 class="Subhead-heading">Setup Teams</h2>
	</div>
	
	<?php	PlurialMenu($k, $TopMenus); ?>          
 
  <dl class="form-group col-9">
  	<dt><label for="user_profile_email">Create petitions for your team</label></dt>
    <dd class="d-inline-block">       	
			<A HREF="/<?= $k ?>/lgd/team/target">Create petition</A><BR>		
			<?php /* <A HREF="/<?= $k ?>/lgd/team/createteams">Create teams</A><BR>	*/ ?>
	</DL>

</DIV>
</DIV>
</DIV>
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
