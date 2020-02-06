<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

global $DB;

class RMB_newyork extends RepMyBlock {
				
	function GetElectionInfo_NewYork_CountyCommittee($Party, $Gender, $EDAD) {		
		$sql = "SELECT * FROM CandidateElection " .
						"LEFT JOIN Candidate ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " .
						"WHERE " . 
						"CandidateElection.CandidateElection_DBTable = 'EDAD' AND " .
						"CandidateElection.CandidateElection_DBTableValue	= :EDAD AND " .
						"CandidateElection.CandidateElection_Party = :Party";
										
		$sql_vars = array(':EDAD' => $EDAD, ':Party' => $Party);											
		return $this->_return_multiple($sql, $sql_vars);
	}		
	
	function InsertCandidate_NewYork_CountyCommittee($SystemUser_ID, $Voter_ID, $DatedFiles, $DatedFilesID, 
																										$CandidateElection_ID, $EDAD, $EnrollPolParty, 
																										$PetitionName, $PetitionAddress) {
		$sql = "INSERT INTO Candidate SET " .
							"SystemUser_ID = :SystemUserID, Raw_Voter_ID = :RawVoterID, Raw_Voter_DatedTable_ID = :DateFiles, " .
							"Raw_Voter_Dates_ID = :DateID, CandidateElection_ID = :CandidateElectionID, Candidate_Party = :Party, " .
							"Candidate_DispName = :FullName, Candidate_DispResidence = :Address, CandidateElection_DBTable = 'EDAD', " . 
							"CandidateElection_DBTableValue = :EDAD, Candidate_Status = 'published'";
		$sql_vars = array("SystemUserID" => $SystemUser_ID, "RawVoterID" => $Voter_ID, "DateFiles" => $DatedFiles,
											"DateID" => $DatedFilesID, "CandidateElectionID" => $CandidateElection_ID, "Party" => $EnrollPolParty, 
											"FullName" => $PetitionName, "Address" => $PetitionAddress, "EDAD" => $EDAD);
		$this->_return_nothing($sql, $sql_vars);
		
		$sql = "SELECT LAST_INSERT_ID() AS Candidate_ID";
		$ret = $this->_return_simple($sql);
		$Candidate_ID = $ret["Candidate_ID"];
		
		$sql = "INSERT INTO CandidatePetitionSet SET SystemUser_ID = :SystemUserID, CandidatePetitionSet_TimeStamp = NOW()";
		$sql_vars = array("SystemUserID" => $SystemUser_ID);
		$this->_return_nothing($sql, $sql_vars);
		
		$sql = "SELECT LAST_INSERT_ID() AS CandidatePetitionSet_ID";
		$ret = $this->_return_simple($sql);
		$CandidatePetitionSet_ID = $ret["CandidatePetitionSet_ID"];
		
		$sql = "INSERT INTO CanPetitionSet SET CandidatePetitionSet_ID = :CandidatePetitionSetID, Candidate_ID = :CandidateID";
		$sql_vars = array("CandidatePetitionSetID" => $CandidatePetitionSet_ID, "CandidateID" => $Candidate_ID);
		$this->_return_nothing($sql, $sql_vars);
		
		return $Candidate_ID;
	}	
}

?>

