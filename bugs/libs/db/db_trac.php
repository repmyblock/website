<?php	  	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class RepMyBlock extends queries {

  function RepMyBlock ($debug = 0, $DBFile = "DB_Trac") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	  $this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
  function ListTickets() {
  	$sql = "SELECT * FROM ticket";
  	// $sql_vars = array("SystemUserID" => $SystemUserID);
  	return $this->_return_multiple($sql);	
  }
  
  
	
}

?>

