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
  
 	function FindADEDFromDistrict($DataDistrict) {
  	$sql = "SELECT * FROM DataDistrict WHERE DataDistrict_ID = :DataDistrict";
  	$sql_vars = array("DataDistrict" => $DataDistrict);
		return $this->_return_simple($sql, $sql_vars);
	}
  
  function FindElectionDate($MySQLDate, $State, $Type) {
  	$sql = "SELECT * FROM Elections WHERE " .
  					"DataState_ID = :StateID AND Elections_Date = :Date AND Elections_Type = :Type";
  	$sql_vars = array("Date" => $MySQLDate, "StateID" => $State, "Type" => $Type);
  	return $this->_return_multiple($sql, $sql_vars);  	
  }
  
  function SearchVotersFile($DataSearch) {
   	$sqlquery = ""; $sql_vars = array();
				
		$sql = "SELECT ";
		
		
		$sql .= "DataHouse.DataHouse_ID, DataHouse_Type, DataHouse_Apt, DataHouse.DataDistrictTown_ID, DataStreetNonStdFormat_ID, " . 
						"DataAddress_HouseNumber, DataAddress_FracAddress, DataAddress_PreStreet, DataAddress_PostStreet, " . 
						"DataAddress_zipcode, DataAddress_zip4, DataCounty.DataState_ID, DataState_Abbrev, DataState_Name," . 
						"DataStreet_Name, DataCity_Name, Voters_Gender, Voters_UniqStateVoterID, Voters_RegParty, " . 
						"Voters_Status, Voters_DateInactive, Voters_DatePurged , Voters_RMBActive, Voters_RecFirstSeen, " . 
						"Voters_RecLastSeen, VotersIndexes_Suffix, VotersIndexes_DOB, VotersIndexes_UniqStateVoterID, " . 
						"DataLastName_Text, DataFirstName_Text, DataMiddleName_Text, DataCounty_Name, " .
						"DataDistrict_Electoral, DataDistrict_StateAssembly, DataDistrict_StateSenate, DataDistrict_Legislative, " . 
						"DataDistrict_Ward, DataDistrict_Congress, " .
						"DataHouse_Type, DataHouse_Apt, DataDistrictTown_Name "; 
		
		
		$sql .=	"FROM DataDistrict " .
						"LEFT JOIN DataDistrictTemporal on (DataDistrict.DataDistrict_ID = DataDistrictTemporal.DataDistrict_ID) " .
						"LEFT JOIN DataDistrictCycle on (DataDistrictTemporal.DataDistrictCycle_ID = DataDistrictCycle.DataDistrictCycle_ID) " .
						"LEFT JOIN DataHouse ON (DataHouse.DataHouse_ID = DataDistrictTemporal.DataHouse_ID) " .
						"LEFT JOIN DataAddress ON (DataAddress.DataAddress_ID = DataHouse.DataAddress_ID) " .
						"LEFT JOIN DataCounty ON (DataAddress.DataCounty_ID = DataCounty.DataCounty_ID) " . 
						"LEFT JOIN DataState ON (DataState.DataState_ID = DataCounty.DataState_ID) " .
						"LEFT JOIN DataStreet ON (DataStreet.DataStreet_ID = DataAddress.DataStreet_ID) " .
						"LEFT JOIN DataCity ON (DataCity.DataCity_ID = DataAddress.DataCity_ID) " .
						"LEFT JOIN Voters ON (Voters.DataHouse_ID = DataHouse.DataHouse_ID) " .
						"LEFT JOIN VotersIndexes ON (VotersIndexes.VotersIndexes_ID = Voters.VotersIndexes_ID) " .
						"LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID) " .  
						"LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID) " .  
						"LEFT JOIN DataMiddleName ON (DataMiddleName.DataMiddleName_ID = VotersIndexes.DataMiddleName_ID) " .
						"LEFT JOIN DataDistrictTown ON (DataDistrictTown.DataDistrictTown_ID = DataHouse.DataDistrictTown_ID) " .
						"WHERE (Voters_Status = 'Active' OR Voters_Status = 'Inactive') AND " . 
						"(CURDATE() >= DataDistrictCycle_CycleStartDate AND CURDATE() <= DataDistrictCycle_CycleEndDate) IS NULL";
				 	
  	foreach ($DataSearch as $Param => $Search) {
			$sqlquery .= " AND ";
  		switch ($Param) {
  			case "AD": $sqlquery .= "DataDistrict_StateAssembly = :AD"; $sql_vars["AD"] = $Search; break;
  			case "ED": $sqlquery .= "DataDistrict_Electoral = :ED"; $sql_vars["ED"] = $Search; break;
  			case "CD": $sqlquery .= "CountyCode = :CD"; $sql_vars["CD"] = $Search; break;
  			case "LG": $sqlquery .= "LegisDistr = :LG"; $sql_vars["LG"] = $Search; break;
  			case "TW": $sqlquery .= "TownCity = :TW"; $sql_vars["TW"] = $Search; break;
  			case "WD": $sqlquery .= "Ward = :WD"; $sql_vars["WD"] = $Search; break;
  			case "CG": $sqlquery .= "CongressDistr = :CG"; $sql_vars["CG"] = $Search; break;
  			case "SD": $sqlquery .= "SenateDistr = :SD"; $sql_vars["SD"] = $Search; break;
  			case "PT": $sqlquery .= "Voters_RegParty = :PT"; $sql_vars["PT"] = $Search; break;
  			case "VI": $sqlquery .= "Voters_ID = :VI"; $sql_vars["VI"] = $Search; break;
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
	
	function ListPetitionGroup($GroupRandom, $Status = NULL) {
		$sql = "SELECT * FROM CandidateSet " .
						"LEFT JOIN CandidateGroup ON (CandidateGroup.CandidateSet_ID = CandidateSet.CandidateSet_ID) " . 
						"LEFT JOIN Candidate ON (CandidateGroup.Candidate_ID = Candidate.Candidate_ID) " . 
						"LEFT JOIN DataCounty ON (DataCounty.DataCounty_ID = CandidateGroup.DataCounty_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " . 
						"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
						"LEFT JOIN CandidateComRplceSet ON (CandidateComRplceSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateComRplce ON (CandidateComRplceSet.CandidateComRplce_ID = CandidateComRplce.CandidateComRplce_ID) " .
						"LEFT JOIN CandidatePartySymbol ON (CandidatePartySymbol.CandidatePartySymbol_ID = Candidate.CandidatePartySymbol_ID) " .
						"WHERE CandidateSet.CandidateSet_Random = :GroupRandomText " .
						"ORDER BY CandidateGroup_Order ASC, CandidateComRplce_Order ASC";
						
		WriteStderr($sql, "ListPetitionGroup for $GroupID");				
		
		$sql_vars = array("GroupRandomText" => $GroupRandom);
		return $this->_return_multiple($sql, $sql_vars);
		
	}
	
	function ListCandidatePetitionFilingID($CandidateID) {
		$sql = "SELECT * FROM Candidate " .
						"LEFT JOIN CandidateGroup ON (CandidateGroup.Candidate_ID = Candidate.Candidate_ID) " . 
						"LEFT JOIN FillingTrack ON (FillingTrack.CandidateSet_ID = CandidateGroup.CandidateSet_ID) " . 
							"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " .
						"LEFT JOIN Elections ON (CandidateElection.Elections_ID = Elections.Elections_ID) " . 
						"LEFT JOIN DataCounty ON (Candidate.DataCounty_ID = DataCounty.DataCounty_ID) " . 
						"LEFT JOIN CandidatePartySymbol ON (CandidatePartySymbol.CandidatePartySymbol_ID = Candidate.CandidatePartySymbol_ID) " .
						"WHERE Candidate.Candidate_ID = :CandidateID AND FillingTrack_BOEID IS NOT NULL ";
		$sql_vars = array("CandidateID" => $CandidateID);
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
						"LEFT JOIN CandidatePartySymbol ON (CandidatePartySymbol.CandidatePartySymbol_ID = Candidate.CandidatePartySymbol_ID) " .
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
							"FROM DataDistrict " .
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
	
	function FindElection($DBTable, $DBValue, $Party, $MysqlDate) {
		$sql = "SELECT * FROM ElectionsPosition " .
						"LEFT JOIN CandidateElection ON ( ElectionsPosition.ElectionsPosition_DBTable = CandidateElection.CandidateElection_DBTable) " .
						"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
						"WHERE " . 
						"ElectionsPosition_DBTable = :DBTable AND CandidateElection_DBTableValue = :DBValue AND " . 
						"ElectionsPosition_Party = :Party AND Elections_Date = :MysqlDate";
					
		$sql_vars = array("DBTable" => $DBTable, "DBValue" => $DBValue, "Party" => $Party, "MysqlDate" => $MysqlDate);				
		return $this->_return_multiple($sql, $sql_vars);
  }
		
  function SelectObjections ($Objection_ID) {
  	$sql = "SELECT * FROM FillingObjections " . 
  					"LEFT JOIN DataCounty ON (DataCounty.DataCounty_ID = FillingObjections.DataCounty_ID) " .
  					"WHERE FillingObjections_ID = :Objections";
  	$sql_vars = array("Objections" => $Objection_ID);				
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

}

?>
