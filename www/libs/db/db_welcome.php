<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class welcome extends queries {

  function __construct($debug = 0, $DBFile = "DB_OutragedDems") {
    require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
    $DebugInfo["DBFile"] = $DBFile;
    $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
    $DebugInfo["Flag"] = $debug;
    parent::__construct($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
   
  function ReturnOpenAddress($search, $limit = 10, $SQLTables = null) {
		return $this->_return_multiple(
			"SELECT OpenAddresses_ID AS id, OpenAddresses_FullAddress AS label, OpenAddresses_Lat AS lat, " .
			"OpenAddresses_Lon AS lon FROM OpenAddresses WHERE MATCH(OpenAddresses_FullAddress) " .
			"AGAINST(:search IN BOOLEAN MODE) LIMIT $limit",
     ["search" => $search]
		);
  }
  
  function ReturnCandidatesNames($search, $limit = 10, $SQLTables = null) {
  	echo "Search: " .  $seach . "<BR>";
  	
		return $this->_return_multiple(
		  "SELECT " . sqltablestoshow($SQLTables)  . " FROM CandidateProfile " . 
      "WHERE CandidateProfile_Alias IS NOT NULL " . 
      "AND CandidateProfile_Alias != '' " . 
      "AND MATCH(CandidateProfile_Alias) AGAINST (:search IN BOOLEAN MODE) " . 
      "ORDER BY CandidateProfile_Alias " . 
      "LIMIT $limit",
     ["search" => $search]
		);
  }
  
  function CandidatesInfo($CandidateID = NULL) {
		$sql = "SELECT * FROM CandidateProfile ";
						
		if (! empty ($CandidateID)) {
			$sql .= "WHERE Candidate_ID = :CandidateID";
			$sql_vars = array("CandidateID" => $CandidateID);
			return $this->_return_simple($sql, $sql_vars);
		} 

		return $this->_return_multiple($sql);
	}
	
	function GetTeamInfo($TeamID = NULL) {
		$sql = "SELECT * FROM Team";
		$sql_vars = array();
		if ( ! empty ($TeamID)) {
			$sql .= " WHERE Team_ID = :TeamID";
			$sql_vars["TeamID"] = $TeamID;
		}
		return $this->_return_multiple($sql, $sql_vars);
	}

	// Function use 8.1 format - Don't change var names
	function CandidatesForElection($ElectionDateFrom = null, $ElectionDateTo = null, $ElectionState = null, 
																	$ActiveTeam = null, $CandidateElectionID = null, 
																	$Offset = 0, $Limit = 600, $SQLTables = null) {
		$sql = "SELECT " . sqltablestoshow($SQLTables) . ", PublicProfile.PublicProfile_ID AS CANDPROFID, " .
						"Candidate.CandidateElection_DBTable AS CANDDTABLE, " . 
						"Candidate.CandidateElection_DBTableValue AS CANDVALUE " .
						"FROM Elections " .
						"LEFT JOIN CandidateElection ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
						"LEFT JOIN Candidate ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " . 
						"LEFT JOIN DataState ON (DataState.DataState_ID = Elections.DataState_ID) " .
						"LEFT JOIN PublicProfile ON (PublicProfile.Candidate_ID = Candidate.Candidate_ID) " . 
						"LEFT JOIN CandidateProfile ON (PublicProfile.CandidateProfile_ID = CandidateProfile.CandidateProfile_ID) " .
						"LEFT JOIN Team ON (Candidate.Team_ID = Team.Team_ID) " .  
					 "WHERE CandidateProfile_PublishProfile = \"yes\" AND CandidateElection_Text IS NOT NULL";
		$sql_vars = array();
		
		if ( ! empty ($ElectionState)) {
			$sql .= " AND DataState_Abbrev = :Abbrev";
			$sql_vars["Abbrev"] = $ElectionState;
		}
		
		
		if ( ! empty($CandidateElectionID)) {
			$sql .= " AND CandidateElection.CandidateElection_ID = :CandidateElectionID";
			$sql_vars["CandidateElectionID"] = $CandidateElectionID;
		}
		
		if ( ! empty ($ElectionDateFrom)) {			
			if ( $ElectionDateFrom == "NOW") {
				$sql .= " AND Elections_Date >= NOW() - INTERVAL 1 DAY";
			} else {
				$sql .= " AND Elections_Date = :ElectionDateFrom";
				$sql_vars["ElectionDateFrom"] = $ElectionDateFrom;
			}
		}
		
		if ( ! empty ($ActiveTeam)) {
			$sql .= " AND Candidate.Team_ID = :TeamID";
			$sql_vars["TeamID"] = $ActiveTeam;
		}
		
		if ( empty ($Offset)) $Offset = 0;
		$sql .= " ORDER BY Elections_Date, CandidateElection_Party, CandidateElection_DisplayOrder, " . 
										"CandidateElection.CandidateElection_DBTable, " . 
										"LPAD(CandidateElection.CandidateElection_DBTableValue, 6,0) LIMIT $Limit OFFSET $Offset";
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function ListDistrictsForZip($ActiveZipcode) {
		return $this->_return_multiple(
			"SELECT * FROM DataDistrict " . 
			"LEFT JOIN DataCounty ON (DataCounty.DataCounty_ID = DataDistrict.DataCounty_ID) " .
			"LEFT JOIN DataState ON (DataCounty.DataState_ID = DataState.DataState_ID) " . 
			"WHERE DataDistrict_ZipCode = :ZipCode",
			["ZipCode" => $ActiveZipcode]
		);
	}
	
	function ListDistrictsAndTablesForZip($ActiveZipcode, $When = "NOW") {
		return $this->_return_multiple(
			"SELECT * FROM DataDistrict " . 
			"LEFT JOIN DataCounty ON (DataCounty.DataCounty_ID = DataDistrict.DataCounty_ID) " .
			"LEFT JOIN DataState ON (DataCounty.DataState_ID = DataState.DataState_ID) " . 
			"LEFT JOIN ElectionsPartyCall ON (ElectionsPartyCall.ElectionsPartyCall_DBTable = DataDistrict.DataDistrict_DBTable AND ElectionsPartyCall.ElectionsPartyCall_DBTableValue = DataDistrict.DataDistrict_DBTableValue) " . 
			"LEFT JOIN ElectionsPosition ON (ElectionsPosition.ElectionsPosition_ID = ElectionsPartyCall.ElectionsPosition_ID) " . 
			"WHERE DataDistrict_ZipCode = :ZipCode", //  AND ElectionsPosition_Location = 'partycall'";
			["ZipCode" => $ActiveZipcode]
		);
	}
	
	function CandidatesDetailed($PublicProfileID, $SQLTables = null) {		
		return $this->_return_simple(
			"SELECT " . sqltablestoshow($SQLTables)  . " FROM PublicProfile " .
			"LEFT JOIN CandidateProfile ON (PublicProfile.CandidateProfile_ID = CandidateProfile.CandidateProfile_ID) " . 
			"LEFT JOIN Candidate ON (Candidate.Candidate_ID = PublicProfile.Candidate_ID) " . 
			"LEFT JOIN CandidateElection ON (Candidate.CandidateElection_ID = CandidateElection.CandidateElection_ID) " .
			"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
			"LEFT JOIN DataState ON (DataState.DataState_ID = Elections.DataState_ID) " . 
			"LEFT JOIN PublicTeam ON (PublicProfile.PublicProfile_ID = PublicTeam.PublicProfile_ID) " .
			"LEFT JOIN Team ON (PublicTeam.Team_ID = Team.Team_ID) " . 
			"WHERE PublicProfile.PublicProfile_ID = :CandidateProfileID", 
			["CandidateProfileID" => $PublicProfileID]
		);
	}
	
	function ListOnElectionsStates($When = "NOW") {
			$sql = "SELECT DISTINCT Elections_Text, Elections_Date, Elections_Type, DataState_Abbrev, DataState_Name " .
									"FROM RepMyBlock.CandidateElection " .
									"LEFT JOIN Elections ON (CandidateElection.Elections_ID = Elections.Elections_ID) " .
									"LEFT JOIN DataState ON (DataState.DataState_ID = Elections.DataState_ID) ";
			
			switch ($When) {
				case "ALL";
					return $this->_return_multiple($sql);
					break;

				default: 
					$sql .= "WHERE Elections_Date >= NOW();";
					return $this->_return_multiple($sql);
					break;
			}		
			
			return $this->_return_multiple($sql);
	}
	
  function FindCandidate($CandidateID) {  	
		return $this->_return_simple(
			"SELECT * FROM Candidate WHERE Candidate_ID = :CandidateID",
			["CandidateID" => $CandidateID]
		);	
	} 
	
	function ListElectionPositions($StateID) {
		return $this->_return_multiple(
			"SELECT * FROM RepMyBlock.ElectionsPosition WHERE DataState_ID = :StateID", 
			["StateID" => $StateID]
		);	
	}
	
	function FindVoter($VoterID, $DateFile) {  	
		return $this->_return_simple(
			"SELECT * FROM Raw_Voter_" . $DateFile . " WHERE Raw_Voter_UniqNYSVoterID = :VoterID",
			["VoterID" => $VoterID]
		);	
	} 
	
	function FindVolunteer($SystemID) {  	
		return $this->_return_simple(
			"SELECT * FROM SystemUser WHERE SystemUser_ID = :SystemUser_ID", 
			["SystemUser_ID" => $SystemID]
		);	
	} 
	
	function SaveVolunteer($Email, $VoterID, $SystemID, $CandidateID ) {
		return $this->_return_nothing(
			"INSERT INTO VoterCustomInfo SET " .
			"Raw_Voter_UniqNYSVoterID = :VoterID, " .
			"SystemUser_ID = :SystemUserID, " .
			"Candidate_ID = :CandidateID, " .
			"VoterCustomInfo_Email = :Email, VoterCustomInfo_CreateTime = NOW()",
			[ 
				"VoterID" => $VoterID, "SystemUserID" => $SystemID, "CandidateID" => $CandidateID, "Email" => $Email
			]
		);			
	}
	
	function SaveReferral($Email, $CellPhone) {
		if ( ! empty ($Email) || ! empty($CellPhone)) {
			$sql = "INSERT INTO Referral SET ";
			if ( ! empty ($Email)) { $sql .= "Referral_email = :Email, "; $sql_vars["Email"] = $Email; }
			if ( ! empty ($CellPhone)) { $sql .= "Referral_cellphone = :CellPhone, "; $sql_vars["CellPhone"] = $CellPhone; }
			$sql .= "Referral_date = NOW()";
			return $this->_return_nothing($sql, $sql_vars);	
		}	
	}
	
	function ListElections($state = NULL, $date = NULL) {
		$sql = "SELECT * FROM Elections " .
						"LEFT JOIN DataState ON (DataState.DataState_ID = Elections.DataState_ID) " . 
						"WHERE ";
		$sql_vars = array();	
					
		if ( ! empty ($state)) {
			$sql = "DataState_Abbrev = :Abbrev";
			$sql_vars["Abbrev"] = $state;
			if ( ! empty ($date)) { $sql .= " AND "; }
		}

		if ( empty ($date)) {
			$sql .= "Elections_Date > NOW()";
		}	else {
			$sql .= "Elections_Date = :electdate";
			$sql_vars["electdate"] = $date;
		}

		$sql .= " ORDER BY DataState_Abbrev";
		return $this->_return_multiple($sql, $sql_vars);
	}
	
}

?>