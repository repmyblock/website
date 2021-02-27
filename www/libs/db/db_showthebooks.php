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
 	
 	function ListCandidatesByParty($party, $position) {
 	
 		$sql = "SELECT * FROM Candidate ";
 		$and = "";
 		
 		if (! empty ($party)) {
 			$sql .= "WHERE ";
 			$sql .= " Candidate_Party = :Party";
 			$sql_vars["Party"] = $party;
 			$and = " AND";
 		}
 		
 		if (! empty ($position)) {
 			if ( empty ($and)) { $and = "WHERE ";}
 			$sql .= $and . " Candidate_CouncilDistrict = :Position";
 			$sql_vars["Position"] = $position;
 		}
 		
 		$sql .= " ORDER BY RAND()";
 		
 		if (! empty ($and)) {
 			return $this->_return_multiple($sql, $sql_vars);
 		} else {
 			return $this->_return_multiple($sql);
 		}
  }
 
}

?>

