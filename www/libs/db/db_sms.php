<?php	  	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class sms extends queries {

  function sms ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	  $this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
  function ListSMSProviderInfo($SystemUser_ID, $Candidate_ID = 0) {
  	$sql = "SELECT * FROM NYSVoters.SMSPopInfo WHERE SystemUser_ID = :SysID";
  	$sql_vars = array("SysID" => $SystemUser_ID);
  	return $this->_return_multiple($sql, $sql_vars);
  }
  
  
	function SaveSMSReturn($message, $from, $to,  $direction, $whole) {
		switch ($direction) {
			case "outbound": $dir = "outbound";	break;
			case "inbound": $dir = "inbound";	break;
			default: $dir = NULL;
		}
		
		$sql = "INSERT INTO SMSText SET SMSText_PhoneFrom = :From, SMSText_PhoneTo = :To, " . 
						"SMSText_Text = :msg, SMSText_direction = :dir, SMSText_WholeJSON = :json, SMSText_DateWriten = NOW()";
		$sql_vars = array("From" => $from, "To" => $to, "json" => $whole, "msg" => $message, "dir" => $dir );
		return $this->_return_nothing($sql, $sql_vars);
	}
	
	function ListSMSCampaignsBySystemUser($SystemUser) {		  
  	$sql = "SELECT * FROM SMSAuthorizedUsers " . 
  					"LEFT JOIN SMSCampaign ON (SMSAuthorizedUsers.SMSCampaign_ID = SMSAuthorizedUsers.SMSCampaign_ID) " .
  					"LEFT JOIN Candidate ON (SMSCampaign.Candidate_ID = Candidate.Candidate_ID) " .
  					"WHERE SMSAuthorizedUsers.SystemUser_ID = :SysID " .  					
  					"AND " . 
  					"SMSAuthorizedUsers_FromDate < NOW() AND SMSAuthorizedUsers_ToDate is NULL";
  	$sql_vars = array("SysID" => $SystemUser);
  	return $this->_return_multiple($sql, $sql_vars);
	}
	
	function FindRawVoter($UniqID, $DatedFile) {
		$sql = "SELECT * FROM Raw_Voter_" . $DatedFile . " " .
						"WHERE Raw_Voter_UniqNYSVoterID = :Uniq";
		$sql_vars = array("Uniq" => $UniqID);
  	return $this->_return_simple($sql, $sql_vars);
	}
	
	function ListTextMessage($Telephone) {
		WriteStderr($Telephone, "Telephone in DB File");					
		$sql = "SELECT * FROM SMSText " . 
						"WHERE SMSText_PhoneTo = :Telephone ORDER BY SMSText_DateWriten";
		$sql_vars = array("Telephone" => $Telephone);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	
	function ListInboundText() {
		$sql = "SELECT * FROM SMSText " . 
//						"LEFT JOIN SMSVerifyPhone ON (SMSVerifyPhone.SMSVerifyPhone_Number = SMSText.SMSText_PhoneTo) " .
						"WHERE SMSText_direction = 'inbound' ORDER BY SMSText_DateWriten";
		
		return $this->_return_multiple($sql);
	}
	
  
	function ListInboundSMSByCampaign($CampaignID) {
		$sql = "SELECT * FROM NYSVoters.SMSText WHERE SMSCampaign_ID = :CampaignID";
		$sql_vars = array("CampaignID" => $CampaignID);
		return $this->_return_multiple($sql, $sql_vars);
	}
}

?>

