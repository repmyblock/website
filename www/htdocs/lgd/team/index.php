<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php";
	
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  
  $rmb = new Teams();
	
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
		WriteStderr($rmbteam, "RMB Team");
	}

	if ( ! empty ($URIEncryptedString["Team_ID"])) {
		$rmbteaminfo = $rmb->ListAllInfoForTeam($URIEncryptedString["Team_ID"]);
		WriteStderr($rmbteaminfo, "RMB Team Info");
		
		$ActiveTeam = $rmbteaminfo[0]["Team_Name"];
		$ActiveTeam_ID = $URIEncryptedString["Team_ID"];
	} else {
		WipeURLEncrypted();
		$ActiveTeam = $rmbteam[0]["Team_Name"];
		$ActiveTeam_ID = $rmbteam[0]["Team_ID"];
		$rmbteaminfo = $rmb->ListAllInfoForTeam($ActiveTeam_ID);
	}

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
			    <h2 id="public-profile-heading" class="Subhead-heading">Team Management</h2>
				</DIV>

				<div class=" mt-0 mb-0">
					<BR>
		   		 <P><B>Current Team:</B> <?= $ActiveTeam ?></P>

				<?php if ( count ($rmbteam) > 1) { ?>
			
					
					<P>
						<FORM ACTION="" METHOD="POST">
						<SELECT  CLASS="mobilebig" NAME="Team_ID">
							<?php 
								foreach ($rmbteam as $var) {
									if (! empty ($var)) { ?>
								<OPTION VALUE="<?= $var["Team_ID"] ?>"<?php if ($ActiveTeam_ID == $var["Team_ID"]) { echo " SELECTED"; } ?>><?= $var["Team_Name"] ?></OPTION>							
								<?php
								}
							}
							?>							
						</SELECT>
						<button type="submit" class="btn btn-primary mobilemenu">Change Active Team</button>
						</FORM>
					</P>
    
    <?php } ?>
     	</DIV>
				
     
				<?php	PlurialMenu($k, $TopMenus); ?>   

			  <div class="clearfix gutter d-flex flex-shrink-0">

				<div class="row">
				  <div class="main">
						<FORM ACTION="" METHOD="POST">
						<div class="Box">
					  	<div class="Box-header pl-0">
					    	<div class="table-list-filters d-flex">
					  			<div class="table-list-header-toggle states flex-justify-start pl-3">Team Members <B><?= $ActiveTeam ?></B></div>
					  		</div>
					    </div>
				    
			
			
					    <div class="Box-body  js-collaborated-repos-empty">
					      <A HREF="unsigned">List Unsigned Users</A>
					    </div>
					    
							    
					  
							<?php 			
										$Counter = 0;
										if ( ! empty ($rmbteaminfo)) {
										
							?>		
							
							
		<div class="Box-body  js-collaborated-repos-empty">
							<div class="flex-items-left">	
								<span class="ml-4 flex-items-baseline">
									
									<TABLE BORDER=1>
										<TR>
											<TH style="padding:0px 10px;">Party</TH>
											<TH style="padding:0px 10px;">First</TH>
											<TH style="padding:0px 10px;">Last</TH>
											<TH style="padding:0px 10px;">AD</TH>
											<TH style="padding:0px 10px;">ED</TH>
											<TH style="padding:0px 10px;">TOWN</TH>
											<TH style="padding:0px 10px;">&nbsp;</TH>
										</TR>
									
									
									<?php 
										foreach ($rmbteaminfo as $var) { 
											
											if ( $var["TeamMember_Active"] == "no") {
												$style = "color:brown;style:bold;background-color:lightgrey;font-weight: bold;";
											} else {
												$style = "";
											}
											
											?>
									
									<TR ALIGN=CENTER>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["SystemUser_Party"] ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["SystemUser_FirstName"] ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["SystemUser_LastName"] ?></TD>
										<TD style="padding:0px 10px;"><?= $var["AD"] ?></TD>
										<TD style="padding:0px 10px;"><?= $var["ED"] ?></TD>
										<TD style="padding:0px 10px;"><?= $var["TOWN"] ?></TD>
										<TH style="padding:0px 10px;"><A HREF="/<?=  CreateEncoded (
																												array( 
																													"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																													"Team_ID" => $_POST["Team_ID"],
																											    "TeamMember_ID" => $var["TeamMember_ID"]
																												)
																									); ?>/lgd/team/memberinfo"">Member Info</A></TH>
									</TR>
									
								<?php } ?>
								
								</TABLE>
								
								<P>
									<I>Members in red have not been authorized by an admin.</B>
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





<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
