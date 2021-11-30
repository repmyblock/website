<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class login extends queries {

  function login ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	 	$this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
  function RegisterUser($Username, $Email, $Password, $Type) {
  	
  	if ( empty ($Username) || empty ($Email) || empty ($Password)) return 0;
  	
  	$hashtable = hash("md5", PrintRandomText(40));
  	
  	// Save the entry to keep track.
  	$this->SaveInscriptionRecord($Email, $Username, $Type);
  	
  	// Check Username and Email in the main table.
  	$sql = "SELECT * FROM SystemUser WHERE SystemUser_email = :Email OR SystemUser_username = :Username";
		$sql_vars = array('Email' => $Email, 'Username' => $Username);
		$ret = $this->_return_multiple($sql,  $sql_vars);
		if (! empty($ret)) {
			if ($ret[0][SystemUser_email] == $Email || $ret[1][SystemUser_email] == $Email) { $error["EMAIL"] = 1; }
			if ($ret[0][SystemUser_username] == $Username || $ret[1][SystemUser_username] == $Username) { $error["USERNAME"] = 1; }
			return $error;
		}
  	
  	// Check Username and Email in the temporary table.
  	$sql = "SELECT * FROM SystemTemporaryUser WHERE SystemTemporaryUser_email = :Email OR SystemTemporaryUser_username = :Username";
		$ret = $this->_return_multiple($sql,  $sql_vars);
		
		if (! empty($ret)) {
			if ($ret[0][SystemTemporaryUser_email] == $Email || $ret[1][SystemTemporaryUser_email] == $Email) { $error["EMAIL"] = 1; }
			if ($ret[0][SystemTemporaryUser_username] == $Username || $ret[1][SystemTemporaryUser_username] == $Username) { $error["USERNAME"] = 1; }
			return $error;
		}
		
		if ( empty($ret)) {
			$ret = $this->AddEmailUsernamePassword($Email, $Username, $Password, $hashtable);		
			if ( empty ($ret["SystemTemporaryUser_ID"])) {
				return array("Problem" => "Problem saving the Email");
			}
		}
		
		$sql = "SELECT * FROM SystemTemporaryUser WHERE SystemTemporaryUser_ID = :ID";
		$sql_vars = array('ID' => $ret["SystemTemporaryUser_ID"]);
		$ret = $this->_return_simple($sql,  $sql_vars);

		return $ret;	  	
  }

	function SaveInscriptionRecord ($Email, $Username, $Type = "Other", $SystemUserID = NULL) {
		$sql = "INSERT INTO SystemUserVoter SET SystemUserVoter_Username = :Username, " .
						"SystemUserVoter_Email = :Email, SystemUserVoter_action = :Type, " . 
						"SystemUserVoter_Date = NOW(), SystemUserVoter_IP = :IP, SystemUser_ID = :SystemUserID";
		$sql_vars = array('Email' => $Email, 'Username' => $Username, 'Type' => $Type, 'IP' => $_SERVER['REMOTE_ADDR'], 'SystemUserID' => $SystemUserID);
		$this->_return_nothing($sql,  $sql_vars);
	}
						
	// Hack for login to pass right info.
	function FindVotersFromNYSUniq($UniqNYSVoterID, $DateFileName) {
		$sql = "SELECT * FROM Raw_Voter_" . $DateFileName . " WHERE Raw_Voter_UniqNYSVoterID = :Uniq";
		$sql_vars = array("Uniq" => $UniqNYSVoterID);
		return $this->_return_simple($sql, $sql_vars);
	} 

  function RegisterEmail($email) {
  	$sql = "";
  	
  	return 0;
  }
  
	function CheckEmail($email) {
		$sql = "SELECT * FROM SystemUser WHERE SystemUser_email = :Email";
		$sql_vars = array(':Email' => $email);											
		return $this->_return_simple($sql,  $sql_vars);
	}
	
	function CheckUsername($Username) {
		$sql = "SELECT * FROM SystemTemporaryUser " . 
						"LEFT JOIN SystemUser ON (SystemUser.SystemUser_ID = SystemTemporaryUser.SystemUser_ID) " . 
						"WHERE SystemTemporaryUser_username = :Username";
		$sql_vars = array(':Username' => $Username);			
		
		$ret = $this->_return_simple($sql, $sql_vars);
		if ( ! empty ($ret)) return $ret;
		
		$sql = "SELECT * FROM SystemUser WHERE SystemUser_username = :Username";								
		return $this->_return_simple($sql,  $sql_vars);
	}

	function AddEmail($email, $login_type = "password", $firstname = null, $lastname = null, $RawVoterID = null, $reason = null) {
		
		$IDEmail = $this->CheckEmail($email);
	
		if (empty ($IDEmail)) {
			$IDEmail = $this->SaveEmail($email, $login_type, $firstname, $lastname, $RawVoterID);
		}
		
		$sql = "INSERT INTO SystemUserVoter SET SystemUser_ID = :IDEmail, Raw_Voter_ID = :RawVoterID, SystemUserVoter_Action = :Action, SystemUserVoter_Date = NOW()";
		$sql_vars = array('IDEmail' => $IDEmail["SystemUser_ID"], 'RawVoterID' => $RawVoterID, 'Action' => $reason);
		
		$this->_return_nothing($sql,  $sql_vars);
		return $IDEmail;
	}

	function SaveEmail($email, $login_type = "password", $firstname = null, $lastname = null, $RawVoterID = null) {
		$sql = "INSERT INTO SystemUser SET SystemUser_email = :Email, SystemUser_loginmethod = :Type, Raw_Voter_ID = :RawVoterID, SystemUser_createtime = NOW()";	
		$sql_vars = array(':Email' => $email, ':Type' => $login_type, 'RawVoterID' => $RawVoterID);
		
		if ( ! empty ($firstname)) { $sql .= ", SystemUser_FirstName = :FirstName";	$sql_vars[":FirstName"] = $firstname;	}
		if ( ! empty ($lastname)) {	$sql .= ", SystemUser_LastName = :LastName"; $sql_vars[":LastName"] = $lastname;	}
		
		$this->_return_nothing($sql,  $sql_vars);
		
		$sql = "SELECT LAST_INSERT_ID() as SystemUser_ID";
		return $this->_return_simple($sql);
	}
	
	function SaveEmailNYSID($email, $NYSID, $reason = "interested") {
		$sql = "INSERT SystemUserVoter SET Raw_Voter_UniqNYSVoterID = :NYSID, SystemUserVoter_Email = :email, SystemUserVoter_Action = :action, SystemUserVoter_Date = NOW()";
		$sql_vars = array('email' => $email, 'NYSID' => $NYSID, 'action' => $reason);
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	function AddEmailWithNYSID($email, $login_type = "password", $firstname = null, $lastname = null, $NYSID = null, $reason = null, $EDAD = null) {
		$IDEmail = $this->CheckEmail($email);
			
		if (empty ($IDEmail)) {
			$IDEmail = $this->SaveEmailWithNYSID($email, $login_type, $firstname, $lastname, $NYSID, $EDAD);
		}
		
		$sql = "INSERT INTO SystemUserVoter SET SystemUser_ID = :IDEmail, Raw_Voter_UniqNYSVoterID = :NYSID, " . 
						"SystemUserVoter_Action = :Action, SystemUserVoter_Date = NOW()";
		$sql_vars = array('IDEmail' => $IDEmail["SystemUser_ID"], 'NYSID' => $NYSID, 'Action' => $reason);
		
		$this->_return_nothing($sql,  $sql_vars);
		return $IDEmail;
	}
	
	function SaveEmailWithNYSID($email, $login_type = "password", $firstname = null, $lastname = null, $NYSID = null, $EDAD = null) {
		$sql = "INSERT INTO SystemUser SET SystemUser_email = :Email, SystemUser_EDAD = :EDAD, SystemUser_loginmethod = :Type, Raw_Voter_UniqNYSVoterID = :NYSID, SystemUser_createtime = NOW()";	
		$sql_vars = array(':Email' => $email, ':Type' => $login_type, 'NYSID' => $NYSID, 'EDAD' => $EDAD);
		
		if ( ! empty ($firstname)) { $sql .= ", SystemUser_FirstName = :FirstName";	$sql_vars[":FirstName"] = $firstname;	}
		if ( ! empty ($lastname)) {	$sql .= ", SystemUser_LastName = :LastName"; $sql_vars[":LastName"] = $lastname;	}
		
		$this->_return_nothing($sql,  $sql_vars);
		
		$sql = "SELECT LAST_INSERT_ID() as SystemUser_ID";
		return $this->_return_simple($sql);
	}
		
	function UpdateSystemGoogleMapsApiKey($SystemUser_ID, $apikey) {
		$sql = "UPDATE SystemUser SET SystemUser_googleapimapid = :apikey WHERE SystemUser_ID = :ID";
		$sql_vars = array(':apikey' => $apikey, ':ID' => $SystemUser_ID);
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	function AddEmailUsernamePassword($Email, $Username, $Password, $hashtable = "") {
		$HashPass = password_hash($Password, PASSWORD_DEFAULT);
		
		$sql = "INSERT INTO SystemTemporaryUser SET SystemTemporaryUser_username = :username, " . 
						"SystemTemporaryUser_password = :password, SystemTemporaryUser_email = :Email, SystemTemporaryUser_createtime = NOW()";
		$sql_vars = array(':username' => $Username, ':password' => $HashPass, 
											'Email' => $Email);
		
		if ( ! empty ($hashtable)) {
			$sql .= ", SystemTemporaryUser_emaillinkid = :Hash ";
			$sql_vars["Hash"] = $hashtable;
		}		
		
		$this->_return_nothing($sql,  $sql_vars);

		$sql = "SELECT LAST_INSERT_ID() as SystemTemporaryUser_ID";
		return $this->_return_simple($sql);
	
	}
	
	
	function UpdateUsernamePassword($SystemUser_ID, $username, $password, $hashtable = "") {
		
		$HashPass = password_hash($password, PASSWORD_DEFAULT);
		
		$sql = "UPDATE SystemUser SET SystemUser_username = :username, SystemUser_password = :password ";
		$sql_vars = array(':username' => $username, ':password' => $HashPass, ':ID' => $SystemUser_ID);
		
		if ( ! empty ($hashtable)) {
			$sql .= ", SystemUser_emaillinkid = :Hash ";
			$sql_vars["Hash"] = $hashtable;
		}		
	
		$sql .= "WHERE SystemUser_ID = :ID";	
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	function ReturnPetitionSet($SystemUser_ID) {
		$sql = "SELECT * FROM CandidatePetitionSet WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array("SystemUserID" => $SystemUser_ID);		
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function UpdateHash($SystemEmail, $HashLink) {
		
		if ( $HashLink == "null") {
			$sql = "UPDATE SystemUser SET SystemUser_emaillinkid = null WHERE SystemUser_email = :Email";
			$sql_vars = array(':Email' => $SystemEmail);
		} else {
			$sql = "UPDATE SystemUser SET SystemUser_emaillinkid = :Hash WHERE SystemUser_email = :Email";
			$sql_vars = array(':Email' => $SystemEmail, ':Hash' => $HashLink);
		}
		
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	function UpdateUsernameHash($SystemUsername, $HashLink) {
		
		if ( $HashLink == "null") {
			$sql = "UPDATE SystemUser SET SystemUser_emaillinkid = null WHERE SystemUser_username = :Username";
			$sql_vars = array(':Username' => $SystemUsername);
		} else {
			$sql = "UPDATE SystemUser SET SystemUser_emaillinkid = :Hash WHERE SystemUser_username = :Username";
			$sql_vars = array(':Username' => $SystemUsername, ':Hash' => $HashLink);
		}
		
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	function FindFromEmailHashkey($SystemEmail, $HashLink) {
		$sql = "SELECT * FROM SystemUser WHERE SystemUser_emaillinkid = :Hash AND SystemUser_email = :Email";
		$sql_vars = array(':Email' => $SystemEmail, ':Hash' => $HashLink);
		$ret = $this->_return_simple($sql,  $sql_vars);
		
		if ( ! empty ($ret)) {
			$HashLink = "null";
			$this->UpdateHash($SystemEmail, $HashLink);
		}
		
		return $ret;		
	}
	
	function VerifyAccount($SystemUser_ID) {
		$sql = "UPDATE SystemUser SET SystemUser_emailverified = 'yes', SystemUser_emaillinkid = null " . 
						"WHERE SystemUser_ID = :ID";
		$sql_vars = array("ID" => $SystemUser_ID);
		return $this->_return_nothing($sql, $sql_vars);
	}
	
	function FindRawVoterInfoFromSystemID($SystemUser_ID, $DateFileID, $DateFileName) {
		$sql = "SELECT * FROM SystemUserVoter " .
						"LEFT JOIN Raw_Voter_TrnsTable ON (Raw_Voter_TrnsTable.Raw_Voter_TrnsTable_ID = SystemUserVoter.Raw_Voter_ID) " .
						"LEFT JOIN Raw_Voter_" . $DateFileName . 
						" ON (Raw_Voter_" . $DateFileName . ".Raw_Voter_ID = Raw_Voter_TrnsTable.Raw_Voter_TableDate_ID) " .
						"WHERE SystemUser_ID = :ID AND Raw_Voter_Dates_ID = :DatedID";
		$sql_vars = array("ID" => $SystemUser_ID, "DatedID" => $DateFileID);
		return $this->_return_simple($sql, $sql_vars);				
	}
	
	function FindLocalRawVoter($RawVoterID) {
		$slq = "SELECT * FROM Raw_Voter WHERE Raw_Voter_ID = :ID";
		$sql_vars = array("Raw_Voter_ID" => $RawVoterID);
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function FindLocalRawVoterFromDatedFile($RawVoterID, $DatedFiles) {
		$sql = "SELECT * FROM NYSVoters.Raw_Voter " . 
						"LEFT JOIN Raw_Voter_Dates ON (Raw_Voter.Raw_Voter_Dates_ID = Raw_Voter_Dates.Raw_Voter_Dates_ID) " . 
						"WHERE Raw_Voter.Raw_Voter_TableDate_ID = :RawVoter AND Raw_Voter_Dates_Date = :DatedFiles";
		$sql_vars = array("RawVoter" => $RawVoterID, "DatedFiles" => $DatedFiles);
		return $this->_return_simple($sql, $sql_vars);				
	}
	
	function FindCandidateInfo($SystemUserID) {
		$sql = "SELECT * FROM Candidate WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array("SystemUserID" => $SystemUserID);
		return $this->_return_simple($sql, $sql_vars);	
	} 
	
	function CheckUsernamePassword($Username, $Password) {
		$sql = "SELECT * FROM SystemUser WHERE SystemUser_username = :Username";	
		$sql_vars = array("Username" => $Username);
		$result = $this->_return_simple($sql, $sql_vars);	
		$ResultPasswordCheck = password_verify ($Password , $result["SystemUser_password"]);
		
		
		if ( $ResultPasswordCheck == 0 ) {
			$sql = "SELECT * FROM SystemTemporaryUser WHERE SystemTemporaryUser_username = :Username";
			$result = $this->_return_simple($sql, $sql_vars);	
			$ResultPasswordCheck = password_verify ($Password , $result["SystemTemporaryUser_password"]);
		}

		if ( $ResultPasswordCheck == 1) {
			// Update Login Time
			$sql = "INSERT INTO SystemUserLastLogin SET SystemUser_ID = :ID, SystemUserLastLogin  = NOW()";
			$sql_vars = array("ID" => $result["SystemUser_ID"]);
			$this->_return_nothing($sql, $sql_vars);
			return $result;
		}
		return null;
	}
	
	function MovedSystemUserToMainTable($TempEmail, $TypeEmailVerif) {
		$sql = "INSERT INTO SystemUser (SystemUser_email, SystemUser_emailverified, SystemUser_username, SystemUser_password, " . 
																		"SystemUser_createtime, SystemUser_lastlogintime, SystemUser_Priv"; 
		$sql .= ") " .
					 "SELECT SystemTemporaryUser_email, :TypeEmail, SystemTemporaryUser_username, " . 
									"SystemTemporaryUser_password, NOW(), NOW(), " . (PERM_MENU_PROFILE + PERM_MENU_SUMMARY);
		$sql .= " FROM SystemTemporaryUser WHERE SystemTemporaryUser_email = :TempEmail"; 
		$sql_vars = array("TempEmail" => $TempEmail, "TypeEmail" => $TypeEmailVerif);																	
		$this->_return_nothing($sql, $sql_vars);		
	
		$sql = "SELECT LAST_INSERT_ID() as SystemUser_ID";
		$ret = $this->_return_simple($sql);

		$sql = "UPDATE SystemTemporaryUser SET SystemUser_ID = :SystemUserID,  SystemTemporaryUser_password = null, " . 
						"SystemTemporaryUser_emaillinkid = null WHERE SystemTemporaryUser_email = :TempEmail"; 
		$sql_vars = array("TempEmail" => $TempEmail, "SystemUserID" => $ret["SystemUser_ID"]);
		$this->_return_nothing($sql, $sql_vars);	
		
		$this->SaveInscriptionRecord ($TempEmail, $Username, "convert", $ret["SystemUser_ID"]);	
		return $this->FindPersonUserProfile($ret["SystemUser_ID"]);
	}
	
	function FindPersonUserProfile($SystemUserID) {
		$sql = "SELECT * FROM SystemUser " . 
						"LEFT JOIN SystemUserProfile ON (SystemUser.SystemUserProfile_ID = SystemUserProfile.SystemUserProfile_ID) " . 
						"WHERE SystemUser_ID = :ID";	
		$sql_vars = array(':ID' => $SystemUserID);											
		return $this->_return_simple($sql,  $sql_vars);		
	}
	
	function FindSystemUser_ID($SystemUserVoterID) {
		$sql = "SELECT * FROM SystemUser " . 
						"LEFT JOIN Raw_Voter ON (SystemUser.Raw_Voter_ID = Raw_Voter.Raw_Voter_ID) " .
						"LEFT JOIN Candidate ON (Candidate.SystemUser_ID = SystemUser.SystemUser_ID) " . 
						"WHERE SystemUser.SystemUser_ID = :SystemUserVoter";
		$sql_vars = array(':SystemUserVoter' => $SystemUserVoterID);											
		return $this->_return_multiple($sql,  $sql_vars);
	}
	
	function FindSystemUserDetails_ID($SystemUserVoterID, $DatedFiles) {
		$sql = "SELECT * FROM SystemUser " . 
						"LEFT JOIN Raw_Voter ON (SystemUser.Raw_Voter_ID = Raw_Voter.Raw_Voter_ID) " .
						"LEFT JOIN Candidate ON (Candidate.SystemUser_ID = SystemUser.SystemUser_ID) " . 
						"LEFT JOIN Raw_Voter_" . $DatedFiles . " ON (Raw_Voter_" . $DatedFiles . ".Raw_Voter_UniqNYSVoterID = Raw_Voter.Raw_Voter_UniqNYSVoterID) " . 
						"WHERE SystemUser.SystemUser_ID = :SystemUserVoter AND Raw_Voter_" . $DatedFiles .".Raw_Voter_Status = 'ACTIVE'";
		$sql_vars = array(':SystemUserVoter' => $SystemUserVoterID);											
		return $this->_return_simple($sql,  $sql_vars);
		
	}
	
	function FindCandidatesInDistrict($Value, $TableName = "EDAD") {
		$sql = "SELECT * FROM Candidate WHERE CandidateElection_DBTable = :TableName AND CandidateElection_DBTableValue = :Value";
		$sql_vars = array("TableName" => $TableName, "Value" => $Value);
		return $this->_return_multiple($sql,  $sql_vars);
	}
	
	
}


?>
