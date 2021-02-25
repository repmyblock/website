<?php	  	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class ShowTheBooks extends queries {

  function ShowTheBooks ($debug = 0, $DBFile = "DB_ShowTheBooks") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	  $this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
  function ListCandidatesByID($id) {
  	$sql = "SELECT * FROM Candidate WHERE Candidate_ID = :ID";
  	$sql_vars["ID"] = $id;
  	
  	return $this->_return_simple($sql, $sql_vars);
  }
 	
	
}

?>

