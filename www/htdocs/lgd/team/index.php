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
						"Team_ID" => $_POST["Team_ID"],
				    "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"]
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
	
	if ( ! empty ($URIEncryptedString["Team_ID"])) {
		$rmbteaminfo = $rmb->ListAllInfoForTeam($URIEncryptedString["Team_ID"]);
		WriteStderr($rmbteaminfo, "RMB Team Info");
		$ActiveTeam = $rmbteaminfo[0]["Team_Name"];
		$ActiveTeam_ID = $URIEncryptedString["Team_ID"];
	} else {
		$ActiveTeam = $rmbteam[0]["Team_Name"];
		$ActiveTeam_ID = $rmbteam[0]["Team_ID"];
		$rmbteaminfo = $rmb->ListAllInfoForTeam($ActiveTeam_ID);
	}
	
	
	
	WriteStderr($rmbteaminfo, "RMB Team Member Info");
	
	$TopMenus = array ( 						
		array("k" => $k, "url" => "team/index", "text" => "Team Members"),
		array("k" => $k, "url" => "team/teampetitions", "text" => "Manage Petitions"),
		array("k" => $k, "url" => "team/teamcandidate", "text" => "Setup Teams")
	);
										
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
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
					  			<div class="table-list-header-toggle states flex-justify-start pl-3">Team Members <B><?= $ActiveTeam ?></B></div>
					  		</div>
					    </div>
				    
			
			
					    <div class="Box-body  js-collaborated-repos-empty">
					      <A HREF="/<?= CreateEncoded (
      																	array( 
																								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																								"Team_ID" => $ActiveTeam_ID,
																							)
																				); ?>/lgd/team/unsigned">Users with incomplete registrations</A>
												
												<BR>			
								
								<?php if (	$ShowUnsignedMenu == 1) { ?>
									 
									 <A HREF="/<?= CreateEncoded (
      																	array( 
																								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																								"Team_ID" => $ActiveTeam_ID,
																							)
																				); ?>/lgd/team/deregistered">Deregistered users</A>
									
									
								<?php } ?>
																
												
								<?php if (	$ShowDeclinedMenu == 1) { ?>
									 
									 <A HREF="/<?= CreateEncoded (
      																	array( 
																								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																								"Team_ID" => $ActiveTeam_ID,
																							)
																				); ?>/lgd/team/banned">Declined users</A>
									
									
								<?php } ?>
													
								<?php if (	$ShowBannedMenu == 1) { ?>
									 <A HREF="/<?= CreateEncoded (
      																	array( 
																								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																								"Team_ID" => $ActiveTeam_ID,
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
								<span class="ml-0 flex-items-baseline">
									
									<TABLE BORDER=1>
										<TR>
											<TH style="padding:0px 10px;">Party</TH>
											<TH style="padding:0px 10px;">First</TH>
											<TH style="padding:0px 10px;">Last</TH>
											<TH style="padding:0px 10px;">AD</TH>
											<TH style="padding:0px 10px;">ED</TH>
											<TH style="padding:0px 10px;">TOWN</TH>
											<TH style="padding:0px 10px;">Sigs.</TH>
											<TH style="padding:0px 10px;">Done</TH>
											<TH style="padding:0px 10px;">&nbsp;</TH>
										</TR>
									
									
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
									
									<TR ALIGN=CENTER>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["SystemUser_Party"] ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["SystemUser_FirstName"] ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["SystemUser_LastName"] ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["DataDistrict_StateAssembly"] ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["DataDistrict_Electoral"] ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["DataDistrictTown_Name"] ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>">0</TD>
										<TD style="padding:0px 10px;<?= $style ?>">0</TD>
										<TD style="padding:0px 10px;<?= $style ?>"><A HREF="/<?=  CreateEncoded (
																												array( 
																													"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																													"Team_ID" => $_POST["Team_ID"],
																											    "TeamMember_ID" => $var["TeamMember_ID"]
																												)
																									); ?>/lgd/team/memberinfo"">Member Info</A></TD>
									</TR>
									
								<?php }
							}  
								
									if (! $FoundUserInList) {  ?>
									
										<TR ALIGN=CENTER>
										<TD style="align:center;padding:0px 10px;<?= $style ?>" COLSPAN=7>No users defined in the team</TD>
									</TR>
									
							<?php	}  ?>
								
								</TABLE>
								
								<P>
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
