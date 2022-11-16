<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php";
	
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  
  $rmb = new Teams();
	
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$rmbteam = $rmb->ListUnsignedMembers($URIEncryptedString["Team_ID"]);
	WriteStderr($rmbteam, "RMB Team");
	$ActiveTeam = $rmbteam[0]["Team_Name"];
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>

<div class="row">
  <div class="main">
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Team Management</h2>
				</DIV>

				<div class="f60 mt-0 mb-0">
					<BR>
		   		 <P><B>Current Team:</B> <?= $ActiveTeam ?></P>
     	</DIV>
				


			  <div class="clearfix gutter d-flex flex-shrink-0 f40">

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
								<span class="ml-4 flex-items-baseline">
									
									<TABLE BORDER=1>
										<TR>
											<TH style="padding:0px 10px;">Code</TH>
											<TH style="padding:0px 10px;">Email</TH>
											<TH style="padding:0px 10px;">Action</TH>
											<TH style="padding:0px 10px;">Date</TH>
											
										</TR>
									
									
									<?php 
										foreach ($rmbteam as $var) { 
											
											if ( $var["TeamMember_Active"] == "no") {
												$style = "color:brown;style:bold;background-color:lightgrey;font-weight: bold;";
											} else {
												$style = "";
											}
											
											if ( $var["SystemUserEmail_Reason"] == "REGISTRATION REQUEST") { $code = "R"; }
											else { $code = "F"; }											
								
											
											
											?>
									
									<TR ALIGN=CENTER>
											<TD style="padding:0px 10px;<?= $style ?>"><?= $var["SystemUserEmail_MailCode"] ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["SystemUserEmail_AddFrom"] ?></TD>
									
										<TD style="padding:0px 10px;"><?= $var["SystemUserEmail_RefMailCode"] ?></TD>
										<TD style="padding:0px 10px;"><?= PrintDateTime($var["SystemUserEmail_Received"]) ?></TD>
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



<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
