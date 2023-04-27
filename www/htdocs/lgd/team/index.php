<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php";
	
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  
  $rmb = new Teams(0);
	
  if (! empty ($_POST)) {
  	WriteStderr($URIEncryptedString, "URIEncryptedString");
  	WriteStderr($_POST, "POST to ... ");
  	$TeamInformation = $rmb->ListAllInfoForTeam($_POST["Team_ID"]);
  	header("Location: /" . CreateEncoded (
					array( 
						"ActiveTeam_ID" => $_POST["Team_ID"],
				    "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
			    	"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
					)
		) . "/lgd/team/index");
		exit();
  } else {
 		$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
		$rmbteam = $rmb->ListMyTeam($URIEncryptedString["SystemUser_ID"]);
		WriteStderr($rmbteam, "RMB Team In the Else from the Post");
	}
	
	if ( ! empty ($rmbteam)) {
		foreach ($rmbteam as $var) {
			
			switch($var["TeamMember_Active"]) {
				case "banned": $ShowBannedMenu = 1; break;
				case "declined": $ShowDeclinedMenu = 1; break;
				case "no": $ShowUnsignedMenu = 1; break;
			}
			$ListTeamNames[$var["Team_Name"]] = $var["Team_ID"];
		}	
	}
	
	WriteStderr($ListTeamNames, "List of name");
	WriteStderr($URIEncryptedString, "URIEncryptedString after List of Names");
	
	if ( ! empty ($URIEncryptedString["ActiveTeam_ID"])) {
		$rmbteaminfo = $rmb->ListAllInfoForTeam($URIEncryptedString["ActiveTeam_ID"]);
		WriteStderr($rmbteaminfo, "RMB Team Info");
		$ActiveTeam = $rmbteaminfo[0]["Team_Name"];
		$ActiveTeam_ID = $URIEncryptedString["ActiveTeam_ID"];
	} else {
		$ActiveTeam = $rmbteam[0]["Team_Name"];
		$ActiveTeam_ID = $rmbteam[0]["Team_ID"];
		$rmbteaminfo = $rmb->ListAllInfoForTeam($ActiveTeam_ID);
	}
	
	$URIEncryptedString["ActiveTeam"] = $ActiveTeam;
	$URIEncryptedString["ActiveTeam_ID"] = $ActiveTeam_ID;
	
	WriteStderr($URIEncryptedString, "URLInfo BEFORE Wipe");
	WipeURLEncrypted( array("SystemUser_ID", "ActiveTeam", "ActiveTeam_ID", "SystemUser_Priv") );
	WriteStderr($URIEncryptedString, "URLInfo AFTER Wipe");
	WriteStderr($rmbteaminfo, "RMB Team Member Info");
	
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
  		<div class="<?= $Cols ?> float-left col-full">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 class="Subhead-heading">Team Management</h2>
				</DIV>
				<?php	PlurialMenu($k, $TopMenus); ?>   
			  <div class="clearfix gutter">
			  	<div class="row">
				  <div class="main">
			  	
			  		<DIV>
				<P class="f40">
		   		 <B>Current Team:</B> <?= $ActiveTeam ?>
		   		 
		   	<?php WriteStderr($ListTeamNames, "List of name inside the code that are not appearing."); ?>

				<?php if ( count ($ListTeamNames) > 1) { ?>
						<FORM ACTION="" METHOD="POST">
						<SELECT  class="mobilebig" NAME="Team_ID">
							<?php 
								foreach ($ListTeamNames as $var => $index) {
																
									if (! empty ($var)) { ?>
										<OPTION VALUE="<?= $index ?>"<?php if ($ActiveTeam_ID == $index) { echo " SELECTED"; } ?>><?= $var ?></OPTION>							
									<?php
									}
								}
							?>							
						</SELECT>
						<button type="submit" class="submitred">Change Active Team</button>
						</FORM>
					
    
    <?php } ?>
     	</P>
			</DIV>

				
						<FORM ACTION="" METHOD="POST">
						<div class="Box">
					  	<div class="Box-header pl-0">
					    	<div class="table-list-filters d-flex">
					  			<div class="table-list-header-toggle states flex-justify-start pl-3 f60">Team Members <B><?= $ActiveTeam ?></B></div>
					  		</div>
					    </div>
				    
			
			
					    <div class="Box-body  js-collaborated-repos-empty f60">
					      <A HREF="/<?= CreateEncoded (
      																	array( 
																								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																								"ActiveTeam_ID" => $ActiveTeam_ID,
																								"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
																							)
																				); ?>/lgd/team/unsigned">Users with incomplete registrations</A>
												
												<BR>			
								
								<?php if (	$ShowUnsignedMenu == 1) { ?>
									 
									 <A HREF="/<?= CreateEncoded (
      																	array( 
																								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																								"ActiveTeam_ID" => $ActiveTeam_ID,
																								"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
																							)
																				); ?>/lgd/team/deregistered">Deregistered users</A>
									
									
								<?php } ?>
																
												
								<?php if (	$ShowDeclinedMenu == 1) { ?>
									 
									 <A HREF="/<?= CreateEncoded (
      																	array( 
																								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																								"ActiveTeam_ID" => $ActiveTeam_ID,
																								"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
																							)
																				); ?>/lgd/team/banned">Declined users</A>
									
									
								<?php } ?>
													
								<?php if (	$ShowBannedMenu == 1) { ?>
									 <A HREF="/<?= CreateEncoded (
      																	array( 
																								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																								"ActiveTeam_ID" => $ActiveTeam_ID,
																								"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
																							)
																				); ?>/lgd/team/banned">Banned users</A>
									
									
								<?php } ?>
								
								
																				
					    </div>
					    
							    
					  
							<?php 			
										$Counter = 0;
										if ( ! empty ($rmbteaminfo)) {
										
							?>		
							
							
						<div class="Box-body js-collaborated-repos-empty">
							<div class="flex-items-left">	
								<span class="ml-0 flex-items-baseline ">
									
									
									<DIV class="f40">
									<div id="resp-table">
										<div id="resp-table-header">
											<div class="table-header-cell">Party</div>
											<div class="table-header-cell">First</div>
											<div class="table-header-cell">Last</div>
											<div class="table-header-cell">AD</div>
											<div class="table-header-cell">ED</div>
											<div class="table-header-cell">Town</div>
			
											<div class="table-header-cell">&nbsp;</div>
										</div>

									
							
									
									
							
									
									<?php 
										foreach ($rmbteaminfo as $var) { 
											if ($var["TeamMember_Active"] == "yes" || $var["TeamMember_Active"] == "pending") {
											
											if ( $var["TeamMember_Active"] == "pending") {
												$style = "color:brown;style:bold;background-color:lightgrey;font-weight: bold;";
											} else {
												$style = "";
											}
											
											$FoundUserInList = 1;
											?>
									
										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><?= $var["SystemUser_Party"] ?></div>
												<div class="table-body-cell-left"><?= $var["SystemUser_FirstName"] ?></div>
												<div class="table-body-cell-left"><?= $var["SystemUser_LastName"] ?></div>
												<div class="table-body-cell"><?= $var["DataDistrict_StateAssembly"] ?></div>
												<div class="table-body-cell"><?= $var["DataDistrict_Electoral"] ?></div>
												<div class="table-body-cell-left"><?= $var["DataDistrictTown_Name"] ?></div>
												<div class="table-body-cell"><A HREF="/<?=  CreateEncoded (
																												array( 
																													"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																													"Team_ID" => $_POST["Team_ID"],
																											    "TeamMember_ID" => $var["TeamMember_ID"]
																												)
																									); ?>/lgd/team/memberinfo"">Member Info</A></div>
											</div>													
										</div>
								
								
									
								
									
								<?php }
							}  
								
									if (! $FoundUserInList) {  ?>
											<div class="table-body-cell-wide">No users defined in the team</div>
									
							<?php	}  ?>
							</DIV>
							</DIV>
						</DIV>
								</P>	
								
								<P class="f40">
									<I>Members in red have not been authorized by an admin.</I>
								</P>
								
										</span>
						 	
									
								</div>

							<?php
										
										} 
							?>

							</div></div>
							<BR>

					</div>
					</FORM>
			</div>
		</DIV>
	</DIV>
	</DIV>
</DIV>

</DIV>



<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
