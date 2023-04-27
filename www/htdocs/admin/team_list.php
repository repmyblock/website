<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_admin.php";

	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new RMBAdmin();	
  
  //$rmb = new Teams();
	
  if (! empty ($_POST)) {
  	WriteStderr($URIEncryptedString, "URIEncryptedString");
  	WriteStderr($_POST, "POST to ... ");
  	header("Location: /" . CreateEncoded (
					array( 
						"Team_ID" => $_POST["Team_ID"],
				    "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
				    "EDAD" =>  $URIEncryptedString["EDAD"], 
   					"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"]

					)
		) . "/admin/team");
		exit();
  } 
 	
 	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);	
	$rmbteam = $rmb->ListsTeams(NULL, $URIEncryptedString["StartAt"]);	

	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
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
	
				<div class="Box">
			  	<div class="Box-header pl-0">
			    	<div class="table-list-filters d-flex">
			  			<div class="table-list-header-toggle states flex-justify-start pl-3">Active Teams</div>
			  		</div>
			    </div>
    		
    			<div class="clearfix gutter d-flex flex-shrink-0">				
						<div class="col-12">
					  
	   				<P>
	   					
	   				Start: <?= $URIEncryptedString["StartAt"] ?><BR>
						<div id="resp-table">
							<div id="resp-table-header">
								<div class="table-header-cell">ID</div>
								<div class="table-header-cell">Team Name</div>
								<div class="table-header-cell">Owner</div>
								<div class="table-header-cell">Type</div>
								<div class="table-header-cell">Date</div>
							</div>    	
							<?php 			
										$Counter = 0;
										if ( ! empty ($rmbteam)) {
											foreach ($rmbteam as $var) {
												
											
												if ( $Counter++ <  20) {
												
							?>
										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><?= $var["Team_ID"] ?> - <?= $Counter ?></div>
												<div class="table-body-cell-left"><A HREF="/<?= CreateEncoded(array(
														"Team_ID" => $var["Team_ID"],	
														 "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
													   "EDAD" =>  $URIEncryptedString["EDAD"], 
									   				 "SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"]
													)); ?>/admin/team_edit"><?= $var["Team_Name"] ?></A></div>
												<div class="table-body-cell-left"><?= $var["SystemUser_FirstName"] . " " . $var["SystemUser_LastName"] ?></div>
												<div class="table-body-cell"><?= $var["Team_Public"] ?></div>
												<div class="table-body-cell"><?= PrintDateTime($var["Team_Created"]) ?></div>
											</div>													
										</div>
									
								<?php
												} else { 
														
													
													echo "<A HREF=\"/" . CreateEncoded (
																array( 
															    "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
											   					"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
											   					"StartAt" => ($URIEncryptedString["StartAt"] - 20),
																)) . "/admin/team_list\">Previous 21</A>";

													echo "<A HREF=\"/" . CreateEncoded (
																	array( 
																    "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
												   					"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
												   					"StartAt" => ($URIEncryptedString["StartAt"] + 20),
																	)) . "/admin/team_list\">Next 21</A>";
																	
																	

								 						}
													}
																				
													echo "<A HREF=\"/" . CreateEncoded (
																	array( 
																    "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
												   					"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
												   					"StartAt" => ($URIEncryptedString["StartAt"] - 20),
																	)) . "/admin/team_list\">Previous 21</A>";
													
													
												} ?>
		</DIV>
</P>			
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>