<?php	  	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

global $DB;
class Teams extends RepMyBlock {
  
  function FindCampaignFromCode ($TeamCode) {
		$sql = "SELECT * FROM Team WHERE Team_AccessCode = :TeamCode";
		$sql_vars = array("TeamCode" => $TeamCode);
	 	//return $this->_return_simple($sql, $sql_vars);
	}
	
	function SaveTeamInfo($SystemUser_ID, $Team_ID, $Priv = NULL) {
		$ret = $this->ReturnInfo($SystemUser_ID, $Team_ID);
		// if (empty ($ret)) {			
			//$sql = "INSERT INTO Team SET SystemUser_ID = :SystemUser, Team_ID = :TeamID, TeamMember_ApprovedDate = NOW()";
			//$sql_vars = array("SystemUser" => $SystemUser_ID, "TeamID" => $Team_ID);
			//				"TeamMember_Active = :Active, TeamMember_Privs = :Privs, " .
			//				"TeamMember_ApprovedBy = :App_SystemID, TeamMember_ApprovedNote = :App_Note, ";	
			WriteStderr($sql, "ReturnTeamInfo");	
			//return $this->_return_nothing($sql, $sql_vars);						
		// }
	}
	
	function ReturnTeamInfo($SystemUser_ID, $Team_ID, $Active = 'yes') {
		$sql = "SELECT * FROM Team WHERE SystemUser_ID = :SystemUser AND Team_ID = :TeamID AND TeamMember_Active = :Active";
		$sql_vars = array("SystemUser" => $SystemUser_ID, "TeamID" => $Team_ID, "Active" => $Active);
		//return $this->_return_simple($sql, $sql_vars);
	}
	
	function ListActiveTeam($SystemUserID, $Active = 'yes') {
		$sql = "SELECT * FROM Team WHERE SystemUser_ID = :SystemUser AND TeamMember_Active = :Active";
		$sql_vars = array("SystemUser" => $SystemUser_ID, "Active" => $Active);
		//return $this->_return_multiple($sql, $sql_vars);
	}
	
}
?>

