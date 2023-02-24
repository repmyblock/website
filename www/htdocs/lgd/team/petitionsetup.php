<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	// $BigMenu = "represent";
	$Menu = "team";  
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php"; 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/DeadlineDates.php";	
	
	WriteStderr($URIEncryptedString, "URIEncryptedString Entering");
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new Teams();
	
	$result = $rmb->CheckCandidates($URIEncryptedString["Voters_ID"], $URIEncryptedString["Voters_RegParty"], 
																	$URIEncryptedString["TypeElection"][0], $URIEncryptedString["TypeValue"][0],
																	$URIEncryptedString["ActiveTeam_ID"]);													
	WriteStderr($result, "Result of the petition");		
														
	// Check that this petition for this user doesn't exist.
	if ( empty ($result)) {
		$ElectionType = $rmb->FindElectionType(	$URIEncryptedString["Elections_ID"], $URIEncryptedString["Voters_RegParty"],
																						$URIEncryptedString["TypeElection"][0], 
																						$URIEncryptedString["TypeValue"][0]);
																						
		if ( empty ($ElectionType)) {

			$PartyCall = $rmb->FindInPartyCall(	$URIEncryptedString["Elections_ID"], $URIEncryptedString["County_ID"], 
																					$URIEncryptedString["Voters_RegParty"], $URIEncryptedString["TypeElection"][0], 
																					$URIEncryptedString["TypeValue"][0]);
																					
			if ( empty ($PartyCall)) {
				$CandidateElection_Text = "Please contact because the district doesn't exist";
			}

			$CountyName = $rmb->DB_WorkCounty($URIEncryptedString["County_ID"]);			
			preg_match('/(\d{2})(\d{3})/', $URIEncryptedString["TypeValue"][0], $District, PREG_OFFSET_CAPTURE);
			
			switch($PartyCall["CandidatePositions_ID"]) {
				case '1':
					$CandidateElection_Text = $CountyName . " County Committee";
					$PositionType = "party";
					$NumberCandidates = $PartyCall["ElectionsPartyCall_NumberUnixSex"];
					$CandidateElection_PetitionText = "Member of the " . $CountyName . " Democratic County Committee from the " .
																						ordinal(ltrim($District[2][0], "0")) . " election district in the " . 
																						ordinal(ltrim($District[1][0], "0")) . " assembly district";
				break;

				case '13':	
					$CandidateElection_Text = $CountyName . " County Committee";
					$PositionType = "party";
					$NumberCandidates = $PartyCall["ElectionsPartyCall_NumberUnixSex"];
					$CandidateElection_PetitionText = "Member of the " . $CountyName . " Republican County Committee from the " .
																						ordinal(ltrim($District[2][0], "0")) . " election district in the " . 
																						ordinal(ltrim($District[1][0], "0")) . " assembly district";
				break;
			}

			$MatchTableName = array(
					"Elections_ID" => $URIEncryptedString["Elections_ID"], 
					"ElectionsPosition_ID" => $PartyCall["CandidatePositions_ID"], 
					"CandidateElection_PositionType" => $PartyCall["ElectionsPartyCall_PositionType"], 
					"CandidateElection_Party" => $URIEncryptedString["Voters_RegParty"], 
					"CandidateElection_Text" => $CandidateElection_Text, 
					"CandidateElection_PetitionText" => $CandidateElection_PetitionText, 
					"CandidateElection_URLExplain" => NULL, 
					"CandidateElection_Number" => $NumberCandidates, 
					"CandidateElection_DisplayOrder" => "100", 
					"CandidateElection_Display" => NULL, 
					"CandidateElection_Sex" => NULL, 
					"CandidateElection_DBTable" => $URIEncryptedString["TypeElection"][0], 
					"CandidateElection_DBTableValue" => $URIEncryptedString["TypeValue"][0],
			);
						
			$ElectionType = $rmb->CreatePositionEntry($MatchTableName);
			
		} else {
			
			$ElectionType = $ElectionType[0]["CandidateElection_ID"];
		}
		
		$Candidate = $rmb->InsertCandidate($URIEncryptedString["SystemUser_ID"], $URIEncryptedString["UniqNYSVoterID"], 
													$URIEncryptedString["Voters_ID"], 
													$URIEncryptedString["County_ID"], $ElectionType, 
													$URIEncryptedString["CPrep_Party"], $URIEncryptedString["FullName"],
													$URIEncryptedString["AddressLine1"] . "\n" . $URIEncryptedString["AddressLine2"], 
													$URIEncryptedString["TypeElection"][0], $URIEncryptedString["TypeValue"][0], NULL, 
													"published", $URIEncryptedString["ActiveTeam_ID"]);

		$CandidateSet = $rmb->NextPetitionSet($URIEncryptedString["SystemUser_ID"]);
		$FinalCandidate = $rmb->InsertCandidateSet($Candidate["Candidate_ID"], $CandidateSet["CandidateSet"], $URIEncryptedString["CPrep_Party"], 
															$URIEncryptedString["County_ID"]);		
	}
	
	header("Location: /" .  CreateEncoded ( array( 
									"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
									"ActiveTeam_ID" => $URIEncryptedString["ActiveTeam_ID"],
				)) . "/lgd/team/teampetitions");
				
	exit();
		
?>
	
	