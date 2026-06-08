<?php
// This the common piece to both Delegate.php and UpdateCandidateProfile
WriteStderr($URIEncryptedString, "\033[7;35m\033[1;35mENTERING THE CANDPROFILE COMMON\033[0m\n\n");

/*    	
	Update of the Profile. I am leaving it here for time being because I typed everything by hand.
  $rmb->UpdateCandidateProfileByFields(
		Quarantine: 'yes', PicFileName: 'picfilename test', TmpPicFileName: 'pictmpfilename', PicVerif: 'yes', 
		PDFFileName: 'pdffilename', TmpPDFFileName: 'pdftmpfilename', PDFVerif: 'yes', PDFPetition: 'yes', 
		PDFPetitionState: 30, Team_ID: 10000, PolSelfParty: 20, PolSelfCaucus: 30, PolSelfAss: '40', 
		FirstName: 'testfirstname', LastName: 'test last name', Alias: 'the alias', CandidateRegAuthority_ID: 2000,
		RegID: 'reg fec id', DataConference_ID: 3000, Website: 'website', Email: 'email', SocialImgPath: 'socimgpath',
		Twitter: 'twitter', BlueSky: 'bluesky', Truth: 'truft', Facebook: 'facebook', LinkedIn: 'linkedin', 
		Instagram: 'insta', TikTok: 'tiktok', YouTube: 'youtube', BallotPedia: 'ballotpedia', PhoneNumber: 'phononumbero',
		FaxNumber: 'faxo', Statement: 'statement', Donation: "doneation line", PublishPetition: 'yes', 
		Complain: 'yes', LastModified: 'today', CandidateProfile_ID: $CandidateProfileID
	);
*/
        	
if ( empty ($ErrorMessage)) {	
	$parts = explode('-', $_POST['positionrunning'], 2);
	$DBTable = $parts[0] ?? null;
	$DBValue = $parts[1] ?? null;
	
	// Check the date first.
	$DateElection = $rmb->ListElectionDate($URIEncryptedString["DataStateID"], $URIEncryptedString["DateElection"]);
	WriteStderr($DateElection, "Checking the date first");	

	if (empty($DateElection)) {
		$rmbStateName = $rmb->ListStates($URIEncryptedString["DataStateID"]);
		$DateElection = $rmb->AddElectionDate(
			$URIEncryptedString["DataStateID"], $URIEncryptedString["DateElection"],
		 	$rmbStateName["DataState_Name"] . " election on " . PrintShortDate($URIEncryptedString["DateElection"])
		);
	}
			 
	// If the entry is manual.
	if ( ! empty(trim($_POST["manuposition"]))) {		
		// Find the ElectionsPositions from the ElectionsPositionTable.
		$rmbPosition = $rmb->ListAllPositions($URIEncryptedString["PositionID"]);
		WriteStderr($rmbPosition, "In MANUEL Positions");	

		$rmbCandidateElection = $rmb->FindElectionFromPositionID(
		 				$DateElection["Elections_ID"], $URIEncryptedString["PositionID"], 
		 				$_POST["manuposition"], null);
		

		if ( ! empty ($rmbCandidateElection)) {
			$CandidateElection_ID = $rmbCandidateElection[0]["CandidateElection_ID"];
		} else {
			$CandidateElection_ID = $rmb->CreatePositionEntry([
				"Elections_ID" => $DateElection["Elections_ID"],
				"CandidateElection_PositionType" => "tobedetermined",
				"CandidateElection_Text" => $rmbPosition["ElectionsPosition_Name"] . " - " . $_POST["manuposition"],
				"CandidateElection_PetitionText" => $rmbPosition["ElectionsPosition_Explanation"],
				"CandidateElection_DBTable" => $rmbPosition["ElectionsPosition_DBTable"],		
				"CandidateElection_DBTableValue" => $_POST["manuposition"],
				"ElectionsPosition_ID" => $rmbPosition["ElectionsPosition_ID"],		
			]);
		}				
		
		WriteStderr($rmbCandidateElection, "In MANUEL Positions with final CandidateElection_ID: $CandidateElection_ID");	
		

		// If the entry is already in the list.	
	} else {
				
	 	$ElectCandidate = $rmb->FindCandidateElection($URIEncryptedString["DataStateID"], $URIEncryptedString["PositionID"]);	
	 	
				 
 		if (! empty ($ElectCandidate)) {
	 		foreach ($ElectCandidate as $var) {
				if ( ! empty ($var)) {
					if ($var["CandidateElection_DBTable"] == $DBTable && NormalizeDataField($var["CandidateElection_DBTableValue"]) === NormalizeDataField($DBValue)) {
						if ( $var["Elections_Date"] == $URIEncryptedString["DateElection"]) {
        			$CandidateElection_ID = $var["CandidateElection_ID"];
        			WriteStderr(null, $var["CandidateElection_DBTable"] . " == " . $DBTable . " && " . 
														$var["CandidateElection_DBTableValue"] . " == " . $DBValue . 
														" Next check: " . $var["Elections_Date"] . " == " . $URIEncryptedString["DateElection"]);	
							break;
        		}
        		$LatestElectCandidate = $var;
					}
				}		
			} 			
 		}
 		
 	/*
	  $red   		= "\033[31m";
		$green  = "\033[32m";
		$yellow = "\033[33m";
		$blue   = "\033[34m";
		$purple = "\033[35m";
		$cyan   = "\033[36m";
		$white  = "\033[37m";
		$reset  = "\033[0m";
		$bold      = "\033[1m";
		$dim       = "\033[2m";
		$underline = "\033[4m";
		$blink     = "\033[5m"; // not widely supported
		$reverse   = "\033[7m";
		$reset     = "\033[0m";
	*/
 		
 		WriteStderr(null, "\033[1;31mCandidateElection_ID => $CandidateElection_ID\033[0m");
 		
 		if ( empty ($CandidateElection_ID)) {
 			// This means that the entry is not there for the Election_ID.
			$CandidateElection_ID = $rmb->CreatePositionEntry([
 						"Elections_ID" => $DateElection["Elections_ID"], 
 						"ElectionsPosition_ID" => $URIEncryptedString["PositionID"], 
 						"CandidateElection_PositionType" => $LatestElectCandidate["CandidateElection_PositionType"], 
 						"CandidateElection_Party" => $LatestElectCandidate["CandidateElection_Party"], 
 						"CandidateElection_Text" => $LatestElectCandidate["CandidateElection_Text"], 
 						"CandidateElection_PetitionText" => $LatestElectCandidate["CandidateElection_PetitionText"], 
 						"CandidateElection_URLExplain" => $LatestElectCandidate["CandidateElection_URLExplain"], 
 						"CandidateElection_Number" => $LatestElectCandidate["CandidateElection_Number"], 
 						"CandidateElection_DisplayOrder" => $LatestElectCandidate["CandidateElection_DisplayOrder"], 
 						"CandidateElection_Display" => $LatestElectCandidate["CandidateElection_Display"], 
 						"CandidateElection_Sex" => $LatestElectCandidate["CandidateElection_Sex"], 
 						"CandidateElection_DBTable" => $LatestElectCandidate["CandidateElection_DBTable"],
 						"CandidateElection_DBTableValue" => $LatestElectCandidate["CandidateElection_DBTableValue"]
			]);
 		}		 		
	}	 

	WriteStderr($CandidateElection_ID, "Candidate Election ID at end of loop: $CandidateElection_ID");	
	
	// Update the Candidate information about the district.
	if ($URIEncryptedString["CanElectID"] != $CandidateElection_ID) {
		
		WriteStderr(null, "Changing the Candidate information with the new district Information.");	
		$rmb->UpdateCandidate(Candidate_ID: $URIEncryptedString["Candidate_ID"], 
													CandidateElection_ID: $CandidateElection_ID,
													DBTableValue: $DBValue);
	}
	

	$CandidatesName = trim($URIEncryptedString["FirstName"]) . " " . trim($URIEncryptedString["LastName"]);
    
  // This is to setup the team portion
  if ($SetupTeam == true) {
	 	// Check that the user exist.
	 	$teamresult = $rmb->ListSystemUserTeam($URIEncryptedString["SystemUser_ID"], $URIEncryptedString["PositionID"]);
		// Find the Position		 
				
		if ( empty ($teamresult)) { 
			$ListPositionsName = $rmb->ListAllPositions($URIEncryptedString["PositionID"]);
			$TeamName = $CandidatesName . " for " . $ListPositionsName[0]["ElectionsPosition_Name"];
		
			do {
				$TeamCode = substr(trim($URIEncryptedString["FirstName"]), 0, 1) . 
										substr(trim($URIEncryptedString["LastName"]), 0, 1) . "_" . time();
			}	while ($rmb->CheckTeamExist(null, $TeamCode));
							
			$teamresult = $rmb->AddNewTeam($URIEncryptedString["SystemUser_ID"], 'private', $TeamName, 
												$TeamCode, $TeamCode, $TeamCode . "@register.repmyblock.org", 
												'no', $URIEncryptedString["PositionID"]);
		} else {
			$teamresult = $teamresult[0];
		}
		
	 	if ( ! empty ($_POST["StaffDelegate"])) {
	   	$EmailToGivePrivs = trim($_POST["StaffDelegate"]);
		 	$result = $rmb->CheckRegisterEmailForTeamAdmin($EmailToGivePrivs, 
		 										$URIEncryptedString["SystemUser_ID"], $teamresult["Team_ID"]);
		 		  	 	
		 	if ( $_POST["DelegateAdmin"] != 'yes') { $AdminCode = 1; } else { $AdminCode = 4294967295; }
		 	
		 	if (empty ($result["SystemUser_ID"]) && empty ($result["SystemUserTeamPending_email"])) {
		 		// Not there, then add
		 		$rmb->InsertTempTeam($EmailToGivePrivs, $teamresult["Team_ID"], $URIEncryptedString["SystemUser_ID"], 
		 													$_POST["DelegateAdmin"], $AdminCode);
		 	} else {
		 		// Check that it doesn't exist.
		 		$ReturnCurrentTeamMember = $rmb->CheckActiveTeamMember($result["SystemUser_ID"], $teamresult["Team_ID"]);
		 		
		 		$AddToTeam = true;
		 		foreach ($ReturnCurrentTeamMember as $var) {
		 			switch ($var["TeamMember_Active"]) {
		 				case 'yes': 
		 				case 'pending':
		 				case 'requested':
		 					$AddToTeam = false;
		 					break;
		 			}
		 		}
		 		
		 		if ($AddToTeam == true) {
	  	 		$rmb->AddToTeamMember($teamresult["Team_ID"], $result["SystemUser_ID"], $AdminCode, 
		 														$URIEncryptedString["SystemUser_ID"], 'requested');
				}
		 	}   
		}
	}
	
	if ( ! empty ($rmbPosition["ElectionsPosition_DBTable"])) {
		$DBTable = $rmbPosition["ElectionsPosition_DBTable"];
		$DBValue = null;
	} 
	
	/// WE ARE HERE and we must change the election_ID
 	if (empty ($_POST["CandidateProfile_ID"])) {
 		// Check if that username has a candidate setup for the position
 		$canresult = $rmb->SearchPetitionCandidate(
 					SystemUserID: $URIEncryptedString["SystemUser_ID"],
 					DBTable: $DBTable, DBValue: $DBValue, 
 					TeamID: $teamresult["Team_ID"]
		);
		
  	// We need to create a Candidate
		if (empty ($canresult)) {
			if ( ! empty (trim($_POST["manuposition"]))) {
				$DBValue = "Manual entry: " . trim($_POST["manuposition"]);
			}
			
			$Candidate_ID = $rmb->InsertCandidate(			
						SystemUserID: $URIEncryptedString["SystemUser_ID"], 
			  		CandidateElectionID: $CandidateElection_ID, 
			  		DisplayName: $CandidatesName,
			  		DBTable: $DBTable, DBValue: $DBValue,
			  		Status: 'pending',
						TeamID:$teamresult["Team_ID"]                    
			);	
		} else {
			$Candidate_ID = $canresult[0]["Candidate_ID"];
		}
	}        
}

WriteStderr($URIEncryptedString, "\033[1;7;35mEXITING THE CANDPROFILE COMMON\033[0m\n\n\n");

?>