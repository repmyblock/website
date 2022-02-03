<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class welcome extends queries {

  function welcome ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	  
	 	$this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
  function CandidatesInfo($CandidateID = NULL) {
		$sql = "SELECT * FROM CandidateProfile ";
		
		if (! empty ($CandidateID)) {
			$sql .= "WHERE Candidate_ID = :CandidateID";
			$sql_vars = array("CandidateID" => $CandidateID);
			return $this->_return_simple($sql, $sql_vars);
		} 

		return $this->_return_multiple($sql);
	}
	
  
  function FindCandidate($CandidateID) {  	
		$sql = "SELECT * FROM Candidate " . 
						"WHERE Candidate_ID = :CandidateID";
		$sql_vars = array("CandidateID" => $CandidateID);
		return $this->_return_simple($sql, $sql_vars);	
	} 
	
	function FindVoter($VoterID, $DateFile) {  	
		$sql = "SELECT * FROM Raw_Voter_" . $DateFile . " " . 
						"WHERE Raw_Voter_UniqNYSVoterID = :VoterID";
		$sql_vars = array("VoterID" => $VoterID);
		return $this->_return_simple($sql, $sql_vars);	
	} 
	
	function FindVolunteer($SystemID) {  	
		$sql = "SELECT * FROM SystemUser " .  
						"WHERE SystemUser_ID = :SystemUser_ID";
		$sql_vars = array("SystemUser_ID" => $SystemID);
		return $this->_return_simple($sql, $sql_vars);	
	} 
	
	function SaveVolunteer($Email, $VoterID, $SystemID, $CandidateID ) {
		$sql = "INSERT INTO VoterCustomInfo SET " .
						"Raw_Voter_UniqNYSVoterID = :VoterID, " .
						"SystemUser_ID = :SystemUserID, " .
						"Candidate_ID = :CandidateID, " .
						"VoterCustomInfo_Email = :Email, VoterCustomInfo_CreateTime = NOW()";
		$sql_vars = array("VoterID" => $VoterID, "SystemUserID" => $SystemID, "CandidateID" => $CandidateID, "Email" => $Email);
		return $this->_return_nothing($sql, $sql_vars);			
	}
	
	function SaveReferral($Email, $CellPhone) {
		if ( ! empty ($Email) || ! empty($CellPhone)) {
			$sql = "INSERT INTO Referral SET ";
			if ( ! empty ($Email)) { $sql .= "Referral_email = :Email, "; $sql_vars["Email"] = $Email; }
			if ( ! empty ($CellPhone)) { $sql .= "Referral_cellphone = :CellPhone, "; $sql_vars["CellPhone"] = $CellPhone; }
			$sql .= "Referral_date = NOW()";
			return $this->_return_nothing($sql, $sql_vars);	
		}	
	}
		
}

?>
