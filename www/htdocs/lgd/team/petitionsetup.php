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

	$PetitionData = array (	
				"County_ID" => $URIEncryptedString["County_ID"],
				"Elections_ID" => $URIEncryptedString["Elections_ID"],
				"TypeElection" => $URIEncryptedString["TypeElection"][0],
				"TypeValue" => $URIEncryptedString["TypeValue"][0],
				"Voters_RegParty" => $URIEncryptedString["Voters_RegParty"], 
				"ActiveTeam_ID" => $URIEncryptedString["ActiveTeam_ID"], 
				"AddressLine1" => $URIEncryptedString["AddressLine1"], 
				"AddressLine2" => $URIEncryptedString["AddressLine2"], 
				"CPrep_Party" => $URIEncryptedString["CPrep_Party"], 
				"FullName" => $URIEncryptedString["FullName"], 
				"SystemUser_ID"  => $URIEncryptedString["SystemUser_ID"], 
				"UniqNYSVoterID"  => $URIEncryptedString["UniqNYSVoterID"], 
				"Voters_ID" => $URIEncryptedString["Voters_ID"], 
	);
	
	// Here we add the information into the CandidateProfile;
	if ( ! empty ($URIEncryptedString["ContactInfo"])) {
			$MatchTableName = array(
				"Fist"	 =>  $URIEncryptedString["UniqNYSVoterID"], 
				"Last"	 =>  $URIEncryptedString["TypeElection"][0] . " " . $URIEncryptedString["TypeValue"][0],
				"URL" =>  $URIEncryptedString["ActiveTeam_ID"], 
				"Full"	 =>  $URIEncryptedString["FullName"], 
				"Email"	 => $URIEncryptedString["ContactInfo"], 
			);
			$CandidateProfile = $rmb->updatecandidateprofile("force", $MatchTableName);	
	}
	
	
	if (empty ($result)) {
		WriteStderr($result, "PetitionData");						
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/candidatelogic/NY_CreatePosition.php";	
	}
									
									
									
	
									
													
	header("Location: /" .  CreateEncoded ( array( 
									"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
									"ActiveTeam_ID" => $URIEncryptedString["ActiveTeam_ID"],
				)) . "/lgd/team/teampetitions");
				
	exit();
?>
	
	