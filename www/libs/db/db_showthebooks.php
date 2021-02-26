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
  
  function ListCandidates() {
  	$sql = "SELECT * FROM Candidate ORDER BY RAND()";
  	return $this->_return_multiple($sql);
  }
 	
	
}

?>

