<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_admin.php";
	//require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_team.php";

	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new RMBAdmin();	
  
  //$rmb = new Teams();
	
  if (! empty ($_POST)) {
  	WriteStderr($URIEncryptedString, "URIEncryptedString");
  	WriteStderr($_POST, "POST to ... ");
  	// $TeamInformation = $rmb->ListAllInfoForTeam($_POST["Team_ID"]);
  	header("Location: /" . CreateEncoded (
					array( 
						"Team_ID" => $_POST["Team_ID"],
				    "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
				    "EDAD" =>  $URIEncryptedString["EDAD"], 
   					"SystemAdmin" => $URIEncryptedString["SystemAdmin"]

					)
		) . "/admin/team");
		exit();
  } 
 	
 	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$rmbteam = $rmb->ListsTeams();		
	WriteStderr($rmbteam, "URIEncryptedString");
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>


<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Team List</h2>
			  </div>
				
					  <div class="clearfix gutter d-flex flex-shrink-0">
	
	


<div class="row">
  <div class="main">


		<FORM ACTION="" METHOD="POST">
			<INPUT TYPE="HIDDEN" NAME="setup_elections" VALUE="add">
		<div class="Box">
	  	<div class="Box-header pl-0">
	    	<div class="table-list-filters d-flex">
	  			<div class="table-list-header-toggle states flex-justify-start pl-3">Active Teams</div>
	  		</div>
	    </div>
    
	    <div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
	      We don't know your district <a href="/voter">create one</a>?
	    </div>
	   
	    	
<?php 			
			$Counter = 0;
			if ( ! empty ($rmbteam)) {
				foreach ($rmbteam as $var) {
?>

 
            

<div class="flex-items-left">
		<span class="ml-4"><?= $var["Team_ID"] ?></span>
	 	<span class="ml-4 user-mention"><A HREF="/<?= CreateEncoded(array(
														"Team_ID" => $var["Team_ID"],	
														 "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
													   "EDAD" =>  $URIEncryptedString["EDAD"], 
									   				 "SystemAdmin" => $URIEncryptedString["SystemAdmin"]
													)); ?>/admin/team_edit"><?= $var["Team_Name"] ?></A></span>
		<span class="ml-4 "><?= $var["SystemUser_FirstName"] . " " . $var["SystemUser_LastName"] ?></span>	 	
	 	<span class="ml-4"><?= $var["Team_Public"] ?></span>
	  <span class="ml-4"><?= PrintDateTime($var["Team_Created"]) ?></span>
	</div>
					
						
							
					
<?php
					
				}
			} ?>
	 
		
	 
		</div>
	
</div>
</FORM>
</div>
</DIV>
</DIV>
</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>