<?php	  	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

global $DB;
class Teams extends RepMyBlock {
  
  function FindCampaignFromCode ($TeamCode) {
		$sql = "SELECT * FROM Team WHERE Team_AccessCode = :TeamCode";
		$sql_vars = array("TeamCode" => $TeamCode);
	 	return $this->_return_simple($sql, $sql_vars);
	}

	function ListSystemUserTeam($SystemUser_ID) {
		$sql = "SELECT * FROM Team " .  
						"WHERE Team.SystemUser_ID = :SystemUser";
		$sql_vars = array("SystemUser" => $SystemUser_ID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function ListTeamsWithMembers($SystemUserID) {		
		$sql = "SELECT *, TeamMember.SystemUser_ID AS SystemIDFromTeam FROM Team " . 
						"LEFT JOIN TeamMember ON (TeamMember.Team_ID = Team.Team_ID) " . 
						"WHERE (TeamMember.SystemUser_ID = :SystemUser) OR (Team_Public = 'public')";
						
		WriteStderr($sql, "ListActiveTeam");	
						
		$sql_vars = array("SystemUser" => $SystemUserID);
		return $this->_return_multiple($sql, $sql_vars);
	}
		
	function ListActiveTeam($SystemUserID, $Active = 'yes') {		
		$sql = "SELECT *, TeamMember.SystemUser_ID AS SystemIDFromTeam FROM Team " . 
						"LEFT JOIN TeamMember ON (TeamMember.Team_ID = Team.Team_ID AND TeamMember_Active = 'yes') " . 
						"WHERE (TeamMember.SystemUser_ID = :SystemUser AND (TeamMember_Active = :Active OR TeamMember_Active = 'pending')) " .
						" OR (Team_Public = 'public' AND Team_Active = :Active)";
						
		WriteStderr($sql, "ListActiveTeam");
		$sql_vars = array("SystemUser" => $SystemUserID, "Active" => $Active);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function SearchUsersForMyTeam($SystemUser_ID) {
		$sql = "SELECT *, SystemUser.SystemUser_ID AS SystemIDFromTeam FROM Team " .
						"LEFT JOIN TeamMember ON (Team.Team_ID = TeamMember.Team_ID) " .
						"LEFT JOIN SystemUser ON (SystemUser.SystemUser_ID = TeamMember.SystemUser_ID) " .
						"LEFT JOIN Candidate ON (Candidate.Candidate_UniqStateVoterID = SystemUser.Voters_UniqStateVoterID AND Candidate.Team_ID = Team.Team_ID) " .
						"LEFT JOIN CandidateGroup ON (Candidate.Candidate_ID = CandidateGroup.Candidate_ID) " .
						"WHERE Team.SystemUser_ID = :SystemID AND Candidate.Candidate_UniqStateVoterID IS NOT NULL";
						
		WriteStderr($sql, "ListActiveTeam");	
		$sql_vars = array("SystemID" => $SystemUser_ID);		
		return $this->_return_multiple($sql, $sql_vars);
	}

	function ReturnMemberFromTeam($TeamMemberID) {
		$sql = "SELECT *, TeamMember.SystemUser_ID as TeamSystemUser_ID FROM TeamMember " .
						"LEFT JOIN Team ON (TeamMember.Team_ID = Team.Team_ID) " . 
						"LEFT JOIN SystemUser ON (TeamMember.SystemUser_ID = SystemUser.SystemUser_ID) " .
						"WHERE TeamMember.TeamMember_ID = :TeamMemberID";
		$sql_vars = array("TeamMemberID" => $TeamMemberID);		
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function ListAllInfoForTeam($Team_ID) {
		$sql = "SELECT * FROM Team " .
						"LEFT JOIN TeamMember ON (TeamMember.Team_ID = Team.Team_ID) " . 
						"LEFT JOIN SystemUser ON (TeamMember.SystemUser_ID = SystemUser.SystemUser_ID) " .
						"LEFT JOIN Voters ON (SystemUser.Voters_ID = Voters.Voters_ID) " . 
						"LEFT JOIN DataDistrictTemporal ON (DataDistrictTemporal.DataHouse_ID = Voters.DataHouse_ID) " .
						"LEFT JOIN DataDistrictCycle ON (DataDistrictTemporal.DataDistrictCycle_ID = DataDistrictCycle.DataDistrictCycle_ID) " .
						"LEFT JOIN DataDistrict ON (DataDistrictTemporal.DataDistrict_ID = DataDistrict.DataDistrict_ID) " .
						"LEFT JOIN DataHouse ON (Voters.DataHouse_ID = DataHouse.DataHouse_ID) " .
						"LEFT JOIN DataDistrictTown ON (DataDistrictTown.DataDistrictTown_ID = DataHouse.DataDistrictTown_ID) " .
						"WHERE Team.Team_ID = :TeamID AND " . //TeamMember_Privs > :MaxPrivs AND TeamMember_RemovedDate IS NULL AND " .
						"(CURDATE() >= DataDistrictCycle_CycleStartDate AND CURDATE() <= DataDistrictCycle_CycleEndDate) IS NULL";
		$sql_vars = array("TeamID" => $Team_ID); // , "MaxPrivs" => 16);		
				
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function ListMyTeam($SystemUser_ID) {
		$sql = "SELECT * FROM Team " .  
						"LEFT JOIN TeamMember ON (TeamMember.Team_ID = Team.Team_ID) " .
						"WHERE (TeamMember.SystemUser_ID = :SystemUser AND TeamMember.TeamMember_Privs > :MaxPrivs AND TeamMember_RemovedDate IS NULL) OR Team.SystemUser_ID = :SystemUser";
		$sql_vars = array("SystemUser" => $SystemUser_ID, "MaxPrivs" => 16);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function ListBannedMembers($Team_ID) {
		$sql = "SELECT *, SystemUser.SystemUser_FirstName AS TeamFirst, SystemUser.SystemUser_LastName AS LastLast," . 
						"Banner.SystemUser_FirstName AS BannerFirst, Banner.SystemUser_LastName AS BannerLast " . 
						"FROM Team " .  
						"LEFT JOIN TeamMember ON (TeamMember.Team_ID = Team.Team_ID) " .
						"LEFT JOIN SystemUser ON (TeamMember.SystemUser_ID = SystemUser.SystemUser_ID) " . 
						"LEFT JOIN SystemUser AS Banner ON (TeamMember.TeamMember_RemovedBy = Banner.SystemUser_ID) " . 
						"WHERE Team.Team_ID = :TeamID ORDER BY TeamMember_DateRequest DESC";
		$sql_vars = array("TeamID" => $Team_ID);		
		return $this->_return_multiple($sql, $sql_vars);
	}	
	
	function ListUnsignedMembers($TeamID) {
		$sql = "SELECT *, SystemUserEmail.SystemUserEmail_MailCode as MailCode_First, " .
						"Team2.SystemUserEmail_RefMailCode as MailCode_Second, SystemUserTemporary.SystemUser_ID as SysFinalID, " .
						"SystemUserEmail.SystemUserEmail_AddFrom as EmailSentTo, " .
						"SystemUserEmail.SystemUserEmail_Reason as OriginalStatus " .
						"FROM Team " .
						"LEFT JOIN SystemUserEmail ON (SystemUserEmail.SystemUserEmail_WebCode = Team.Team_WebCode) " .
						"LEFT JOIN SystemUserEmail AS Team2 ON (Team2.SystemUserEmail_MailCode = SystemUserEmail.SystemUserEmail_RefMailCode)" .
						"LEFT JOIN SystemUserTemporary ON (SystemUserEmail.SystemUserEmail_MailCode = SystemUserTemporary_mailID) " .
						"LEFT JOIN SystemUserTemporaryLastLogin ON (SystemUserTemporaryLastLogin.SystemUserTemporary_ID = SystemUserTemporary.SystemUserTemporary_ID) " .
						"WHERE Team.Team_ID = :TeamCode " .
						"ORDER BY Team2.SystemUserEmail_Received DESC";
						
		$sql_vars = array("TeamCode" => $TeamID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function UpdateVolunteerTeam($Action, $TeamMemberID, $SystemID, $Notes = NULL) {				
		if ($Notes == "") { $Notes = NULL; }
		if (! empty ($Action)) {		
			$sql = "UPDATE TeamMember SET TeamMember_Active = :ActiveMode, ";
			switch ($Action) {
				case "yes":
					$sql .= "TeamMember_ApprovedBy = :SystemUser_ID, TeamMember_ApprovedNote = :Note, TeamMember_ApprovedNote = NOW() ";
					break;
					
				case "no":
				case "banned":
					$sql .= "TeamMember_RemovedBy = :SystemUser_ID, TeamMember_RemovedNote = :Note, TeamMember_RemovedDate = NOW() ";
					break;
					
				default:
			 		return NULL;
			}

			array("TeamMemberID" => $TeamMemberID, "SystemUser_ID" => $SystemID, "ActiveMode" => $Action, "Note" => $Notes);

			$sql .= "WHERE TeamMember_ID = :TeamMemberID";
			$sql_vars = array("TeamMemberID" => $TeamMemberID, "SystemUser_ID" => $SystemID, "ActiveMode" => $Action, "Note" => $Notes);
			return $this->_return_nothing($sql, $sql_vars);
		}
	}
	
	function AddNewTeam($SystemUser_ID, $TypeTeam, $TeamName, $Team_AccessCode, $Team_WebCode, $Team_EmailCode, $Active = 'yes') {
		$sql = "INSERT INTO Team SET SystemUser_ID = :SystemUserID, Team_Name = :TeamName, Team_AccessCode = :Access, " .
						"Team_WebCode = :WebCode, Team_EmailCode = :EmailCode, Team_Active = :Active, Team_Public = :TypeTeam, " .
						"Team_Created = NOW()";
						
		$sql_vars = array("SystemUserID" => $SystemUser_ID, "TeamName" => $TeamName, "Access" => $Team_AccessCode, "WebCode" => $Team_WebCode,
											"EmailCode" => $Team_EmailCode, ":Active" => $Active, "TypeTeam" => $TypeTeam);
		
		return $this->_return_nothing($sql, $sql_vars);
	}
	
	function CheckTeamExist($TeamName, $TeamAccessCode) {
		$sql = "SELECT * FROM Team WHERE " .
						"Team_Name = :TeamName OR Team_AccessCode = :TeamAccessCode OR Team_WebCode = :TeamAccessCode";
		$sql_vars = array("TeamName" => $TeamName, "TeamAccessCode" => $TeamAccessCode);
		return $this->_return_simple($sql, $sql_vars);	
	}

	function UpdateAutoTeam($PrivModification, $SystemUserID) {
		if ( $SystemUserID > 0) {
			$sql = "UPDATE SystemUser SET SystemUser_Priv = SystemUser_Priv";
			if ($PrivModification >= 0) { $sql .= " | "; } else { $sql .= " & ~"; }
			$sql .= ":AddPriv WHERE SystemUser_Priv != 4294967295 AND SystemUser_ID = :SystemID";
			$sql_vars = array("AddPriv" => $PrivModification, "SystemID" => $SystemUserID);
			return $this->_return_nothing($sql, $sql_vars);
		}
	}	
	
	function ListPetitionGroup($CandidateSet, $Status = NULL) {
		$sql = "SELECT * FROM CandidateSet " .
						"LEFT JOIN CandidateGroup ON (CandidateGroup.CandidateSet_ID = CandidateSet.CandidateSet_ID) " .
						"LEFT JOIN Candidate ON (CandidateGroup.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN DataCounty ON (DataCounty.DataCounty_ID = CandidateGroup.DataCounty_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " .
						"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
						"LEFT JOIN CandidateComRplceSet ON (CandidateComRplceSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateComRplce ON (CandidateComRplceSet.CandidateComRplce_ID = CandidateComRplce.CandidateComRplce_ID) " .
						"LEFT JOIN CandidatePartySymbol ON (CandidatePartySymbol.CandidatePartySymbol_ID = Candidate.CandidatePartySymbol_ID) " .
						"WHERE CandidateSet.CandidateSet_ID = :CandidateSet " .
						"ORDER BY CandidateGroup_Order ASC, CandidateComRplce_Order ASC";
		$sql_vars = array("CandidateSet" => $CandidateSet);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function CheckCandidates($VotersID, $Party, $DBTable, $DBValue, $Team_ID = NULL ) {
		$sql = "SELECT * FROM Candidate WHERE Voters_ID = :VoterID AND " .
						"CandidateElection_DBTable = :DBTable AND CandidateElection_DBTableValue = :DBValue";
					
		$sql_vars = array("VoterID" => $VotersID,	"DBTable" => $DBTable, "DBValue" => $DBValue);
											
		if ( ! empty ($Party)) {
			$sql .= " AND Candidate_Party = :Party";
			$sql_vars["Party"] = $Party;
		} else {
			$sql .= " AND Candidate_Party IS NULL";
		}
		
		if ( ! empty ($Team_ID)) {
			$sql .= " AND Team_ID = :Team_ID";
			$sql_vars["Team_ID"] = $Team_ID;
		} else {
			$sql .= " AND Team_ID IS NULL";
		}
		
		return $this->_return_simple($sql, $sql_vars);	
	}
	
  function ReturnCandidateInformation($CandidateID) {
  	$sql = "SELECT * FROM Candidate WHERE Candidate_ID = :CandidateID";
  	return $this->_return_simple($sql, array("CandidateID" => $CandidateID));	
  }
  
  function FindPositions($ElectionsID, $Party, $Type, $Value, $TeamID = NULL) {
  	$sql = "SELECT DISTINCT " .
  		/*			"EPC1.ElectionsPartyCall_ID AS EPC1_ElectionsPartyCall_ID, EPC1.ElectionsPartyCall_Party AS EPC1_ElectionsPartyCall_Party, EPC1.Elections_ID AS EPC1_Elections_ID, " . 
  						"EPC1.ElectionsPosition_ID AS EPC1_ElectionsPosition_ID, EPC1.DataCounty_ID AS EPC1_DataCounty_ID, EPC1.ElectionsPartyCall_DBTable AS EPC1_ElectionsPartyCall_DBTable, " . 
  						"EPC1.ElectionsPartyCall_DBTableValue AS EPC1_ElectionsPartyCall_DBTableValue, EPC1.ElectionsPartyCall_ConversionValue AS EPC1_ElectionsPartyCall_ConversionValue, " .
  					"EPC2.ElectionsPartyCall_ID AS EPC2_ElectionsPartyCall_ID, EPC2.ElectionsPartyCall_Party AS EPC2_ElectionsPartyCall_Party, EPC2.Elections_ID AS EPC2_Elections_ID, " . 
  						"EPC2.ElectionsPosition_ID AS EPC2_ElectionsPosition_ID, EPC2.DataCounty_ID AS EPC2_DataCounty_ID, EPC2.ElectionsPartyCall_DBTable AS EPC2_ElectionsPartyCall_DBTable, " . 
  						"EPC2.ElectionsPartyCall_DBTableValue AS EPC2_ElectionsPartyCall_DBTableValue, EPC2.ElectionsPartyCall_ConversionValue AS EPC2_ElectionsPartyCall_ConversionValue, " .
  					"EP1.ElectionsPosition_ID AS EP1_ElectionsPosition_ID, EP1.ElectionsPosition_DBTable AS EP1_ElectionsPosition_DBTable, EP1.DataState_ID AS EP1_DataState_ID, " . 
  						"EP1.ElectionsPosition_Type AS EP1_ElectionsPosition_Type, EP1.ElectionsPosition_Name AS EP1_ElectionsPosition_Name, EP1.ElectionsPosition_Party AS EP1_ElectionsPosition_Party, " . 
  						"EP1.ElectionsPosition_Order AS EP1_ElectionsPosition_Order , EP1.ElectionsPosition_Explanation AS EP1_ElectionsPosition_Explanation, " . 
  					"EP2.ElectionsPosition_ID AS EP2_ElectionsPosition_ID, EP2.ElectionsPosition_DBTable AS EP2_ElectionsPosition_DBTable, EP2.DataState_ID AS EP2_DataState_ID, " . 
  						"EP2.ElectionsPosition_Type AS EP2_ElectionsPosition_Type, EP2.ElectionsPosition_Name AS EP2_ElectionsPosition_Name, EP2.ElectionsPosition_Party AS EP2_ElectionsPosition_Party, " . 
  						"EP2.ElectionsPosition_Order AS EP2_ElectionsPosition_Order , EP2.ElectionsPosition_Explanation AS EP2_ElectionsPosition_Explanation, " .     */	
  					"CA1.Candidate_ID, CA1.SystemUser_ID, CA1.Team_ID, CA1.CandidateProfile_ID, CA1.Candidate_PetitionNameset, CA1.Candidate_UniqStateVoterID, CA1.Voters_ID, " . 
  					"CA1.Candidate_Party, CA1.Candidate_FullPartyName, CA1.CandidatePartySymbol_ID, CA1.Candidate_DisplayMap, CA1.Candidate_DispName, CA1.Candidate_DispResidence, " . 
  					"CA1.CandidateElection_DBTable, CA1.CandidateElection_DBTableValue, CA1.DataDistrictTown_ID, CA1.Candidate_StatsVoters,CA1. Candidate_Status, CA1.Candidate_Watermark, " . 
  					"CA1.Candidate_LocalHash, CA1.Candidate_NominatedBy, CandidateElection.Elections_ID, CA1.DataCounty_ID " .
  	 				"FROM ElectionsPartyCall AS EPC1 " .
  					"LEFT JOIN ElectionsPosition AS EP1 ON (EP1.ElectionsPosition_ID = EPC1.ElectionsPosition_ID) " .
  					"LEFT JOIN ElectionsPartyCall AS EPC2 ON " .
  						"(" . 
  							"EPC2.ElectionsPartyCall_DBTable = EPC1.ElectionsPartyCall_DBTable AND " . 
  						 	"EPC2.ElectionsPartyCall_DBTableValue = EPC1.ElectionsPartyCall_DBTableValue AND " . 
  						 	"EPC2.Elections_ID = EPC1.Elections_ID " .
//  						 	"AND EPC2.ElectionsPartyCall_Party = EPC1.ElectionsPartyCall_Party " .
  						") " .
  					"LEFT JOIN ElectionsPosition AS EP2 ON (EP2.ElectionsPosition_ID = EPC2.ElectionsPosition_ID) " .
  					"LEFT JOIN Candidate AS CA1 ON " . 
  						"(" .
  							"CA1.CandidateElection_DBTable = EP2.ElectionsPosition_DBTable AND " .
  							"CA1.CandidateElection_DBTableValue = EPC2.ElectionsPartyCall_ConversionValue AND " .
  							"CA1.Candidate_Party = EP2.ElectionsPosition_Party" .
							") " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = CA1.CandidateElection_ID AND EPC1.Elections_ID = CandidateElection.Elections_ID) " .
  					"WHERE " . 
  					"EPC1.Elections_ID = :Elections_ID AND " . 
  					"EPC1.ElectionsPartyCall_Party = :Party AND " .
  					"EP1.ElectionsPosition_DBTable = :Type AND " .
  					"EPC1.ElectionsPartyCall_ConversionValue = :Value AND Candidate_ID IS NOT NULL AND CandidateElection.Elections_ID IS NOT NULL";
  					
   	$sql_vars = array("Elections_ID" => $ElectionsID, "Party" => $Party, "Type" => $Type , "Value" => $Value);
		return $this->_return_multiple($sql, $sql_vars);
  }
  
  function CheckCandidateGroups ($CandidatesIDs) {
  	$sql = "SELECT * FROM CandidateGroup WHERE "; 
  	
   	if ( ! empty ($CandidatesIDs)) {
	  	foreach ($CandidatesIDs as $index => $var) {
  			$sql .= $and ."Candidate_ID = '" . intval($var) . "'";
  			$and = " OR ";
  		}
  	}
  	
  	return $this->_return_multiple($sql);
  }
  
}
?>
