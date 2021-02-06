<?php	  	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class Trac extends queries {

  function Trac ($debug = 0, $DBFile = "DB_Trac") {
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
  
  function CreateTicket($TicketArray) {
  	$sql = "INSERT INTO ticket SET " .
  					"type = :Type, time = :Time, changetime = :ChangeTime, component = :Component, severity = :Sev, " .
  					"priority = :Priority, owner = :Owner, reporter = :Reporter, cc = :Copy, version = :Version, " . 
  					"milestone = :Milestone, status = :Status, resolution = :Resolution, summary = :Summary, " .
  					"description = :Description, keywords = :Keywords";

		$sql_vars = array("Type" => $TicketArray["type"], "Time" => $TicketArray["time"], "ChangeTime" => $TicketArray["changetime"],
						"Component" => $TicketArray["component"], "Sev" => $TicketArray["severity"],	"Priority" => $TicketArray["priority"],
  					"Owner" => $TicketArray["owner"], "Reporter" => $TicketArray["reporter"], "Copy" => $TicketArray["cc"],
  					"Version" => $TicketArray["version"], "Milestone" => $TicketArray["milestone"],	"Status" => $TicketArray["status"],
  					"Resolution" => $TicketArray["resolution"],	"Summary" => $TicketArray["summary"], 
  					"Description" => $TicketArray["description"], "Keywords" => $TicketArray["keywords"]);
  		
		$this->_return_nothing($sql, $sql_vars);	 	
		
		$sql = "SELECT LAST_INSERT_ID() AS TicketID";
		return $this->_return_simple($sql);	 	
  }
}

?>

