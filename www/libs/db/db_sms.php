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
			case "outbound":
				$dir = "outbound";
				break;
			case "inbound":
				$dir = "inbound";
				break;
			default:
				$dir = NULL;
		}
		
		
		$sql = "INSERT INTO SMSText SET SMSText_PhoneFrom = :From, SMSText_PhoneTo = :To, " . 
						"SMSText_Text = :msg, SMSText_direction = :dir, SMSText_WholeJSON = :json, SMSText_DateWriten = NOW()";
		$sql_vars = array("From" => $from, "To" => $to, "json" => $whole, "msg" => $message, "dir" => $dir );
		return $this->_return_nothing($sql, $sql_vars);
	}
  
	
	
}

?>

