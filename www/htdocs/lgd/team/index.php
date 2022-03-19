<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";
	// $BigMenu = "represent";	
	 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php"; 

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  WipeURLEncrypted();
  
	$rmb = new Teams();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$rmbteam = $rmb->SearchUsersForMyTeam($URIEncryptedString["SystemUser_ID"]);
	$Party = PrintParty($UserParty);
	
	WriteStderr($rmbteam, "RMB Team");

	$TopMenus = array ( 						
		array("k" => $k, "url" => "team/index", "text" => "Team Members"),
		array("k" => $k, "url" => "team/teampetitions", "text" => "Manage Petitions"),
		array("k" => $k, "url" => "team/teamcandidate", "text" => "Setup Team")
	);
										
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Team Membership</h2>
			  </div>
     
				<?php	PlurialMenu($k, $TopMenus); ?>   

			  <div class="clearfix gutter d-flex flex-shrink-0">

				<div class="row">
				  <div class="main">
						<FORM ACTION="" METHOD="POST">
						<div class="Box">
					  	<div class="Box-header pl-0">
					    	<div class="table-list-filters d-flex">
					  			<div class="table-list-header-toggle states flex-justify-start pl-3">Team Profile for <?= $rmbteam[0]["Team_Name"] ?></div>
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
								<span class="ml-4 flex-items-baseline">
							
							
							<A HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded (
										array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
													"Raw_Voter_ID" => $URIEncryptedString["SystemAdmin"],
													"Candidate_ID" => $var["Candidate_ID"])); ?>/rmb/voterlist">Walkshet</A>
							

							<A HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded (
										array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
													"Raw_Voter_ID" => $URIEncryptedString["SystemAdmin"],
													"Candidate_ID" => $var["Candidate_ID"])); ?>/NY/petition">Petition</A>

								
									<?= $var["SystemUser_FirstName"] . " " . $var["SystemUser_LastName"] ?>
																															
							<?php /*<A HREF="/<?= CreateEncoded (
										array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
													"Raw_Voter_ID" => $URIEncryptedString["SystemAdmin"],
													"Candidate_ID" => $var["Candidate_ID"])); ?>/lgd/team/teamateinfo">Setup</A>
																															*/ ?>
									<?=  $var["SystemUser_Party"] ?>																		
																															</span>
						 	
									
								</div>

							<?php
											}
										} 
							?>

							</div>
							<BR>

					</div>
					</FORM>
			</div>
		</DIV>
	</DIV>
	</DIV>
</DIV>





<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
