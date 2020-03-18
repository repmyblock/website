<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class OutragedDems extends queries {

  function OutragedDems ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	  	  $this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
  function UpdateCandidatePetitionHash($NYS, $Candidate_LocalHash) {
  	$sql = "UPDATE Candidate SET Candidate_LocalHash = NULL " .
  					"WHERE Candidate_UniqNYSVoterID = :NYS AND Candidate_LocalHash = :LocalHash";
  	$sql_vars = array('NYS' => $NYS, 'LocalHash' => $Candidate_LocalHash);											
		return $this->_return_multiple($sql,  $sql_vars);
	}
     
  function ListCandidatePetitionByHash($NYS, $Candidate_LocalHash) { 	
		$sql = "SELECT * FROM Candidate " . 
						"LEFT JOIN CandidatePetition ON (CandidatePetition.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " .
						"LEFT JOIN Raw_Voter_Dates ON (Raw_Voter_Dates.Raw_Voter_Dates_ID = Candidate.Raw_Voter_Dates_ID) " .
						"WHERE Candidate_UniqNYSVoterID = :NYS AND Candidate_LocalHash = :LocalHash";
		
		$sql_vars = array('NYS' => $NYS, 'LocalHash' => $Candidate_LocalHash);											
		return $this->_return_multiple($sql,  $sql_vars);
	}
	
	function GetListAddresses($DatedFiles, $ResHouseNumber, $ResStreetName, $ResZip, $ResApt = NULL) {
		$TableVoter = "Raw_Voter_" . $DatedFiles;

		$sql = "SELECT * FROM " . $TableVoter . " WHERE " . 
						"Raw_Voter_ResHouseNumber = :Number AND " .
						"Raw_Voter_ResStreetName = :Name AND " .
						"Raw_Voter_ResZip = :ZIP";
		$sql_vars = array("Number" => $ResHouseNumber, "Name" => $ResStreetName, "ZIP" => $ResZip);	 					
		return $this->_return_multiple($sql,  $sql_vars); 	
	}

	
	function FindRawVoterbyID($DatedFiles, $VoterID) {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " WHERE Raw_Voter_ID = :VoterID";	
		$sql_vars = array('VoterID' => $VoterID);											
		return $this->_return_multiple($sql,  $sql_vars);
	}
	
	function FindRawVoterbyADED($DatedFiles, $EDDist, $ADDist, $Party, $order = 0) {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " WHERE Raw_Voter_AssemblyDistr = :AssDist AND Raw_Voter_EnrollPolParty = :Party";	
		$sql_vars = array('AssDist' => $ADDist, 'Party' => $Party);		
		
		if ( ! empty ($EDDist)) {
			$sql .= " AND Raw_Voter_ElectDistr = :EleDist";
			$sql_vars["EleDist"] = $EDDist;		
		}		
		
		if ( $order > 0) {
			$sql .= " ORDER BY Raw_Voter_ResStreetName, Raw_Voter_ResHouseNumber, Raw_Voter_ResApartment";
		}
			
		return $this->_return_multiple($sql,  $sql_vars);		
	}
	
	function ListPetitionSet($CanPetitionSet_ID) {
		$sql = "SELECT * FROM CanPetitionSet " .
						"LEFT JOIN Candidate ON (CanPetitionSet.Candidate_ID = Candidate.Candidate_ID) " . 
						"LEFT JOIN DataCounty ON (DataCounty.DataCounty_ID = CanPetitionSet.DataCounty_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " . 
						"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
						"LEFT JOIN CanWitnessSet ON (CanWitnessSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateWitness ON (CandidateWitness.CandidateWitness_ID = CanWitnessSet.CandidateWitness_ID) " .
						"LEFT JOIN CandidatePetitionSet ON (CandidatePetitionSet.CandidatePetitionSet_ID = CanPetitionSet.CandidatePetitionSet_ID) " .
						"WHERE CanPetitionSet.CandidatePetitionSet_ID = :CandPetitionSetID " .
						"ORDER BY CandidateElection_DisplayOrder ASC";
		$sql_vars = array("CandPetitionSetID" => $CanPetitionSet_ID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function ListCandidatePetitionSet($CanPetitionSet_ID) {
		$sql = "SELECT * FROM CanPetitionSet " .
						"LEFT JOIN Candidate ON (CanPetitionSet.Candidate_ID = Candidate.Candidate_ID) " . 
						"LEFT JOIN DataCounty ON (DataCounty.DataCounty_ID = CanPetitionSet.DataCounty_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " . 
						"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
						"LEFT JOIN CanWitnessSet ON (CanWitnessSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateWitness ON (CandidateWitness.CandidateWitness_ID = CanWitnessSet.CandidateWitness_ID) " .
						"LEFT JOIN CandidatePetitionSet ON (CandidatePetitionSet.CandidatePetitionSet_ID = CanPetitionSet.CandidatePetitionSet_ID) " .
						"WHERE CanPetitionSet.CanPetitionSet_ID = :CandPetitionSetID " .
						"ORDER BY CandidateElection_DisplayOrder ASC";
						
		$sql_vars = array("CandPetitionSetID" => $CanPetitionSet_ID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function CandidatePetition($PetitionSetID) {
		$sql = "SELECT * FROM PetitionSet " .
						"LEFT JOIN CandidatePetitionSet ON (PetitionSet.CandidatePetitionSet_ID = CandidatePetitionSet.CandidatePetitionSet_ID) " . 
						"LEFT JOIN CandidatePetition ON (CandidatePetition.CandidatePetition_ID = PetitionSet.CandidatePetition_ID) " .
						"WHERE CandidatePetitionSet.CandidatePetitionSet_ID = :CandPetitionSetID AND CandidatePetition_SignedDate IS NULL " .
						"ORDER BY PetitionSet_Order";
		$sql_vars = array("CandPetitionSetID" => $PetitionSetID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function CandidateInformation($CandidateID) {
		$sql = "SELECT * FROM Candidate WHERE Candidate_ID = :CandidateID";
		$sql_vars = array("CandidateID" => $CandidateID);
		return $this->_return_simple($sql, $sql_vars);
	}
	
	// This is base on SYstemUser
	function ListCandidatePetition($SystemUserID, $Status = "published") {
		$sql = "SELECT * FROM CandidatePetitionSet " .
						"LEFT JOIN CanPetitionSet ON (CanPetitionSet.CandidatePetitionSet_ID = CandidatePetitionSet.CandidatePetitionSet_ID) " .
						"LEFT JOIN Candidate ON (CanPetitionSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CanWitnessSet ON (CanWitnessSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateWitness ON (CanWitnessSet.CandidateWitness_ID = CandidateWitness.CandidateWitness_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " .
						"WHERE CandidatePetitionSet.SystemUser_ID = :SystemUserID AND Candidate_Status = :Status " .
						"ORDER BY CandidateElection_DisplayOrder, CanPetitionSet.Candidate_ID";
		$sql_vars = array("SystemUserID" => $SystemUserID, "Status" => $Status);	
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	// This is base on candidate_ID
	function ListCandidate($Candidate_ID, $Status = "published") {
		
		$sql = "SELECT * FROM Candidate " .
						"LEFT JOIN CanWitnessSet ON (CanWitnessSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateWitness ON (CanWitnessSet.CandidateWitness_ID = CandidateWitness.CandidateWitness_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " .
						"WHERE Candidate.Candidate_ID = :CandidateID AND Candidate_Status = :Status " .
						"ORDER BY CandidateElection_DisplayOrder";
		$sql_vars = array("CandidateID" => $Candidate_ID, "Status" => $Status);				
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	
	
	function ListVoterCandidate($Candidate_ID) {
		$sql = "SELECT * FROM CandidatePetition where Candidate_ID = :CandidateID";
		$sql_vars = array("CandidateID" => $Candidate_ID);				
		return $this->_return_multiple($sql, $sql_vars);
	}
  
  function DB_WorkCounty($CountyID) {
		$County = $this->GetCountyFromNYSCodes($CountyID);
		return $County["DataCounty_Name"];	
	}

	function DB_ReturnAddressLine1($vor) {
		$Address_Line1 = "";
		if ( ! empty ($vor["Raw_Voter_ResHouseNumber"])) { $Address_Line1 .= $vor["Raw_Voter_ResHouseNumber"] . " "; }		
		if ( ! empty ($vor["Raw_Voter_ResFracAddress"])) { $Address_Line1 .= $vor["Raw_Voter_ResFracAddress"] . " "; }		
		if ( ! empty ($vor["Raw_Voter_ResPreStreet"])) { $Address_Line1 .= $vor["Raw_Voter_ResPreStreet"] . " "; }		
		$Address_Line1 .= $vor["Raw_Voter_ResStreetName"] . " ";
		if ( ! empty ($vor["Raw_Voter_ResPostStDir"])) { $Address_Line1 .= $vor["Raw_Voter_ResPostStDir"] . " "; }		
		//if ( ! empty ($vor["Raw_Voter_ResApartment"])) { $Address_Line1 .= "- Apt. " . $vor["Raw_Voter_ResApartment"]; }
		$Address_Line1 = preg_replace('!\s+!', ' ', $Address_Line1 );
		return $Address_Line1;
  }
  
  function DB_ReturnAddressLine1Apt($vor) {
		$Address_Line1 = "";
		if ( ! empty ($vor["Raw_Voter_ResHouseNumber"])) { $Address_Line1 .= $vor["Raw_Voter_ResHouseNumber"] . " "; }		
		if ( ! empty ($vor["Raw_Voter_ResFracAddress"])) { $Address_Line1 .= $vor["Raw_Voter_ResFracAddress"] . " "; }		
		if ( ! empty ($vor["Raw_Voter_ResPreStreet"])) { $Address_Line1 .= $vor["Raw_Voter_ResPreStreet"] . " "; }		
		$Address_Line1 .= $vor["Raw_Voter_ResStreetName"] . " ";
		if ( ! empty ($vor["Raw_Voter_ResPostStDir"])) { $Address_Line1 .= $vor["Raw_Voter_ResPostStDir"] . " "; }		
		if ( ! empty ($vor["Raw_Voter_ResApartment"])) { $Address_Line1 .= "- Apt. " . $vor["Raw_Voter_ResApartment"]; }
		$Address_Line1 = preg_replace('!\s+!', ' ', $Address_Line1 );
		return $Address_Line1;
  }
  
  function DB_ReturnAddressLine2($vor) {
  	$Address_Line2 = $vor["Raw_Voter_ResCity"] . ", NY " . $vor["Raw_Voter_ResZip"];
    return $Address_Line2;
  }
  
  function DB_ReturnAddressCity($vor) {
  	return ucwords(strtolower(trim($this->DB_ReturnAddressLine1($vor) . "(" . $vor["Raw_Voter_ResCity"] . " Zip:" . $vor["Raw_Voter_ResZip"] . ")")));
  }
  
	
	function DB_ReturnFullName($vor) {
		$FullName = $vor["Raw_Voter_FirstName"] . " ";
		if ( ! empty ($vor["Raw_Voter_MiddleName"])) { $FullName .= substr($vor["Raw_Voter_MiddleName"], 0, 1) . ". "; }
		$FullName .= $vor["Raw_Voter_LastName"] ." ";
		if ( ! empty ($vor["Raw_Voter_Suffix"])) { $FullName .= $vor["Raw_Voter_Suffix"]; }				
		$FullName = ucwords(strtolower($FullName));
		return $FullName;
	}	
	
}

?>
