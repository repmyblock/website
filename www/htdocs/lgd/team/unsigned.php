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
  		<div class="<?= $Cols ?> float-left col-full">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 class="Subhead-heading">Uncompleted Registrations</h2>
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
											<TH style="padding:0px 10px;">Code</TH>
											<TH style="padding:0px 10px;">Email</TH>
											<TH style="padding:0px 10px;">Action</TH>
											<TH style="padding:0px 10px;">Date</TH>
											
										</TR>
									
									
									<?php 
									if ( ! empty ($rmbteam[0]["SystemUserEmail_ID"])) {
										foreach ($rmbteam as $var) { 
											
							
											
											if ( $var["SystemUserEmail_Reason"] == "REGISTRATION REQUEST") { $code = "R"; }
											else { $code = "F"; }											
								
											
											
											?>
									
									<TR ALIGN=CENTER>
											<TD style="padding:0px 10px;<?= $style ?>"><?= $var["SystemUserEmail_MailCode"] ?></TD>
										<TD style="padding:0px 10px;<?= $style ?>"><?= $var["SystemUserEmail_AddFrom"] ?></TD>
									
										<TD style="padding:0px 10px;"><?= $var["SystemUserEmail_RefMailCode"] ?></TD>
										<TD style="padding:0px 10px;"><?= PrintDateTime($var["SystemUserEmail_Received"]) ?></TD>
											</TR>
									
								<?php } 
								
									} else { ?>
										
											<TR ALIGN=CENTER>
											<TD style="padding:0px 10px;<?= $style ?>" COLSPAN=4>No uncompleted registrations pending</TD>
											</TR>
										
										<?php
									} ?>
								
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
