<?php	  	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

global $DB;
class NoLog extends RepMyBlock {
  
   function AreaPetition ($ElectionID, $Type) {
		$sql = "SELECT CandidateElection.ElectionsPosition_ID, CandidateElection_Party, Candidate.CandidateElection_DBTableValue, " . 
						"COUNT(Candidate.CandidateElection_DBTableValue) AS TOTAL FROM Candidate " . 
						"LEFT JOIN CandidateElection on (Candidate.CandidateElection_ID = CandidateElection.CandidateElection_ID) " . 
						"WHERE Elections_ID = :ElectionID AND Candidate.CandidateElection_DBTable = :Type AND " . 
						"Candidate.CandidateElection_DBTableValue != \"XXXXX\" AND Candidate_UniqStateVoterID IS NOT NULL " . 
						"AND CandidateElection.ElectionsPosition_ID IS NOT NULL " . 
						"GROUP BY Candidate.CandidateElection_DBTableValue, CandidateElection_Party, ElectionsPosition_ID " .
						"ORDER BY CandidateElection_Party, CandidateElection_DBTableValue";
		$sql_vars = array("ElectionID" => $ElectionID, "Type" => $Type);
	 	return $this->_return_multiple($sql, $sql_vars);
	}
	
}
?>

