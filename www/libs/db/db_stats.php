<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class stats extends queries {

  function stats ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	 	$this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
	function CandidatesStats() {
		$sql = "SELECT * FROM Candidate " . 
						"LEFT JOIN CandidateElection ON (Candidate.CandidateElection_ID = CandidateElection.CandidateElection_ID) " .
						"LEFT JOIN GeoDesc ON (GeoDesc.GeoDesc_Abbrev = CandidateElection.CandidateElection_DBTableValue) " . 
						"WHERE CandidateElection.CandidateElection_DBTable = :DBTableType " . 
						"ORDER BY CandidateElection.CandidateElection_DBTableValue";
		$sql_vars = array('DBTableType' => "EDAD");											
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function CandidatePetitions() {
		$sql = "SELECT * FROM Candidate " . 
						"LEFT JOIN CandidateElection ON (Candidate.CandidateElection_ID = CandidateElection.CandidateElection_ID) " .
						"WHERE CandidateElection.CandidateElection_DBTable != \"EDAD\" ";
		return $this->_return_multiple($sql);
	}
	
	function CountSignaturesRequired($AD = NULL, $ED = NULL) {
		$sql = "SELECT AssemblyDistr, ElectDistr, " . 
						"COUNT(IF(EnrollPolParty = 'DEM' AND Status = 'A',1 , NULL)) AS 'DEM Active', " . 
						"COUNT(IF(EnrollPolParty = 'DEM' ,1 , NULL)) AS DEM, " .
						"(CEILING(COUNT(IF(EnrollPolParty = 'DEM' AND Status = 'A',1 , NULL)) * .05)) AS 'DEM Sigs', " . 
						"COUNT(IF(EnrollPolParty = 'REP' AND Status = 'A',1 , NULL)) AS 'REP Active' ,  " . 
						"COUNT(IF(EnrollPolParty = 'REP',1 , NULL)) AS REP, " . 
						"(CEILING(COUNT(IF(EnrollPolParty = 'REP' AND Status = 'A',1 , NULL)) * .05)) AS 'REP Sigs', " . 
						"COUNT(EnrollPolParty) AS TOTAL " . 
						"FROM RepMyBlock.VotersRaw_NY " . 
						"WHERE (Status = 'A' OR Status = 'I') " .  
						"GROUP BY AssemblyDistr, ElectDistr";
		$sql_vars = array();											
		return $this->_return_multiple($sql, $sql_vars);	
	}
	
}
?>
