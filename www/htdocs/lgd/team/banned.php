<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php";
	
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  
  $rmb = new Teams();
	
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$rmbteam = $rmb->ListBannedMembers($URIEncryptedString["Team_ID"]);
	WriteStderr($rmbteam, "RMB Team");
	$ActiveTeam = $rmbteam[0]["Team_Name"];
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left col-full">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 class="Subhead-heading">Banned Users</h2>
				</DIV>
				
		
				 <div class="clearfix gutter">
			  	<div class="row">
				  <div class="main">
			  	
			  		<DIV>
				<P class="f40">
		   		 <B>Current Team:</B> <?= $ActiveTeam ?>

		
     	</P>
				
				<?php	PlurialMenu($k, $TopMenus); ?>   

			  <div class="clearfix gutter">

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
					      <a href="index">Return to previous screen</a>
					    </div>
					    
							    
					  <div class="Box-body  js-collaborated-repos-empty">
							<?php 			
										$Counter = 0;
										if ( ! empty ($rmbteam)) {
										
							?>		
							
							
		
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
											<TH style="padding:0px 10px;">&nbsp;</TH>
										</TR>
									
									
									<?php 
										foreach ($rmbteam as $var) { 
											if ($var["TeamMember_Active"] == "banned") {										
											$FoundUserInList = 1;
											?>
									
									<TR ALIGN=CENTER>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["SystemUser_Party"] ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["TeamFirst"] ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["TeamLast"] ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["DataDistrict_StateAssembly"] ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["DataDistrict_Electoral"] ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["DataDistrictTown_Name"] ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>"><A HREF="/<?=  CreateEncoded (
																												array( 
																													"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																													"Team_ID" => $URIEncryptedString["Team_ID"],
																											    "TeamMember_ID" => $var["TeamMember_ID"],
																											    "ReturnToScript" => "banned"
																												)
																									); ?>/lgd/team/memberinfo"">Member Info</A></TD>
									</TR>
									
									<TR ALIGN=CENTER>
										<TD style="padding:0px 10px;<?= $style ?>" COLSPAN=5><?= $var["TeamMember_RemovedNote"] ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>">by <?= $var["BannerFirst"] . " " . $var["BannerLast"] ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>"><?= PrintOnDateTime($var["TeamMember_DateRequest"]) ?></TD>
									</TR>
									
									
									
								<?php }
							}  
								
									if (! $FoundUserInList) {  ?>
									
										<TR ALIGN=CENTER>
										<TD style="align:center;padding:0px 10px;<?= $style ?>" COLSPAN=7>No users defined in the team</TD>
									</TR>
									
							<?php	}  ?>
								
								</TABLE>
								
								
								
										</span>
						 	
									
								</div>

							<?php
									
										} 
							?>

							</div>
						</DIV>
							<BR>

					</div>
					</FORM>
			</div>
		</DIV>
	</DIV>
	</DIV>
</DIV>

</DIV>

</DIV>

</DIV>

</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
