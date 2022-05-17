<?php	  	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

global $DB;
class Teams extends RepMyBlock {
  
   function FindCampaignFromCode ($TeamCode) {
		$sql = "SELECT * FROM Team WHERE Team_AccessCode = :TeamCode";
		$sql_vars = array("TeamCode" => $TeamCode);
	 	return $this->_return_simple($sql, $sql_vars);
	}
	
	function ListMyTeam($SystemUser_ID) {
		$sql = "SELECT * FROM TeamMember " .  
						"LEFT JOIN Team ON (TeamMember.Team_ID = Team.Team_ID) " .
						"WHERE TeamMember.SystemUser_ID = :SystemUser";
		$sql_vars = array("SystemUser" => $SystemUser_ID);
		return $this->_return_multiple($sql, $sql_vars);
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
						"WHERE Team.Team_ID = :TeamID";
		$sql_vars = array("TeamID" => $Team_ID);		
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	
	function ListUnsignedMembers($TeamID) {
		$sql = "SELECT * FROM RepMyBlock.Team " .
						"LEFT JOIN SystemUserEmail ON (SystemUserEmail.SystemUserEmail_WebCode = Team.Team_WebCode) " .
						"WHERE Team_ID = :TeamCode " .
						"ORDER BY SystemUserEmail_Received DESC";
		$sql_vars = array("TeamCode" => $TeamID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
}
?>

