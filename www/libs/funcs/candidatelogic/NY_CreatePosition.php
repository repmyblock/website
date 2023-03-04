<?php
// Check that this petition for this user doesn't exist.

WriteStderr($PetitionData, "PetitionData");	

$ElectionType = $rmb->FindElectionType(	$PetitionData["Elections_ID"], $PetitionData["Voters_RegParty"],
																				$PetitionData["TypeElection"], 
																				$PetitionData["TypeValue"]);			
																	
if ( empty ($ElectionType)) {

	$PartyCall = $rmb->FindInPartyCall(	$PetitionData["Elections_ID"], $PetitionData["County_ID"], 
																			$PetitionData["Voters_RegParty"], $PetitionData["TypeElection"], 
																			$PetitionData["TypeValue"]);
																			
	WriteStderr($PartyCall, "PartyCall in NY Create Position.");	
																			
	if ( empty ($PartyCall)) {
		$CandidateElection_Text = "Please contact because the district doesn't exist in the Party Call";
	}

	$CountyName = $rmb->DB_WorkCounty($PetitionData["County_ID"]);			
	preg_match('/(\d{2})(\d{3})/', $PetitionData["TypeValue"], $District, PREG_OFFSET_CAPTURE);
	
	
	### This is where the logic per ID goes.
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
			"Elections_ID" => $PetitionData["Elections_ID"], 
			"ElectionsPosition_ID" => $PartyCall["CandidatePositions_ID"], 
			"CandidateElection_PositionType" => $PartyCall["ElectionsPartyCall_PositionType"], 
			"CandidateElection_Party" => $PetitionData["Voters_RegParty"], 
			"CandidateElection_Text" => $CandidateElection_Text, 
			"CandidateElection_PetitionText" => $CandidateElection_PetitionText, 
			"CandidateElection_URLExplain" => NULL, 
			"CandidateElection_Number" => $NumberCandidates, 
			"CandidateElection_DisplayOrder" => "100", 
			"CandidateElection_Display" => NULL, 
			"CandidateElection_Sex" => NULL, 
			"CandidateElection_DBTable" => $PetitionData["TypeElection"], 
			"CandidateElection_DBTableValue" => $PetitionData["TypeValue"],
	);
				
	$ElectionType = $rmb->CreatePositionEntry($MatchTableName);
	
} else {
	
	$ElectionType = $ElectionType[0]["CandidateElection_ID"];
}

WriteStderr($ElectionType, "ElectionType");	

$CandidatePetiton = $rmb->SearchPetitionCandidate($PetitionData["SystemUser_ID"], $PetitionData["UniqNYSVoterID"], $PetitionData["Voters_ID"], 
																		$PetitionData["County_ID"], $ElectionType, 
																		$PetitionData["CPrep_Party"], $PetitionData["FullName"],	
																		$PetitionData["AddressLine1"] . "\n" . $PetitionData["AddressLine2"], 
																		$PetitionData["TypeElection"], $PetitionData["TypeValue"],"published", $PetitionData["ActiveTeam_ID"]);
																		
WriteStderr($CandidatePetiton, "CandidatePetiton");																			

if ( empty ($CandidatePetiton)) {
	$Candidate = $rmb->InsertCandidate($PetitionData["SystemUser_ID"], $PetitionData["UniqNYSVoterID"], 
												$PetitionData["Voters_ID"], 
												$PetitionData["County_ID"], $ElectionType, 
												$PetitionData["CPrep_Party"], $PetitionData["FullName"],
												$PetitionData["AddressLine1"] . "\n" . $PetitionData["AddressLine2"], 
												$PetitionData["TypeElection"], $PetitionData["TypeValue"], NULL, 
												"published", $PetitionData["ActiveTeam_ID"]);

	$CandidateSet = $rmb->NextPetitionSet($PetitionData["SystemUser_ID"]);
	$FinalCandidate = $rmb->InsertCandidateSet($Candidate["Candidate_ID"], $CandidateSet["CandidateSet"], 
																							$PetitionData["CPrep_Party"], $PetitionData["County_ID"]);	
}	


?>
