<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

global $DB;

class RMBdistrict extends RepMyBlock {
	function ListAllResults() {		
		$sql = "SELECT * FROM ElectResultCandidate " . 
						"LEFT JOIN Candidate ON (Candidate.Candidate_ID = ElectResultCandidate.Candidate_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " .
						"LEFT JOIN ElectResult ON (CandidateElection.CandidateElection_ID = ElectResult.CandidateElection_ID) " .
						"LEFT JOIN DataDistrict ON (ElectResult.DataDistrict_ID = DataDistrict.DataDistrict_ID) " . 
						"LEFT JOIN ElectResultAdmin ON (ElectResult.ElectResultAdmin_ID = ElectResultAdmin.ElectResultAdmin_ID) " . 
						"LEFT JOIN Elections ON (CandidateElection.Elections_ID = Elections.Elections_ID) " .
						"LEFT JOIN DataState ON (DataState.DataState_ID = Elections.DataState_ID) " .
						"";								
		$sql_vars = array();											
		return $this->_return_multiple($sql, $sql_vars);
	}		
	
	function ListResultsByEDAD($AD, $ED) {
		$sql = "SELECT * FROM DataDistrict " .
						"LEFT JOIN ElectResult ON (ElectResult.DataDistrict_ID = DataDistrict.DataDistrict_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = ElectResult.CandidateElection_ID) " .
						"LEFT JOIN Elections ON (CandidateElection.Elections_ID = Elections.Elections_ID) " .
						"LEFT JOIN ElectResultAdmin ON (ElectResult.ElectResultAdmin_ID = ElectResultAdmin.ElectResultAdmin_ID) " .
						"WHERE DataDistrict_StateAssembly = :AD AND DataDistrict_Electoral = :ED";
	
		$sql_vars = array("AD" => $AD, "ED" => $ED);											
		return $this->_return_multiple($sql, $sql_vars);
	}	
	
	function ListResultByPerson($AD, $ED) {
		$sql = "SELECT ElectResultCandidate.ElectResult_ID, DataDistrict_StateAssembly, DataDistrict_Electoral, " . 
						"Candidate_DispName, CandidateElection_Text, ElectResultCandidate_Count, Candidate_Party, Candidate_FullPartyName, " .
						"Candidate.CandidateElection_ID, Candidate.CandidateElection_DBTable, Candidate.CandidateElection_DBTableValue " . 
						"FROM RepMyBlock.ElectResultCandidate " . 
						"LEFT JOIN Candidate ON (Candidate.Candidate_ID = ElectResultCandidate.Candidate_ID) " . 
						"LEFT JOIN CandidateElection ON (Candidate.CandidateElection_ID = CandidateElection.CandidateElection_ID) " . 
						"LEFT JOIN ElectResult ON (ElectResult.ElectResult_ID = ElectResultCandidate.ElectResult_ID) " . 
						"LEFT JOIN DataDistrict ON (ElectResult.DataDistrict_ID = DataDistrict.DataDistrict_ID) " . 
						"WHERE CandidateElection.CandidateElection_ID = 251 OR " . 
						"CandidateElection.CandidateElection_ID = 406 OR CandidateElection.CandidateElection_ID = 958 " . 
						"Order by CandidateElection_ID desc, DataDistrict_StateAssembly, DataDistrict_Electoral asc, " .
						"ElectResultCandidate_Count desc" ;

		$sql_vars = array("AD" => $AD, "ED" => $ED);											
		return $this->_return_multiple($sql, $sql_vars);
	}	
	
	function FindCandidatesResultByPerson($FullName) {	
		$sql = "SELECT DISTINCT  * FROM  Candidate " . 
						"LEFT JOIN CandidateElection ON (Candidate.CandidateElection_ID = CandidateElection. CandidateElection_ID) " . 
						"WHERE Candidate_DispName like :LastName";
		
		$sql_vars = array("LastName" => $FullName);											
		return $this->_return_multiple($sql, $sql_vars);
	}
}
?>

