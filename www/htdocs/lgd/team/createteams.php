<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	// $BigMenu = "represent";
	$Menu = "team";  
	
 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php"; 

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new teams();
	WriteStderr($URIEncryptedString, "URIEncryptedString");	
	
	// Check that the person is not in a team.
	$CntMyTeam = $rmb->ListSystemUserTeam($URIEncryptedString["SystemUser_ID"]);
	WriteStderr($CntMyTeam, "CntTeam To See");	
	
	if (! empty ($CntMyTeam)) {
		header("Location: index");
		exit();
	}
	
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$Party = PrintParty($UserParty);
	WriteStderr($rmbperson, "rmbperson");

	if ( ! empty ($_POST)) {
		WriteStderr($_POST, "Creating a new team \$_POST");

		$TeamName = trim($_POST["TeamName"]);
		$TeamAccessCode = trim($_POST["TeamAccessCode"]);
		$TeamAccessEmail = $TeamAccessCode . "@team." . $MailFromDomain;

		if ( ctype_alnum($TeamName)) { $ERROR_CODE = "1"; }
		if (! filter_var($TeamAccessEmail, FILTER_VALIDATE_EMAIL)) { $ERROR_CODE = "2"; }
    
		if ( empty ($ErrorMsg)) {
			$result = $rmb->CheckTeamExist($TeamName, $TeamAccessCode);
			
			if ( empty ($result)) {
				$rmb->AddNewTeam($rmbperson["SystemUser_ID"], "private", $TeamName, $TeamAccessCode, $TeamAccessCode, $TeamAccessEmail);
				header("Location: index");
				exit();
			} else {
				$ERROR_CODE = "3";
			}
		}
		
		exit();
	}
	
	### DealWithError
	if (! empty($URIEncryptedString["ERROR_CODE"])) {
		switch ($URIEncryptedString["ERROR_CODE"]) {
			case "1":
				$ErrorMsg = "<B><FONT COLOR=BROWN>The team name " . $URIEncryptedString["TeamName"] . " is not valid. Please remove any non alphanumeric characters.</FONT></B>";
				break;
				
			case "2":
				$ErrorMsg =  "<B><FONT COLOR=BROWN>The team access code selected</FONT> \"" . $URIEncryptedString["TeamAccessCode"] . "\" <FONT COLOR=BROWN>contains invalid caracters. Only use alphanumeric characters.</FONT></B>";
				break;

			case "3":
				$ErrorMsg = "<B><FONT COLOR=BROWN>The name " . $URIEncryptedString["TeamAccessCode"] . " was already used, please select a different one.</FONT></B>";
				break;	
		}
	}
		
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) {	 $Cols = "col-12"; $SizeField = " SIZE=10"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Create teams</h2>
			  </div>
  
				<?php
				 	PlurialMenu($k, $TopMenus);
				?>

			  <div class="clearfix gutter d-flex flex-shrink-0">	
					<div class="col-16">
	
						<?= $ErrorMsg ?>
						
					  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
							<div>
								<DL class="form-group col-12 d-inline-block f40">       
								  <DT><LABEL>Team Name</LABEL></DT>
								  <DD>
								  	Give your team a name. Make the name memorable so they will remember.
								  </DD>
								  
								  <DD>
								    <INPUT class="form-control" type="text" placeholder="Give your team a name" name="TeamName" value="<?= $URIEncryptedString["TeamName"]; ?>">
								  </DD>
								</DL>
								  
								<DL class="form-group col-9 d-inline-block f40"> 
								  <DT><LABEL>Team Access Code</LABEL><DT>
								  	The access code is the name people will need to enter in the 
								  	personal profile to get access to your team.
								  </DD>
								  <DD>
								    <INPUT class="form-control" type="text" placeholder="Token name" name="TeamAccessCode" value="<?= $URIEncryptedString["TeamAccessCode"]; ?>">
								  </DD>
								</DL>
																
								<?php /*
								<DL class="form-group col-12 d-inline-block f40"> 
								  <DT><LABEL>Admin Person</LABEL> must already by part of your team<DT>
								  <DD>
								    <INPUT class="form-control" type="text" placeholder="Username or Email" name="LastName" value="<?= $rmbcandidate["CandidateProfile_LastName"]; ?>">
								    <button type="submit" class="submitred">Check Username</button>
								  </DD>
								</DL>
								*/ ?>

							</DIV>
			
							<P><button type="submit" class="submitred">Create New Team</button></P>

						</form>
										
					</div>
		  	</div>
	  	</div>
		</div>
	</div>
</div>
</div>

<script src="/js/ajax/checkusernameforteam.js"></script>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
