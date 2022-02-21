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
  
  function RegisterUser($Username, $Email, $Password, $Type, $Refer = NULL, $MailRef = NULL, $VerifEmail = "no") {
  	
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
  	$sql = "SELECT * FROM SystemUserTemporary WHERE SystemUserTemporary_email = :Email OR SystemUserTemporary_username = :Username";
		$ret = $this->_return_multiple($sql,  $sql_vars);
		
		if (! empty($ret)) {
			if ($ret[0][SystemUserTemporary_email] == $Email || $ret[1][SystemUserTemporary_email] == $Email) { $error["EMAIL"] = 1; }
			if ($ret[0][SystemUserTemporary_username] == $Username || $ret[1][SystemUserTemporary_username] == $Username) { $error["USERNAME"] = 1; }
			return $error;
		}
		
		if ( empty($ret)) {
			$ret = $this->AddEmailUsernamePassword($Email, $Username, $Password, $hashtable, $Refer, $MailRef, $VerifEmail);		
			if ( empty ($ret["SystemUserTemporary_ID"])) {
				return array("Problem" => "Problem saving the Email");
			}
		}
		
		$sql = "SELECT * FROM SystemUserTemporary WHERE SystemUserTemporary_ID = :ID";
		$sql_vars = array('ID' => $ret["SystemUserTemporary_ID"]);
		$ret = $this->_return_simple($sql,  $sql_vars);

		return $ret;	  	
  }

	function SaveInscriptionRecord ($Email, $Username, $Type = "Other", $SystemUserID = NULL) {
		$sql = "INSERT INTO SystemUserVoter SET SystemUserVoter_Username = :Username, " .
						"SystemUserVoter_Email = :Email, SystemUserVoter_action = :Type, " . 
						"SystemUserVoter_Date = NOW(), SystemUserVoter_IP = :IP, SystemUser_ID = :SystemUserID";
		$sql_vars = array('Email' => $Email, 'Username' => $Username, 'Type' => $Type, 
											'IP' => $_SERVER['REMOTE_ADDR'], 'SystemUserID' => $SystemUserID);
		$this->_return_nothing($sql,  $sql_vars);
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
		$sql = "SELECT * FROM SystemUserTemporary " . 
						"LEFT JOIN SystemUser ON (SystemUser.SystemUser_ID = SystemUserTemporary.SystemUser_ID) " . 
						"WHERE SystemUserTemporary_username = :Username";
		$sql_vars = array(':Username' => $Username);			
		
		$ret = $this->_return_simple($sql, $sql_vars);
		if ( ! empty ($ret)) return $ret;
		
		$sql = "SELECT * FROM SystemUser WHERE SystemUser_username = :Username";								
		return $this->_return_simple($sql,  $sql_vars);
	}
	
	function CheckBothSystemUserTable ($InTake, $TypeID = NULL) {
		
		print "InTake: $InTake<BR>";
		
		$ret = $this->CheckSystemUserTable($InTake, $TypeID);
		
		print "Found in normal window: <PRE>--->" . print_r($ret, 1) . "<----</PRE>";
		
		
		if ( empty ($ret)) {
			print "Gone in the Temporary windows with TYpe ID: $TypeID<BR>";
			$ret = $this->CheckSystemUserTempTable($InTake, $TypeID);
			print "Found in temporary window: <PRE>" . print_r($ret, 1) . "</PRE>";
		}
		
		print "Found in temporary window: <PRE>" . print_r($ret, 1) . "</PRE>";
		
		exit();
		return $ret;
	}
	
	function CheckSystemUserTempTable ($Intake, $TypeID = NULL) {
		if ( ! empty ($TypeID)) {
			$sql = "SELECT * FROM SystemUserTemporary WHERE ";
			$sql_vars = array("Intake" => $Intake);
			switch($TypeID) {
				case "Email": $sql .= "SystemUserTemporary_email = :Intake"; break;
				case "ID": $sql .= "SystemUserTemporary_ID = :Intake"; break;
				default: return;
			}
			return $this->_return_simple($sql, $sql_vars);
		}
	}
	
	function CheckSystemUserTable ($Intake, $TypeID = NULL) {
		
		print "<FONT COLOR=RED>Intake: $Intake <BR> TypeID: $TypeID<BR></font>";
		
		if ( ! empty ($TypeID)) {
			$sql = "SELECT * FROM SystemUser WHERE ";
			$sql_vars = array("Intake" => $Intake);
			switch($TypeID) {
				case "Email": $sql .= "SystemUser_email = :Intake"; break;
				case "ID": $sql .= "SystemUser_ID = :Intake"; break;
				default: return;
			}
			
			print "SSQL: $sql<BR>";
			
			return $this->_return_simple($sql, $sql_vars);			
		}
	}
	
	function UpdateSystemGoogleMapsApiKey($SystemUser_ID, $apikey) {
		$sql = "UPDATE SystemUser SET SystemUser_googleapimapid = :apikey WHERE SystemUser_ID = :ID";
		$sql_vars = array(':apikey' => $apikey, ':ID' => $SystemUser_ID);
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	function SearchEmailFromIntake($IntakeID, $TypeID = "MailCode") {
		$sql = "SELECT * FROM SystemUserEmail WHERE ";
		$sql_vars = array("Intake" => $IntakeID);
		
		switch($TypeID) {
			case "MailCode": $sql .= "SystemUserEmail_MailCode = :Intake"; break;
			case "ID": $sql .= "SystemUserEmail_ID = :Intake"; break;
			default: return;
		}

		return $this->_return_simple($sql, $sql_vars);
	}
	
	function AddEmailUsernamePassword($Email, $Username, $Password, $hashtable = NULL, $reference = NULL, 
																		$MailRef = NULL, $EmailVerif = "no") {
		$HashPass = password_hash($Password, PASSWORD_DEFAULT);
		
		$sql = "INSERT INTO SystemUserTemporary SET SystemUserTemporary_username = :username," . 
						"SystemUserTemporary_password = :password, SystemUserTemporary_email = :Email," .
						"SystemUserTemporary_emailverified = :EmailVerif,";
						
		$sql_vars = array(':username' => $Username, ':password' => $HashPass, 
											'Email' => $Email, "EmailVerif" => $EmailVerif);
		
		if ( ! empty ($hashtable)) {
			$sql .= "SystemUserTemporary_emaillinkid = :Hash,";
			$sql_vars["Hash"] = $hashtable;
		}		
		
		if ( ! empty ($reference)) {
			$sql .= "SystemUserTemporary_reference = :Refer,";
			$sql_vars["Refer"] = $reference;
		}		
		
		if ( ! empty ($reference)) {
			$sql .= "SystemUserTemporary_mailID = :MailRef,";
			$sql_vars["MailRef"] = $MailRef;
		}		
		
		$sql .= "SystemUserTemporary_createtime = NOW()";
		
		$this->_return_nothing($sql,  $sql_vars);

		$sql = "SELECT LAST_INSERT_ID() as SystemUserTemporary_ID";
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
		$sql = "SELECT * FROM CandidateSet WHERE SystemUser_ID = :SystemUserID";
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
			$sql = "SELECT * FROM SystemUserTemporary WHERE SystemUserTemporary_username = :Username";
			$result = $this->_return_simple($sql, $sql_vars);	
			$ResultPasswordCheck = password_verify ($Password , $result["SystemUserTemporary_password"]);
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
					 "SELECT SystemUserTemporary_email, :TypeEmail, SystemUserTemporary_username, " . 
									"SystemUserTemporary_password, NOW(), NOW(), " . (PERM_MENU_PROFILE + PERM_MENU_SUMMARY);
		$sql .= " FROM SystemUserTemporary WHERE SystemUserTemporary_email = :TempEmail"; 
		$sql_vars = array("TempEmail" => $TempEmail, "TypeEmail" => $TypeEmailVerif);																	
		$this->_return_nothing($sql, $sql_vars);		
	
		$sql = "SELECT LAST_INSERT_ID() as SystemUser_ID";
		$ret = $this->_return_simple($sql);

		$sql = "UPDATE SystemUserTemporary SET SystemUser_ID = :SystemUserID,  SystemUserTemporary_password = null, " . 
						"SystemUserTemporary_emaillinkid = null WHERE SystemUserTemporary_email = :TempEmail"; 
		$sql_vars = array("TempEmail" => $TempEmail, "SystemUserID" => $ret["SystemUser_ID"]);
		$this->_return_nothing($sql, $sql_vars);	
		
		$this->SaveInscriptionRecord ($TempEmail, $Username, "convert", $ret["SystemUser_ID"]);	
		return $this->FindPersonUserProfile($ret["SystemUser_ID"]);
	}
	
	function UpdateTemporaryEmailVerification($ID, $Type) {
		if ($ID > 0) {
			$sql = "UPDATE SystemUserTemporary SET SystemUserTemporary_emailverified = :Type ";
			
			if ( $Type == "both") {
				$sql .= ", SystemUserTemporary_emaillinkid = null ";
			}
			
			$sql .= "WHERE SystemUserTemporary_ID = :ID";
			$sql_vars = array("ID" => $ID, "Type" => $Type);
			return $this->_return_nothing($sql, $sql_vars);
		}
	}
	
	function UpdateEmailVerification($ID, $Type) {
		if ($ID > 0) {
			$sql = "UPDATE SystemUser SET SystemUser_emailverified = :Type ";
			if ( $Type == "both") {
				$sql .= ", SystemUser_emaillinkid = null ";
			}
			$sql .= "WHERE SystemUser_ID = :ID";
			$sql_vars = array("ID" => $ID, "Type" => $Type);
			return $this->_return_nothing($sql, $sql_vars);
		}
	}
	
	function FindPersonUserProfile($SystemUserID) {
		$sql = "SELECT * FROM SystemUser " . 
						"LEFT JOIN SystemUserProfile ON (SystemUser.SystemUserProfile_ID = SystemUserProfile.SystemUserProfile_ID) " . 
						"WHERE SystemUser_ID = :ID";	
		$sql_vars = array(':ID' => $SystemUserID);											
		return $this->_return_simple($sql,  $sql_vars);		
	}
	
 	function FindPersonUserTemp($SystemUserID) {
  	$sql = "SELECT * FROM SystemUserTemporary " . 
  					"LEFT JOIN SystemUser ON (SystemUser.SystemUser_ID = SystemUserTemporary.SystemUser_ID) " . 	
  					"WHERE SystemUserTemporary_ID = :ID";
  	$sql_vars = array(':ID' => $SystemUserID);											
		return $this->_return_simple($sql,  $sql_vars);
  }
		
	function FindCandidatesInDistrict($Value, $TableName = "EDAD") {
		$sql = "SELECT * FROM Candidate WHERE CandidateElection_DBTable = :TableName AND CandidateElection_DBTableValue = :Value";
		$sql_vars = array("TableName" => $TableName, "Value" => $Value);
		return $this->_return_multiple($sql,  $sql_vars);
	}
	
	
}
?>
