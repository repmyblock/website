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
	$rmbteam = $rmb->ListsTeams($URIEncryptedString["Team_ID"]);	
	$activeteam = $rmbteam[0];
	WriteStderr($rmbteam, "Active Team List");

										
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>


<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="<?= $DIVCol ?> float-left">

				<div class="Subhead">
			  	<h2 class="Subhead-heading">Team Setup</h2>
				</div>
			
			
				
				
			<?php if (! empty ($URIEncryptedString["ErrorMsg"])) {
		    	
		    	echo "<FONT COLOR=BROWN><B>" . $URIEncryptedString["ErrorMsg"] . "</B></FONT>";
		    	echo "<BR><BR>";	
		    } ?>
				
							    
				<div class="clearfix gutter d-flex flex-shrink-0">
									
				<div class="col-12">
				  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
				
							
							<div>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Team Name</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Team Name" name="Team Name" VALUE="<?= $activeteam["Team_Name"] ?>" id="">
								</dd>
							</dl>

							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Email Code</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Email" name="Email" VALUE="<?= $activeteam["Team_EmailCode"] ?>" id="">
								</dd>
							</dl>
							
							
			
							
									<div>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Admin Name</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="First" name="FirstName" VALUE="<?= $activeteam["MasterFirst"] . " " . $activeteam["MasterLast"] ?>" id="">
								</dd>
							</dl>

							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Team Access Code</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Team_AccessCode" name="Team_AccessCode" VALUE="<?= $activeteam["Team_AccessCode"] ?>" id="">
								</dd>
							</dl>
							</div>
							
							
						
								<div>
							
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">URL Redirect</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="URL Redirect" name="ZIP" VALUE="<?= $activeteam["Team_URLRedirect"] ?>" id="">
								</dd>
							</dl>
							
								<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Private Team</label><DT>
								<dd>
									<SELECT class="PrivateTeam" NAME="PrivateTeam">
									<OPTION VALUE=""<?php if (empty ($activeteam["Team_Public"])) { echo " SELECTED"; } ?>>&nbsp;</OPTION>
									<OPTION VALUE="yes"<?php if ($activeteam["Team_Public"] == "private") { echo " SELECTED"; } ?>>yes</OPTION>
									<OPTION VALUE="no"<?php if ($activeteam["Team_Public"] == "public") { echo " SELECTED"; } ?>>No</OPTION>	
									</SELECT>
								</dd>
							</dl>
							
						</DIV>

					<DIV>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">NYS BOE ID</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="NYS Uniq ID" name="UniqNYS" VALUE="<?= $activeteam[""] ?>" id="">
								</dd>
							</dl>
				
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Party</label><DT>
								<dd>
									<SELECT  class="mobilebig" NAME="Party">
										<OPTION VALUE="">All</OPTION>
										<OPTION VALUE="DEM"<?php if ($FormFieldParty == "DEM") { echo " SELECTED"; } ?>>Democratic</OPTION>
										<OPTION VALUE="REP"<?php if ($FormFieldParty == "REP") { echo " SELECTED"; } ?>>Republican</OPTION>
										<OPTION VALUE="BLK"<?php if ($FormFieldParty == "BLK") { echo " SELECTED"; } ?>>No Affiliation</OPTION>
										<OPTION VALUE="GRE"<?php if ($FormFieldParty == "GRE") { echo " SELECTED"; } ?>>Green</OPTION>
										<OPTION VALUE="LBT"<?php if ($FormFieldParty == "LBT") { echo " SELECTED"; } ?>>Libertarian</OPTION>
										<OPTION VALUE="CON"<?php if ($FormFieldParty == "CON") { echo " SELECTED"; } ?>>Conservatives</OPTION>
										<OPTION VALUE="IND"<?php if ($FormFieldParty == "IND") { echo " SELECTED"; } ?>>Independence Party</OPTION>
										<OPTION VALUE="WOR"<?php if ($FormFieldParty == "WOR") { echo " SELECTED"; } ?>>Working Families</OPTION>
										<OPTION VALUE="WEP"<?php if ($FormFieldParty == "WEP") { echo " SELECTED"; } ?>>Women's Equality Party</OPTION>
										<OPTION VALUE="REF"<?php if ($FormFieldParty == "REF") { echo " SELECTED"; } ?>>Reform</OPTION>
										<OPTION VALUE="SAM"<?php if ($FormFieldParty == "SAM") { echo " SELECTED"; } ?>>SAM</OPTION>													
										<OPTION VALUE="OTH"<?php if ($FormFieldParty == "OTH") { echo " SELECTED"; } ?>>Other</OPTION>
									</SELECT>
								</dd>
							</dl>
						</div>

						<div>						
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Assembly District</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Assembly District" name="AD" VALUE="<?= $activeteam[""] ?>" id="">
								</dd>
							</dl>

							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Electoral District</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Electoral District" name="ED" VALUE="<?= $activeteam[""] ?>" id="">
								</dd>
							</dl>					
						</div>
								
						<div>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Congressional District</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Congressional District" name="Congress" VALUE="<?= $activeteam[""] ?>" id="">
								</dd>
							</dl>
						</div>

						<div>						
							<dl class="form-group col-12 d-inline-block"> 
								<dd>
									<button type="submit" class="btn btn-primary mobilemenu">Search User</button>
								</dd>
							</dl>
						</div>
					</form> 


				</div>
			</div>
		</div>
	</DIV>
</div>	

</DIV>
</DIV>
</DIV>
</DIV>






<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>