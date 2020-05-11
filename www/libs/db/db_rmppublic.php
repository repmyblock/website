<?php	  	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class RMBPublic extends queries {

  function RMBPublic ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	  $this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
  function InsertQuestions($FirstName, $LastName, $ZipCode, $EmailAddress, $Text) {
		$sql = "INSERT INTO DebateQuestions SET DebateQuestions_FirstName = :FirstName, " .
					"DebateQuestions_LastName = :LastName, DebateQuestions_ZipCode = :ZipCode, " . 
					"DebateQuestions_EmailAddress = :EmailAddress, DebateQuestions_Text = :Question, " .
					"DebateQuestions_Date = NOW(), DebateQuestions_IP = :IP";
		$sql_vars = array(':FirstName' => $FirstName, ':LastName' => $LastName, ':ZipCode' => $ZipCode,
											':EmailAddress' => $EmailAddress, ':Question' => $Text, ':IP' => $_SERVER['REMOTE_ADDR']);											
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	
	
	
}

?>

