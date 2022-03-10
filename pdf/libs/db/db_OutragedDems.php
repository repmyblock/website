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
  
  function SearchInRawNYSFile($DataSearch) {
   	
   	$sqlquery = ""; $sql_vars = array();
		$sql = "SELECT * FROM VotersRaw_NY WHERE (Status = 'A' OR Status = 'I') ";
  	
  	foreach ($DataSearch as $Param => $Search) {
			$sqlquery .= " AND ";
  		switch ($Param) {
  			case "AD": $sqlquery .= "AssemblyDistr = :AD"; $sql_vars["AD"] = $Search; break;
  			case "ED": $sqlquery .= "ElectDistr = :ED"; $sql_vars["ED"] = $Search; break;
  			case "CD": $sqlquery .= "CountyCode = :CD"; $sql_vars["CD"] = $Search; break;
  			case "LG": $sqlquery .= "LegisDistr = :LG"; $sql_vars["LG"] = $Search; break;
  			case "TW": $sqlquery .= "TownCity = :TW"; $sql_vars["TW"] = $Search; break;
  			case "WD": $sqlquery .= "Ward = :WD"; $sql_vars["WD"] = $Search; break;
  			case "CG": $sqlquery .= "CongressDistr = :CG"; $sql_vars["CG"] = $Search; break;
  			case "SD": $sqlquery .= "SenateDistr = :SD"; $sql_vars["SD"] = $Search; break;
  			case "PT": $sqlquery .= "EnrollPolParty = :PT"; $sql_vars["PT"] = $Search; break;
  		}
  	}
  	
  	$sql .= $sqlquery; 	
  	WriteStderr($sql, "SearchInRawNYSFile SQL");
  	WriteStderr($sql_vars, "SearchInRawNYSFile SQL VARS");
  	return $this->_return_multiple($sql, $sql_vars);  	
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
	
	function ShowPetitionsForUser($UniqID) {
		$sql = "SELECT * FROM PetitionGroup " . 
						"LEFT JOIN PetitionSigners ON (PetitionSigners.PetitionGroup_ID = PetitionGroup.PetitionGroup_ID) " .
						"LEFT JOIN Candidate ON (PetitionGroup.Candidate_ID = Candidate.Candidate_ID) " .  
						"LEFT JOIN CanWitnessSet ON (CanWitnessSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateWitness ON (CanWitnessSet.CandidateWitness_ID = CandidateWitness.CandidateWitness_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " .
						"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
						"LEFT JOIN PartySymbol ON (Candidate.PartySymbol_ID = PartySymbol.PartySymbol_ID) " . 
						"WHERE PetitionGroup_OwnerUniqID = :Uniq";
		$sql_vars = array("Uniq" => $UniqID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function ListPetitionSet($CandidateGroupID) {
		$sql = "SELECT * FROM CandidateGroup " .
						"LEFT JOIN Candidate ON (CandidateGroup.Candidate_ID = Candidate.Candidate_ID) " . 
						"LEFT JOIN DataCounty ON (DataCounty.DataCounty_ID = CandidateGroup.DataCounty_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " . 
						"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
						//"LEFT JOIN CanWitnessSet ON (CanWitnessSet.Candidate_ID = Candidate.Candidate_ID) " .
						//"LEFT JOIN CandidateWitness ON (CandidateWitness.CandidateWitness_ID = CanWitnessSet.CandidateWitness_ID) " .
						//"LEFT JOIN CandidatePetitionSet ON (CandidatePetitionSet.CandidatePetitionSet_ID = CanPetitionSet.CandidatePetitionSet_ID) " .
						"WHERE CandidateGroup.CandidateGroup_ID = :CandidateGroup_ID " .
						"ORDER BY CandidateElection_DisplayOrder ASC";
		$sql_vars = array("CandidateGroup_ID" => $CandidateGroupID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function ListCandidatePetitionSet($CanPetitionSet_ID) {
		echo $sql = "SELECT * FROM CanPetitionSet " .
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
	
	function ListPetitionGroup($GroupID, $Status = NULL) {
		$sql = "SELECT * FROM CandidateGroup " .
						"LEFT JOIN Candidate ON (CandidateGroup.Candidate_ID = Candidate.Candidate_ID) " . 
						"LEFT JOIN DataCounty ON (DataCounty.DataCounty_ID = CandidateGroup.DataCounty_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " . 
						"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
						"LEFT JOIN CandidateComRplceSet ON (CandidateComRplceSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateComRplce ON (CandidateComRplceSet.CandidateComRplce_ID = CandidateComRplce.CandidateComRplce_ID) " .
						"WHERE CandidateGroup.CandidateSet_ID = :CandidateGroup_ID " .
						"ORDER BY CandidateGroup_Order ASC, CandidateComRplce_Order ASC";
						
		WriteStderr($sql, "ListPetitionGroup for $GroupID");				
		
		$sql_vars = array("CandidateGroup_ID" => $GroupID);
		return $this->_return_multiple($sql, $sql_vars);
		
	}
	
	// This is base on SYstemUser
	function ListCandidatePetition($CandidateID, $Status = NULL) {
		$sql = "SELECT * FROM Candidate " .
						"LEFT JOIN CandidateComRplceSet ON (CandidateComRplceSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateComRplce ON (CandidateComRplceSet.CandidateComRplce_ID = CandidateComRplce.CandidateComRplce_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " .
						"LEFT JOIN Elections ON (CandidateElection.Elections_ID = Elections.Elections_ID) " . 
						"LEFT JOIN DataCounty ON (Candidate.DataCounty_ID = DataCounty.DataCounty_ID) " . 
						"WHERE Candidate.Candidate_ID = :CandidateID ";
		$sql_vars = array("CandidateID" => $CandidateID);
		
		if ( ! empty ($Status)) {					
			$sql .= "AND Candidate_Status = :Status ";
			$sql_vars["Status"] = $Status;	
		}
										
		$sql .= "ORDER BY CandidateElection_DisplayOrder, CandidateComRplce_Order, Candidate.Candidate_ID ";
		
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
	
	function ListVoterForCandidates($CandidateID) {
		$sql = "SELECT * FROM Candidate " . 
           "LEFT JOIN Voters ON (Candidate.CandidateElection_DBTable = Voters.ElectionsDistricts_DBTable  " . 
									           "AND Candidate.CandidateElection_DBTableValue = Voters.ElectionsDistricts_DBTableValue " . 
									           "AND Candidate.Candidate_Party = Voters.Voters_RegParty) " . 
           "LEFT JOIN DataHouse ON (Voters.DataHouse_ID = DataHouse.DataHouse_ID) " . 
           "LEFT JOIN DataAddress ON (DataAddress.DataAddress_ID = DataHouse.DataAddress_ID) " . 
           "LEFT JOIN DataStreet ON (DataStreet.DataStreet_ID = DataAddress.DataStreet_ID) " . 
           "LEFT JOIN DataCity ON (DataCity.DataCity_ID = DataAddress.DataCity_ID) " . 
           "LEFT JOIN VotersIndexes ON (VotersIndexes.VotersIndexes_ID = Voters.VotersIndexes_ID) " . 
           "LEFT JOIN DataLastName ON (VotersIndexes.DataLastName_ID = DataLastName.DataLastName_ID) " . 
           "LEFT JOIN DataFirstName ON (VotersIndexes.DataFirstName_ID = DataFirstName.DataFirstName_ID) " . 
           "LEFT JOIN DataMiddleName ON (VotersIndexes.DataMiddleName_ID = DataMiddleName.DataMiddleName_ID) " . 
           "WHERE (Voters_Status = 'Active' OR Voters_Status = 'Inactive') " . 
           "AND Candidate.Candidate_ID = :CandidateID";
		$sql_vars = array("CandidateID" => $CandidateID);		
		return $this->_return_multiple($sql, $sql_vars);
	}
  
  function ListVotersForDataDistrict($DataDistrictID) {
  	
  	if ( $DataDistrictID > 0) {
  		
  		$sql = "SELECT * " .
							"FROM RepMyBlock.DataDistrict " .
							"LEFT JOIN DataDistrictTemporal ON (DataDistrictTemporal.DataDistrict_ID = DataDistrict.DataDistrict_ID) " .
							"LEFT JOIN DataDistrictCycle ON (DataDistrictCycle.DataDistrictCycle_ID = DataDistrictTemporal.DataDistrictCycle_ID) " .
							"LEFT JOIN DataHouse ON (DataHouse.DataDistrictTemporal_GroupID = DataDistrictTemporal.DataDistrictTemporal_GroupID) " .
							"LEFT JOIN Voters ON (Voters.DataHouse_ID = DataHouse.DataHouse_ID) " .
							"LEFT JOIN DataAddress ON (DataAddress.DataAddress_ID = DataHouse.DataAddress_ID)   " .
							"LEFT JOIN DataStreet ON (DataStreet.DataStreet_ID = DataAddress.DataStreet_ID)  " .
							"LEFT JOIN DataCity ON (DataCity.DataCity_ID = DataAddress.DataCity_ID) " .
							"LEFT JOIN VotersIndexes ON (VotersIndexes.VotersIndexes_ID = Voters.VotersIndexes_ID)   " .
							"LEFT JOIN DataLastName ON (VotersIndexes.DataLastName_ID = DataLastName.DataLastName_ID)  " .
							"LEFT JOIN DataFirstName ON (VotersIndexes.DataFirstName_ID = DataFirstName.DataFirstName_ID)  " .
							"LEFT JOIN DataMiddleName ON (VotersIndexes.DataMiddleName_ID = DataMiddleName.DataMiddleName_ID)   " .
							"WHERE (Voters_Status = 'Active' OR Voters_Status = 'Inactive') " .
							"AND DataDistrict.DataDistrict_ID = :District";
			$sql_vars = array("District" => $DataDistrictID);		
			return $this->_return_multiple($sql, $sql_vars);
		}	
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
		if ( ! empty ($vor["ResHouseNumber"])) { $Address_Line1 .= $vor["ResHouseNumber"] . " "; }		
		if ( ! empty ($vor["ResFracAddress"])) { $Address_Line1 .= $vor["ResFracAddress"] . " "; }		
		if ( ! empty ($vor["ResPreStreet"])) { $Address_Line1 .= $vor["ResPreStreet"] . " "; }		
		$Address_Line1 .= $vor["ResStreetName"] . " ";
		if ( ! empty ($vor["ResPostStDir"])) { $Address_Line1 .= $vor["ResPostStDir"] . " "; }		
		//if ( ! empty ($vor["Raw_Voter_ResApartment"])) { $Address_Line1 .= "- Apt. " . $vor["Raw_Voter_ResApartment"]; }
		$Address_Line1 = preg_replace('!\s+!', ' ', $Address_Line1 );
		return $Address_Line1;
  }
  
  function DB_ReturnAddressLine1Apt($vor) {
		$Address_Line1 = "";
		if ( ! empty ($vor["ResHouseNumber"])) { $Address_Line1 .= $vor["ResHouseNumber"] . " "; }		
		if ( ! empty ($vor["ResFracAddress"])) { $Address_Line1 .= $vor["ResFracAddress"] . " "; }		
		if ( ! empty ($vor["ResPreStreet"])) { $Address_Line1 .= $vor["ResPreStreet"] . " "; }		
		$Address_Line1 .= $vor["ResStreetName"] . " ";
		if ( ! empty ($vor["ResPostStDir"])) { $Address_Line1 .= $vor["ResPostStDir"] . " "; }		
		if ( ! empty ($vor["ResApartment"])) { $Address_Line1 .= "- Apt. " . $vor["ResApartment"]; }
		$Address_Line1 = preg_replace('!\s+!', ' ', $Address_Line1 );
		return $Address_Line1;
  }
  
  function DB_ReturnAddressLine2($vor) {
  	$Address_Line2 = $vor["ResCity"] . ", NY " . $vor["ResZip"];
    return $Address_Line2;
  }
  
  function DB_ReturnAddressCity($vor) {
  	return ucwords(strtolower(trim($this->DB_ReturnAddressLine1($vor) . "(" . $vor["ResCity"] . " Zip:" . $vor["ResZip"] . ")")));
  }
  
	
	function DB_ReturnFullName($vor) {
		$FullName = $vor["FirstName"] . " ";
		if ( ! empty ($vor["MiddleName"])) { $FullName .= substr($vor["MiddleName"], 0, 1) . ". "; }
		$FullName .= $vor["LastName"] ." ";
		if ( ! empty ($vor["Suffix"])) { $FullName .= $vor["Suffix"]; }				
		$FullName = ucwords(strtolower($FullName));
		return $FullName;
	}	
	
}

?>
