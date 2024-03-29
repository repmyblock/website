<?php
	$Menu = "profile";
	$BigMenu = "profile";

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	WriteStderr($DebugInfo, "RepMyBlock");	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php";
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  
  
  $FoundUserInTeam = 0; // This is to print in case I don't find a team.
  $FoundPublicCampaign = 0;
  
	$rmb = new Teams();
	if ( ! empty ($_POST)) {
				
		$Encrypted_URL = $Decrypted_k;
		foreach ($_POST["PositionRunning"] as $var) {
			$Encrypted_URL .= "&Position[]=" . $var;
		}
		
		WriteStderr($_POST, "Post in ProfileTeam.php");
		// This is to remove the users
		if ( ! empty ( $_POST["TeamIDRmval"])) {
			foreach ($_POST["TeamIDRmval"] as $var) {
				$rmb->DisableTeamMember($var, $URIEncryptedString["SystemUser_ID"]);
			}
		}

		// This is to add the users
		if ( ! empty ( $_POST["TeamIDAddtion"])) {
			foreach ($_POST["TeamIDAddtion"] as $var) {
				// function SaveTeamInfo($URIEncryptedString["SystemUser_ID"], $var, $Priv = NULL, $Active = 'yes') {
				$rmb->SaveTeamInfo($URIEncryptedString["SystemUser_ID"], $var, NULL, 'pending');
			}
		}
		
		if (! empty($_POST["TeamCode"])) {		
			$TrimmedAccess = trim($_POST["TeamCode"]);
			$CampaignTeam = $rmb->FindCampaignFromCode($TrimmedAccess);
			WriteStderr($CampaignTeam, "CampaignTeam");
			
			if ( ! empty ($CampaignTeam["Team_URLRedirect"])) {
				header("Location: /" . CreateEncoded ( array( 
									"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
									"SuccessMsg" => "1",
								))  . $CampaignTeam["Team_URLRedirect"]);
				exit();				
			}
			
			if ( $CampaignTeam["Team_AccessCode"] == $TrimmedAccess ) {
				WriteStderr($CampaignTeam, "CampaignTeam: " . $URIEncryptedString["SystemUser_ID"] . " CampaignTema: " . $CampaignTeam["Team_ID"]);			
				$rmb->SaveTeamInfo($URIEncryptedString["SystemUser_ID"], $CampaignTeam["Team_ID"]);
				header("Location: /" . CreateEncoded ( array( 
									"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
									"SuccessMsg" => "1",
								))  . "/lgd/profile/profileteam");
			} 
		}
			
		header("Location: /" . CreateEncoded ( array( 
								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
								"SuccessMsg" => "0",
								"ErrorMsg" => "Could not find access code",
							))  . "/lgd/profile/profileteam");
		exit();
	}

	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}
	$Party = PrintParty($URIEncryptedString["UserParty"]);

	$rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);
	$rmbteams = $rmb->ListTeamsWithMembers($URIEncryptedString["SystemUser_ID"]);
	WriteStderr($rmbteams, "Teams List");
	
	$TopMenus = array (
						array("k" => $k, "url" => "profile/user", "text" => "Public Profile"),
						array("k" => $k, "url" => "profile/profilevoter", "text" => "Voter Profile"),
						array("k" => $k, "url" => "profile/profilecandidate", "text" => "Candidate Profile"),
						array("k" => $k, "url" => "profile/profileteam", "text" => "Team Profile")
					);
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
	
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Team Profile</h2>
			  </div>
     
				<?php	PlurialMenu($k, $TopMenus);	?>	
			  <div class="clearfix gutter d-flex flex-shrink-0">
			  	
	<div class="row">
  	<div class="main">

		
		<P class="f60">
			<B><FONT COLOR=BROWN>If you are part of a team, your team leader will supply you a code</A>
		</FONT> </B>
		</P>




		<FORM ACTION="" METHOD="POST">
			
				<div>
					<dl> 
						<dt><label for="user_profile_name" class="f60">Team Code</label><DT>
						<dd>
							<input class="form-control f40" type="text" Placeholder="Enter code" name="TeamCode"<?php if (!empty ($TeamCode)) { echo " VALUE=" . $TeamCode; } ?> id="user_profile_name">
						</dd>
					</dl>

					<dl> 
						<dt><button class="submitred">Apply the Team Code</BUTTON></DT>
					</dl>
				</DIV>
			
			
		<div class="Box">
	  	<div class="Box-header pl-0">
	    	<div class="table-list-filters d-flex">
	  			<div class="table-list-header-toggle states flex-justify-start pl-3 f60">Teams</div>
	  		</div>
	    </div>
	    
			<?php 			
					if ( ! empty ($rmbteams)) {
						foreach ($rmbteams as $var) {
							if ( $var["SystemIDFromTeam"] == $URIEncryptedString["SystemUser_ID"]) {
								if ( $var["TeamMember_Active"] == "yes" || $var["TeamMember_Active"] == "pending") {
									$FoundUserInTeam = 1;
			?>		
			
				<DIV>
					<div class="list-group-item filtered f50">						
	    				<span><INPUT class="f50" TYPE="CHECKBOX" NAME="TeamIDRmval[]" VALUE="<?= $var["TeamMember_ID"] ?>"></span>			
							<span><?= $var["Team_Name"] ?></span> <?php if ($var["TeamMember_Active"] == "pending") { ?><I>(pending approval)</I><?php } ?>
					
					</div>
 				</DIV>
 					<?php } ?>
 			
 				
			<?php } 
					
			} ?>
					
					</DIV>
								
				<?php if ($FoundUserInTeam == 1) { ?>
								
				<dl class=""> 
					<dt><p><button class="submitred">Remove me from the selected campaigns</BUTTON></p></DT>
				</dl>
				
				
				
			<?php }
				
				 } 
				 
				 if ($FoundUserInTeam == 0) {
				 
				 ?> 				
 				
 				
 				<DIV>
					<div class="list-group-item filtered f60">
	    			<span>You don't belong to any team.</span>			
					</div>
 				</DIV>
 			<BR>
 				
 				<?php } ?> 		

	 			<div class="Box">
			  	<div class="Box-header pl-0">
			    	<div class="table-list-filters d-flex">
			  			<div class="table-list-header-toggle states flex-justify-start pl-3 f60">Campaigns Seeking Voluteers</div>
		  		</div>
		    </div>
		    
		    	<?php 			
					if ( ! empty ($rmbteams)) {
						foreach ($rmbteams as $var) {
							if ( (empty ($var["SystemIDFromTeam"]) &&  $var["Team_Public"] == "public") || $var["TeamMember_Active"] == "no") {
							 $FoundPublicCampaign = 1;
			?>
				<DIV>
					<div class="list-group-item filtered f50">
	    			<span><INPUT TYPE="CHECKBOX" NAME="TeamIDAddtion[]" VALUE="<?= $var["Team_ID"] ?>"></span>			
						<span><?= $var["Team_Name"] ?></span>
					</div>
 				</DIV>

		  <?php } 
					} ?>
					
					</DIV>
					
				<?php					if (  $FoundPublicCampaign == 1 ) { ?>
					
								<dl class=""> 
					<dt><p><button class="submitred">Request information from selected campaigns</BUTTON></p></DT>
				</DL>
				
				<?php } ?>
				
				<?php } 
				
					if (  $FoundPublicCampaign == 0 ) { ?> 		
 				
 				<DIV>
					<div class="list-group-item filtered f60">
	    			<span>There aren't any campaign seeking volunteers.</span>			
					</div>
 				</DIV>
 				
 				</DIV>
			<?php } ?> 	
			
	 		

</DIV>
	</FORM>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>




<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
