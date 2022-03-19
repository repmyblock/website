<?php	  	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

global $DB;
class Teams extends RepMyBlock {
  
  function FindCampaignFromCode ($TeamCode) {
		$sql = "SELECT * FROM Team WHERE Team_AccessCode = :TeamCode";
		$sql_vars = array("TeamCode" => $TeamCode);
	 	return $this->_return_simple($sql, $sql_vars);
	}
	
	function SaveTeamInfo($SystemUser_ID, $Team_ID, $Priv = NULL) {
		$ret = $this->ReturnTeamInfo($SystemUser_ID, $Team_ID);
		 if (empty ($ret)) {			
			$sql = "INSERT INTO TeamMember SET SystemUser_ID = :SystemUser, Team_ID = :TeamID, " . 
						 "TeamMember_Active = 'yes', TeamMember_ApprovedDate = NOW()";
			$sql_vars = array("SystemUser" => $SystemUser_ID, "TeamID" => $Team_ID);
			//				"TeamMember_Active = :Active, TeamMember_Privs = :Privs, " .
			//				"TeamMember_ApprovedBy = :App_SystemID, TeamMember_ApprovedNote = :App_Note, ";	
			WriteStderr($sql, "ReturnTeamInfo");	
			return $this->_return_nothing($sql, $sql_vars);						
		}
	}
	
	function ReturnTeamInfo($SystemUser_ID, $Team_ID, $Active = 'yes') {
		$sql = "SELECT * FROM TeamMember WHERE SystemUser_ID = :SystemUser AND Team_ID = :TeamID AND TeamMember_Active = :Active";
		$sql_vars = array("SystemUser" => $SystemUser_ID, "TeamID" => $Team_ID, "Active" => $Active);
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function ListActiveTeam($SystemUserID, $Active = 'yes') {		
		$sql = "SELECT * FROM Team " . 
						"LEFT JOIN TeamMember ON (TeamMember.Team_ID = Team.Team_ID) " . 
						"WHERE (TeamMember.SystemUser_ID = :SystemUser AND TeamMember_Active = :Active) " .
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
	
}
?>

