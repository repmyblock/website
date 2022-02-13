<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	// $BigMenu = "represent";
	$Menu = "team";  
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();
	
	if ( ! empty ($_POST)) {		
		WriteStderr($_POST, "Input \$_POST and creating the whole petition.");
		
		$ElectionsTypes = $rmb->ListElectedPositions(NULL, NULL, $_POST["ElectionType"]);
		WriteStderr($ElectionsTypes, "ElectionsTypes");	
		
		$CandidateElection = $rmb->CandidateElection($ElectionsTypes[0]["ElectionsPosition_DBTable"], 
																								 trim($_POST["DistrictID"]), NULL, NULL, 
																								 $_POST["ElectionData"]);
		WriteStderr($CandidateElection, "CandidateElection");	
		if ( empty ($CandidateElection)) {

			WriteStderr($CandidateElection, "CandidateElection is empty\n");	
			$CandidateElection = array(
						"ElectionID" => $_POST["ElectionData"], 
						"PosText" => $ElectionsTypes[0]["ElectionsPosition_Name"],
						"PetText" => "Temporary placeholder for " . $ElectionsTypes[0]["ElectionsPosition_State"] . 
													" District " . trim($_POST["DistrictID"]) . 
													" for the position of " . $ElectionsTypes[0]["ElectionsPosition_Name"],
						"Number" => 1,
						"Order" => $ElectionsTypes[0]["ElectionsPosition_Order"], 
						"Display" => 'no', 
						"DBTable" => $ElectionsTypes[0]["ElectionsPosition_DBTable"],
						"DBValue" => trim($_POST["DistrictID"])
			);
			
			$Parties = $rmb->ListParties(NULL, NULL, $_POST["PartyID"]);		
			switch ($ElectionsTypes[0]["ElectionsPosition_Type"]) {
				case "office":
					$CandidateElection["PosType"] = "electoral";
					break;
				case "party":
					$CandidateElection["PosType"] = "party";
					$CandidateElection["Party"] = $Parties[0]["PartyData_Abbrev"];
					break;
			}
						
			WriteStderr($CandidateElection, "CandidateElection Before InsertCandidateElection\n");	
			$CandidateElectionData = $rmb->InsertCandidateElection($CandidateElection);
			$CandidateElection["CandidateElection_ID"] = $CandidateElectionData["CandidateElection_ID"];
			WriteStderr($CandidateElectionData, "Finished InsertCandidateElection(): CandidateElectionData\n");	

		} else {
			$Parties = $rmb->ListParties(NULL, NULL, $_POST["PartyID"]);
			$CandidateElection["Party"] = $Parties[0]["DataParty_Abbrev"];
			$CandidateElection["DBTable"] = $CandidateElection[0]["CandidateElection_DBTable"];
			$CandidateElection["DBValue"]	= $CandidateElection[0]["CandidateElection_DBTableValue"];
			$CandidateElection["CandidateElection_ID"] = $CandidateElection[0]["CandidateElection_ID"];
		}
			
	 	$Address = $URIEncryptedString["CPrep_Address1"];
		if ( ! empty ($URIEncryptedString["CPrep_Address2"])) { $Address .= "\n" . $URIEncryptedString["CPrep_Address2"]; }
		if ( ! empty ($URIEncryptedString["CPrep_Address3"])) { $Address .= "\n" . $URIEncryptedString["CPrep_Address3"]; }
		
		$return = $rmb->InsertCandidate($URIEncryptedString["SystemUser_ID"], NULL, NULL, NULL, 
																		$CandidateElection["CandidateElection_ID"], $CandidateElection["Party"], 
																		$URIEncryptedString["CPrep_Full"],
																		$Address, $CandidateElection["DBTable"], 
																		$CandidateElection["DBValue"],	NULL, "pending", $_POST["Label"]);		
		
		$MatchTableName = array(
			"Fist"	 => $URIEncryptedString["CPrep_First"], 
			"Last"	 => $URIEncryptedString["CPrep_Last"], 
			"Full"	 => $URIEncryptedString["CPrep_Full"], 
			"Email"	 => $URIEncryptedString["CPrep_Email"],
		);

		WriteStderr($return, "Return of InsertCandidate()");

		$profile_candidate = $rmb->updatecandidateprofile($return["Candidate_ID"], $MatchTableName);	
		WriteStderr($profile_candidate, "profile_candidate\n");		
		$rmb->addcandidateprofileid($return["Candidate_ID"], $profile_candidate["CandidateProfile_ID"]);
	
		if ($_POST["Comittee"] == "on") {
			header("Location: /" . $k . "/lgd/team/petitioncommittee");
			exit();
		}

		header("Location: /" . $k . "/lgd/team/teamcandidate");
		exit();
	}
		
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$ElectionsDates = $rmb->ListElectionsDates(50, 0, true, $URIEncryptedString["PetitionStateID"]);
	$ElectionsTypes = $rmb->ListElectedPositions($URIEncryptedString["PetitionStateID"], "id");
	$Parties = $rmb->ListParties($URIEncryptedString["PetitionStateID"], true);
	WriteStderr($ElectionsDates, "ElectionsDates");	
	WriteStderr($ElectionsTypes, "ElectionsTypes");	
	WriteStderr($Parties, "Parties");	

	$Party = PrintParty($UserParty);

	$TopMenus = array ( 
						array("k" => $k, "url" => "team/team", "text" => "Manage Pledges"),
						array("k" => $k, "url" => "team/teampetitions", "text" => "Manage Petitions"),
						array("k" => $k, "url" => "team/teamcandidate", "text" => "Manage Candidates")
					);			
	WriteStderr($TopMenus, "Top Menu");					
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) {	 $Cols = "col-12"; $SizeField = " SIZE=10"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Update election details</h2>
			  </div>
  
				<?php	PlurialMenu($k, $TopMenus); ?>


			  <div class="clearfix gutter d-flex flex-shrink-0">
		
					<div class="col-16">
	
						<?= $error_msg ?>
						
					  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
							<div>
								<dl class="form-group col-6 d-inline-block"> 
									<dt><label for="user_profile_name">Election Date</label></DT>
									<dd>
										<SELECT NAME="ElectionData">
											<OPTION VALUE="">&nbsp;</OPTION>
										<?php if (! empty ($ElectionsDates)) {
														foreach ($ElectionsDates as $var) {
															if ( ! empty ($var)) { ?>
																<OPTION VALUE="<?= $var["Elections_ID"] ?>"><?= $var["DataState_Abbrev"] . " - " . 
																											ucfirst($var["Elections_Type"]) . ": " . $var["Elections_Text"] . 
																											" (" . $var["Elections_Date"] .")" ?></OPTION>
										<?php     }
														}
													} ?>
										</SELECT>
										
									</dd>
								</dl>
						</DIV>
							
							<div>
										
								<dl class="form-group col-5 d-inline-block"> 
									<dt><label for="user_profile_name">Election Type</label></DT>
									<dd>
										<SELECT NAME="ElectionType">
											<OPTION VALUE="">&nbsp;</OPTION>
										<?php if (! empty ($ElectionsTypes)) {
														foreach ($ElectionsTypes as $var) {
															if ( ! empty ($var)) { ?>
																<OPTION VALUE="<?= $var["ElectionsPosition_ID"] ?>"><?=  
																	
																								$var["ElectionsPosition_Party"] . " " . 
																											ucfirst($var["ElectionsPosition_Type"]) . ": " . 
																											$var["ElectionsPosition_Name"] ?>
																										
										<?php     }
														}
													} ?>
										</SELECT>
									</dd>
								</dl>
								
									<dl class="form-group col-1 d-inline-block"> 
									<dt><label for="user_profile_name">Party</label></DT>
									<dd>
										<SELECT NAME="PartyID">
											<OPTION VALUE="">&nbsp;</OPTION>
											<?php if (! empty ($Parties)) {
														foreach ($Parties as $var) {
															if ( ! empty ($var)) { ?>
																<OPTION VALUE="<?= $var["DataParty_ID"] ?>"><?= $var["DataParty_Abbrev"] ?>
																										
										<?php     }
														}
													} ?>
										</SELECT>
									</dd>
								</dl>
								
						</DIV>
						
							<div>
								<dl class="form-group col-6 d-inline-block"> 
									<dt><label for="user_profile_name">Enter the district ID</label>
										<BR>
										The District ID follow the format of the Local Board of Elections. 
									</DT>
									<dd>
										<input class="form-control" type="text" Placeholder="District ID" name="DistrictID"<?php if (!empty ($Email)) { echo " VALUE=" . $Email; } ?> id="user_profile_name">
									</dd>
									<dt>
										For County Committee,
										enter a 5 (or 6) digits number that is 2 (or 3) digits for the Assembly District and 3 digits for the 
										Election District.
									</DT>
									
								</dl>
							</DIV>
										
										
						<div>
								<dl class="form-group col-6 d-inline-block"> 
									<dt><label for="user_profile_name">Label the petition</label> <I>(This will allow you to organize them)</I></DT>
									<dd>
										<input class="form-control" type="text" Placeholder="Petition Label Name" name="Label"<?php if (!empty ($Email)) { echo " VALUE=" . $Email; } ?> id="user_profile_name">
									</dd>
								</dl>
							</DIV>
									
									
								<div>
								<dl class="form-group col-6 d-inline-block"> 
									<dt><label for="user_profile_name">Check botton if you need a comittee to replace.</label></DT>
									<dd>
										<input type="checkbox" name="Comittee"<?php if (!empty ($Email)) { echo " VALUE=" . $Email; } ?> id="user_profile_name">
									</dd>
								</dl>
							</DIV>
									
									

								<p><button type="submit" class="btn btn-primary">Setup the candidate petition</button></p>
			
							</form> 
			
							</div>
				  	</div>
			  	</div>
				</div>
			</div>		
		</div>
	</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
