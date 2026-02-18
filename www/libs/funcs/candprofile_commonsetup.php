<?php
// This the common piece to both Delegate.php and UpdateCandidateProfile
if ( empty ($ErrorMessage)) {	
	$parts = explode('-', $_POST['positionrunning'], 2);
	$DBTable = $parts[0] ?? null;
	$DBValue = $parts[1] ?? null;
	
	// Check the date first.
	$DateElection = $rmb->ListElectionDate($URIEncryptedString["DataStateID"], $URIEncryptedString["DateElection"]);
		
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
						
		$rmbCandidateElection = $rmb->FindElectionFromPositionID(
		 				$DateElection["Elections_ID"], $URIEncryptedString["PositionID"], 
		 				$rmbPosition["ElectionsPosition_DBTable"], null);

		if ( ! empty ($rmbCandidateElection)) {
			$CandidateElection_ID = $rmbCandidateElection[0]["CandidateElection_ID"];
		} else {
			$CandidateElection_ID = $rmb->CreatePositionEntry([
				"Elections_ID" => $DateElection["Elections_ID"],
				"CandidateElection_PositionType" => "tobedetermined",
				"CandidateElection_Text" => $rmbPosition["ElectionsPosition_Name"],
				"CandidateElection_PetitionText" => $rmbPosition["ElectionsPosition_Explanation"],
				"CandidateElection_DBTable" => $rmbPosition["ElectionsPosition_DBTable"],		
				"ElectionsPosition_ID" => $rmbPosition["ElectionsPosition_ID"],		
			]);
		}				

		// If the entry is already in the list.	
	} else {
				
	 	$ElectCandidate = $rmb->FindCandidateElection($URIEncryptedString["DataStateID"], $URIEncryptedString["PositionID"]);	
	 			 			 
 		if (! empty ($ElectCandidate)) {
	 		foreach ($ElectCandidate as $var) {
				if ( ! empty ($var)) {
					if ($var["CandidateElection_DBTable"] == $DBTable && $var["CandidateElection_DBTableValue"] == $DBValue ) {
						if ( $var["Elections_Date"] == $URIEncryptedString["DateElection"]) {
        			$CandidateElection_ID = $var["CandidateElection_ID"];
        		}
        		$LatestElectCandidate = $var;
					}
				}		
			} 			
 		}
 		
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
	
 	if (empty ($_POST["CandidateProfile_ID"])) {
 		// Check if that username has a candidate setup for the position
 		$canresult = $rmb->SearchPetitionCandidate(
 					$URIEncryptedString["SystemUser_ID"], null, null, null, 
					null, null, null,  null, $DBTable, $DBValue, null, $teamresult["Team_ID"]
		);
		
  	// We need to create a Candidate
		if (empty ($canresult)) {
			if ( ! empty (trim($_POST["manuposition"]))) {
				$DBValue = "Manual entry: " . trim($_POST["manuposition"]);
			}
			
			$Candidate_ID = $rmb->InsertCandidate(
				$URIEncryptedString["SystemUser_ID"], null, null, null, $CandidateElection_ID, null, 
				$CandidatesName, null, $DBTable, $DBValue, null, 'pending' , $teamresult["Team_ID"]
			);	
		} else {
			$Candidate_ID = $canresult[0]["Candidate_ID"];
		}
	}        
}
?>