<?php

// This the the logic for populating the candidate field
if ( ! empty ($CandidateLogic)) {
	// I need to create the candidate list

	if ( ! empty ($CandidateLogic["Position"])) {
		foreach ($CandidateLogic["Position"] as $index => $var) {
			if ( ! empty ($var)) {				
				switch ($var) {
					case "County Committee":
						$EDAD = sprintf('%02d%03d', $CandidateLogic["AssemblyDistr"], 
																				$CandidateLogic["ElectDistr"]);
						$ElectionInfo = $rmb->GetElectionInfo_NewYork_CountyCommittee($CandidateLogic["EnrollPolParty"],
																																					$CandidateLogic["Gender"], $EDAD);	
						
						// If it's empty we can add the candidate
						if ( empty ($ElectionInfo[0]["Candidate_ID"])) {
							$rmb->InsertCandidate_NewYork_CountyCommittee(
														$SystemUser_ID, $CandidateLogic["Voter_ID"], $DatedFiles,
														$DatedFilesID, $ElectionInfo[0]["CandidateElection_ID"], $EDAD, 
														$CandidateLogic["EnrollPolParty"], $CandidateLogic["PetitionName"],
														$CandidateLogic["PetitionAddress"]);
						}
						
						break;
						
					default:
						break;
				}
			}
		}
	}
}

?>
