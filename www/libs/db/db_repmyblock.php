<?php	  	
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

// This are functions used by various pages. 
// If the Function is not used by multiple pages, then it's proper location is in the DB_<NAME_OF_PAGE>.php

class RepMyBlock extends queries {

  function RepMyBlock ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	  
	  WriteStderr($DebugInfo, "RepMyBlock ->");	
	  $this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
  // These function are from DB_TEAMS but it's being used by user.php so back in main.
  function FindCampaignFromWebCode ($TeamWebCode) {
		$sql = "SELECT * FROM Team WHERE Team_WebCode = :TeamWebCode";
		$sql_vars = array("TeamWebCode" => $TeamWebCode);
	 	return $this->_return_simple($sql, $sql_vars);
	}
	
	function SaveTeamInfo($SystemUser_ID, $Team_ID, $Priv = NULL, $Active = 'pending') {
		 $ret = $this->ReturnTeamInfo($SystemUser_ID, $Team_ID);
		 WriteStderr($ret, "ReturnTeamInfo");
		 
		 if (empty ($ret)) {			
			$sql = "INSERT INTO TeamMember SET SystemUser_ID = :SystemUser, Team_ID = :TeamID, " . 
						 "TeamMember_Active = :Active, TeamMember_DateRequest = NOW()";
			$sql_vars = array("SystemUser" => $SystemUser_ID, "TeamID" => $Team_ID, "Active" => $Active);
			//				"TeamMember_Active = :Active, TeamMember_Privs = :Privs, " .
			//				"TeamMember_ApprovedBy = :App_SystemID, TeamMember_ApprovedNote = :App_Note, ";	
			WriteStderr($sql, "ReturnTeamInfo");	
			return $this->_return_nothing($sql, $sql_vars);						
		}
	}
	
	
	
	function ListCCPartyCall($Party, $ADED, $ElectionsID) {
		$sql = "SELECT * FROM ElectionsPartyCall " .
						"LEFT JOIN ElectionsPosition ON (ElectionsPosition.ElectionsPosition_ID = ElectionsPartyCall.CandidatePositions_ID) " .
						"WHERE ElectionsPosition_Party = :Party AND ElectionsPartyCall_DBTableValue = :Value AND ElectionsPosition_DBTable = :Type AND " .
						"Elections_ID = :ElectionID";
		$sql_vars = array("Party" => $Party, "Value" =>  $ADED, "Type" => "ADED", "ElectionID" => $ElectionsID);
	  return $this->_return_multiple($sql, $sql_vars);
	}
	
	function FindRacesInPartyCallInfo($Election, $DTable, $DValue) {
		
		$sql = "SELECT * FROM ElectionsDistrictsConv " .
						"LEFT JOIN ElectionsPartyCall ON (" .
						"ElectionsPartyCall.ElectionsPartyCall_DBTable = ElectionsDistrictsConv.ElectionsDistrictsConv_DBTable AND " .
						"ElectionsPartyCall.ElectionsPartyCall_DBTableValue = ElectionsDistrictsConv.ElectionsDistrictsConv_DBTableValue AND " .
						"ElectionsPartyCall.Elections_ID = ElectionsDistrictsConv.Elections_ID) " .
						"LEFT JOIN ElectionsPosition ON (" . 
						"ElectionsPosition.ElectionsPosition_ID = ElectionsDistrictsConv.ElectionsPosition_ID";
		$sql .= ") " .
						"LEFT JOIN DataCounty ON (DataCounty.DataCounty_ID = ElectionsDistrictsConv.DataCounty_ID) " . 
						"WHERE ElectionsDistrictsConv.Elections_ID = :ElectionID AND ElectionsPartyCall_DBTableValue = :Position AND " . 
						"ElectionsPartyCall_DBTable = :DTable " .
						"ORDER BY ElectionsPosition_Order";
						
		$sql_vars = array("ElectionID" => $Election, "DTable" =>  $DTable, "Position" => $DValue);
		
		return $this->_return_multiple($sql, $sql_vars);						
	}
	
	function PartyCallInfo($Party, $Election, $DTable, $DValue) {
		
		$sql = "SELECT * FROM ElectionsDistrictsConv " .
						"LEFT JOIN ElectionsPartyCall ON (" .
						"ElectionsPartyCall.ElectionsPartyCall_DBTable = ElectionsDistrictsConv.ElectionsDistrictsConv_DBTable AND " .
						"ElectionsPartyCall.ElectionsPartyCall_DBTableValue = ElectionsDistrictsConv.ElectionsDistrictsConv_DBTableValue AND " .
						"ElectionsPartyCall.Elections_ID = ElectionsDistrictsConv.Elections_ID) " .
						"LEFT JOIN ElectionsPosition ON (" . 
						"ElectionsPosition.ElectionsPosition_ID = ElectionsDistrictsConv.ElectionsPosition_ID";
		if ( ! empty ($Party)) {
			$sql .= 	" AND ElectionsPartyCall.ElectionsPartyCall_Party = ElectionsPosition.ElectionsPosition_Party";
		} 
		$sql .= ") " .
						"LEFT JOIN DataCounty ON (DataCounty.DataCounty_ID = ElectionsDistrictsConv.DataCounty_ID) " . 
						"WHERE ElectionsDistrictsConv.Elections_ID = :ElectionID AND ElectionsDistricts_DBTableValue = :Position AND " . 
						"ElectionsPosition_DBTable = :DTable ";
						
		$sql_vars = array("ElectionID" => $Election, "DTable" =>  $DTable, "Position" => $DValue);
		
		if ( ! empty ($Party)) {
			$sql .= " AND ElectionsPosition_Party = :Party";
			$sql_vars["Party"] = $Party;
		} else {
			$sql .= " AND ElectionsPosition_Party IS NULL";
		}

		return $this->_return_multiple($sql, $sql_vars);						
	}

	
	function ListPartyCall($Election_ID) {
		$sql = "SELECT * FROM ElectionsPartyCall WHERE Elections_ID = :ElectionID";
		$sql_vars = array("ElectionID" => $Election_ID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function ReturnTeamInfo($SystemUser_ID, $Team_ID, $Active = 'yes') {
		$sql = "SELECT * FROM TeamMember WHERE SystemUser_ID = :SystemUser AND Team_ID = :TeamID AND TeamMember_Active = :Active";
		$sql_vars = array("SystemUser" => $SystemUser_ID, "TeamID" => $Team_ID, "Active" => $Active);
		return $this->_return_simple($sql, $sql_vars);
	}
  
  // Unorganized functions.
  function RecordWatch($SystemID, $FullName, $Email) {
		$sql = "INSERT INTO ZeMovieWtchd SET SystemUser_ID = :SystemUser, " .
						"ZeMovieWtchd_FullName = :FullName, " .
						"ZeMovieWtchd_Email = :Email, ZeMovieWtchd_Time = NOW()";
		$sql_vars = array("SystemUser" => $SystemID, 
											"FullName" => $FullName, "Email" => $Email);
		return $this->_return_nothing($sql, $sql_vars);
	}
	
	function GetMoviePassword() { 
		$sql = "SELECT * FROM ZeMoviePwd;";
		return $this->_return_simple($sql);
	}

 	function database_showtables() {
  	$sql = "SHOW TABLES";
  	return $this->_return_multiple($sql);	
 	}
 	
 	function database_showcolums($Tables) {
 		$sql = "SHOW COLUMNS FROM $Tables"; 		
 		// $sql_vars = array("Tables" => $Tables);
  	return $this->_return_multiple($sql); 
 	}
 	
 	function database_custquery($dbtable, $dbcol, $val) {
 		$sql = "SELECT * FROM $dbtable WHERE $dbcol = :VALUE LIMIT 10000";
 		$sql_vars = array("VALUE" => $val);
 		return $this->_return_multiple($sql, $sql_vars); 
 	}

  function FindVotersForEDAD($AD, $ED, $Party) {
		$sql = "SELECT * FROM DataDistrict " . 
						"LEFT JOIN DataDistrictTemporal ON (DataDistrictTemporal.DataDistrict_ID = DataDistrict.DataDistrict_ID) " .
						"LEFT JOIN Voters ON (DataDistrictTemporal.DataHouse_ID = Voters.DataHouse_ID) " . 
						"LEFT JOIN DataDistrictCycle ON (DataDistrictTemporal.DataDistrictCycle_ID = DataDistrictCycle.DataDistrictCycle_ID) " . 
						"WHERE DataDistrict_StateAssembly = :AD and DataDistrict_Electoral = :ED AND " . 
						"Voters_ID Is not null AND (Voters_Status = \"active\" OR Voters_Status = \"Inactive\") AND " .
						"Voters_RegParty = :Party AND " . 
						"(CURDATE() >=DataDistrictCycle_CycleStartDate AND CURDATE() <=DataDistrictCycle_CycleEndDate) IS NULL";		  	
		$sql_vars = array("AD" =>  $AD, "ED" => $ED, "Party" => $Party);	
		
		WriteStderr($sql_vars, "SQL Query: " . $sql);		
		return $this->_return_multiple($sql, $sql_vars);
	}  
   
  function FindPersonUser($SystemUserID) {
		$sql = "SELECT * FROM SystemUser WHERE SystemUser_ID = :ID";	
		$sql_vars = array(':ID' => $SystemUserID);											
		return $this->_return_simple($sql,  $sql_vars);
	}
	
	function FindPersonUserProfile($SystemUserID) {
		$sql = "SELECT * FROM SystemUser " . 
						"LEFT JOIN SystemUserProfile ON (SystemUser.SystemUserProfile_ID = SystemUserProfile.SystemUserProfile_ID) " . 
						"LEFT JOIN Voters ON (SystemUser.Voters_ID = Voters.Voters_ID) " . 
						"WHERE SystemUser_ID = :ID";	
		$sql_vars = array(':ID' => $SystemUserID);											
		return $this->_return_simple($sql,  $sql_vars);		
	}
	
	function InsertEmail($email) {
		$sql = "INSERT INTO SystemUser SET SystemUser_email = :Email";	
		$sql_vars = array(':Email' => $email);											
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	function CheckRegisterEmail ($email) {
		$sql = "SELECT * FROM SystemUser WHERE SystemUser_email = :Email";
		$sql_vars = array(':Email' => $email);											
		return $this->_return_simple($sql,  $sql_vars);
	}
		
	function FindGeoDiscID($GeoDescAbbrev) {
		$sql = "SELECT * FROM GeoDesc WHERE GeoGroup_ID = '3' AND GeoDesc_Abbrev = :Abbrev";
		$sql_vars = array('Abbrev' => $GeoDescAbbrev);							
		return $this->_return_simple($sql, $sql_vars);
	}

	function SaveVoterRequest($FirstName, $LastName, $DateOfBirth, $DatedFilesID, $Email, $UniqNYSVoterID, $IP) {
		$sql = "INSERT INTO SystemUserQuery SET SystemUserQuery_FirstName = :FirstName, " .
		 				"SystemUserQuery_LastName = :LastName, SystemUserQuery_DateOfBirth = :DateOfBirth, " .
    				"SystemUserQuery_DatedFileID = :DatedFilesID, SystemUserQuery_Email = :Email, " .
    				"SystemUserQuery_UniqNYSVoterID = :UniqNYSVoterID, SystemUserQuery_IP = :IP, SystemUserQuery_Date = NOW()";

		$sql_vars = array("FirstName" => $FirstName, "LastName" => $LastName, 
											"DateOfBirth" => $DateOfBirth, "DatedFilesID" => $DatedFilesID,
    									"Email" => $Email, "UniqNYSVoterID" => $UniqNYSVoterID,
    									"IP" => $IP);
		return $this->_return_nothing($sql, $sql_vars);
	}

	function SearchVoterDB($FirstName, $LastName, $DOB, $Status = "") {
		$CompressedFirstName = preg_replace("/[^a-zA-Z]+/", "", $FirstName);
		$CompressedLastName = preg_replace("/[^a-zA-Z]+/", "", $LastName);
		
		$sql = "SELECT * FROM VotersIndexes " .
						"LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID ) " . 
						"LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID ) " .
						"LEFT JOIN Voters ON (Voters.VotersIndexes_ID = VotersIndexes.VotersIndexes_ID) " . 
						"WHERE DataFirstName_Compress = :FirstName AND " . 
						"DataLastName_Compress = :LastName " .
						"AND VotersIndexes_DOB = :DOB"; 
		$sql_vars = array('FirstName' => $CompressedFirstName, 
											'LastName' => $CompressedLastName, 
											'DOB' => $DOB);
						
		if (! empty ($Status)) {
			$sql .= " AND Voters_Status = :Status";
			$sql_vars["Status"] = $Status;
		}
						
		WriteStderr($sql, "SQL request");
					
		return $this->_return_multiple($sql, $sql_vars);		
	}
	
	function CreatePositionEntry($DataArray) {
		$sql = "INSERT INTO CandidateElection SET ";
		$FirstTime = "";
		$sql_vars = array();
		
		if ( ! empty ($DataArray)) {
			foreach ($DataArray as $var => $data) {
				if ( ! empty ($data)) { 
					if ( $FirstTime == 0 ) { $FirstTime = 1; } else { $sql .= ", "; }
					$sql .=	$var . " = :" . $var; 
					$sql_vars[$var] = $data;
				}
			}
		}
		
		if ( $FirstTime == 1) {
			$this->_return_nothing($sql, $sql_vars);
			
			$sql = "SELECT LAST_INSERT_ID() as CandidateElection_ID";
			$ret = $this->_return_simple($sql); 	
			return $ret["CandidateElection_ID"];
		}
	}
	
	function InsertCandidateElection($CandidateElectionData) {
			
		if (! empty ($CandidateElectionData["ElectionID"])) {
			$sql = "INSERT INTO CandidateElection SET ";
			$MatchTableName = array(
					"ElectionID" => "Elections_ID", 
					"PosType" => "CandidateElection_PositionType", 
					"Party" => "CandidateElection_Party", 
					"PosText" => "CandidateElection_Text", 
					"PetText" => "CandidateElection_PetitionText", 
					"URLExplain" => "CandidateElection_URLExplain", 
					"Number" => "CandidateElection_Number", 
					"Order" => "CandidateElection_DisplayOrder", 
					"Display" => "CandidateElection_Display", 
					"Sex" => "CandidateElection_Sex", 
					"DBTable" => "CandidateElection_DBTable", 
					"DBValue" => "CandidateElection_DBTableValue", 
					"NbrVoters" => "CandidateElection_CountVoter"
			);
			
			$firsttime = 0;
			foreach ($MatchTableName as $index => $var) {			
				if (! empty ($CandidateElectionData[$index])) { 
					if ($firsttime == 0) { $firsttime = 1;} else { $sql .= ", "; }
					$sql .= $var . " = :" . $index;
				}
			}
		}
		
		$this->_return_nothing($sql, $CandidateElectionData);
		$sql = "SELECT LAST_INSERT_ID() as CandidateElection_ID";
		return $this->_return_simple($sql); 	
	}
	
	function FindElectionType($ElectionID, $RegParty, $TypeElection, $TypeValue) {
		$sql = "SELECT * FROM CandidateElection WHERE Elections_ID = :ElectionID AND " .
						"CandidateElection_Party = :Party AND CandidateElection_DBTable = :DBTable AND " .
						"CandidateElection_DBTableValue = :DBValue";

						
		$sql_vars = array("ElectionID" => $ElectionID, "Party" => $RegParty, "DBTable" => $TypeElection, "DBValue" => $TypeValue);		
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function FindElectionFromPositionID($ElectionID, $PositionID, $TypeElection, $TypeValue) {
		$sql = "SELECT * FROM CandidateElection " .  
						"LEFT JOIN ElectionsPosition ON (ElectionsPosition.ElectionsPosition_ID = CandidateElection.ElectionsPosition_ID) " . 
						"WHERE Elections_ID = :ElectionID AND " .
						"CandidateElection.ElectionsPosition_ID = :PositionID AND CandidateElection_DBTable = :DBTable AND " .
						"CandidateElection_DBTableValue = :DBValue";
						
		$sql_vars = array("ElectionID" => $ElectionID, "PositionID" => $PositionID, "DBTable" => $TypeElection, "DBValue" => $TypeValue);		
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function FindInPartyCall($ElectionID, $County, $Party, $DBTable, $DBValue) {
		$sql = "SELECT * FROM ElectionsPartyCall WHERE " .
						"Elections_ID = :ElectionID AND DataCounty_ID = :County AND " .
						"ElectionsPartyCall_Party = :Party AND ElectionsPartyCall_DBTable = :DBTable AND " . 
						"ElectionsPartyCall_DBTableValue = :DBValue";
		$sql_vars = array("ElectionID" => $ElectionID, "County" => $County,  "Party" => $Party, 
											"DBTable" => $DBTable, "DBValue" => $DBValue);		
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function FindElectionsAvailable ($DataState_ID, $Party) {
		$sql = "SELECT * FROM ElectionsPosition WHERE DataState_ID = :DataState_ID ";
		$sql_vars = array("DataState_ID" => $DataState_ID);
		
		if ( ! empty ($Party)) {
			$sql .= "AND (" . 
							"(ElectionsPosition_Type = 'party' AND ElectionsPosition_Party = :Party) ".
							"OR " .
							"(ElectionsPosition_Type = 'office' AND ElectionsPosition_Party IS NULL) " .
							")";
			$sql_vars["Party"] = $Party;
		} else {
			$sql .= "AND ElectionsPosition_Party IS NULL ";
		}
	
		$sql .= "ORDER BY ElectionsPosition_Order";
	
	  return $this->_return_multiple($sql, $sql_vars);
	}
	
	function FindElectionInfoForPetition ($DistrictID, $DBTable = NULL, $Party = NULL, $DateToMatch = true) {
		$sql = "SELECT *, UNIX_TIMESTAMP(Elections_Date) AS UnixElection_Date ";
		
		$sql .= ", CONCAT(DataDistrict_StateAssembly, LPAD(DataDistrict_Electoral, 3, 0)) AS ADED ";
		
		$sql .=	"FROM DataDistrict LEFT JOIN DataCounty ON (DataCounty.DataCounty_ID = DataDistrict.DataCounty_ID) " . 
						"LEFT JOIN DataState ON (DataState.DataState_ID = DataCounty.DataState_ID) " .
						"LEFT JOIN ElectionsPosition ON (DataState.DataState_ID = ElectionsPosition.DataState_ID) " . 
						"LEFT JOIN CandidateElection ON (CandidateElection.ElectionsPosition_ID = ElectionsPosition.ElectionsPosition_ID ";
						
		$sql .= "AND ";
		$sql .= "CandidateElection_DBTableValue = CONCAT(DataDistrict_StateAssembly, LPAD(DataDistrict_Electoral, 3, 0)) ";
							
		$sql .=	") " .
						"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) ";
						
		$sql .= "WHERE ElectionsPosition_DBTable = :DBTable AND DataDistrict_ID = :DistrictID ";
		
		if ( $DateToMatch == true) {
			$sql .= "AND Elections_Date > CURDATE()";
		}
		
		$sql_vars = array("DBTable" => $DBTable, "DistrictID" => $DistrictID);
		
		if ( ! empty ($Party)) {
			$sql .= " AND ElectionsPosition_Party = :Party";
			$sql_vars["Party"] = $Party;
		}
		
		$sql .= " LIMIT 100";
		
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function ListPetitionGroup($GroupID = NULL, $Status = NULL) {
		$sql = "SELECT * FROM CandidateGroup " .
						"LEFT JOIN Candidate ON (CandidateGroup.Candidate_ID = Candidate.Candidate_ID) " . 
						"LEFT JOIN DataCounty ON (DataCounty.DataCounty_ID = CandidateGroup.DataCounty_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " . 
						"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
						"LEFT JOIN CandidateComRplceSet ON (CandidateComRplceSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateComRplce ON (CandidateComRplceSet.CandidateComRplce_ID = CandidateComRplce.CandidateComRplce_ID) ";
		if ( ! empty ($GroupID)) {
			$sql .= "WHERE CandidateGroup.CandidateSet_ID = :CandidateGroup_ID ";
			$sql_vars = array("CandidateGroup_ID" => $GroupID);
		} else {
			$sql_vars = array();
		}
						
		$sql .= "ORDER BY CandidateElection_DisplayOrder ASC";							
		return $this->_return_multiple($sql, $sql_vars);	
	}

	function ListElectedPositions($StateAbbrev, $StateID = NULL, $PositionID = NULL, $Party = NULL, $PositionCode = NULL) {
		$sql = "SELECT * FROM  DataState " .
						"LEFT JOIN ElectionsPosition ON (DataState.DataState_ID = ElectionsPosition.DataState_ID) ";
						
		$sql_vars = array();
		$and = "";
		
		if ( ! empty ($PositionCode) || ! empty ($Party) || ! empty ($PositionID) || ! empty ($StateID)) {
			$sql .= "WHERE ";

			if ( ! empty ($PositionCode )) {
				$sql .= " ElectionsPosition_DBTable = :PositionCode ";
				$sql_vars["PositionCode"] = $PositionCode;
				$and = " AND";
			}
			
			if ( ! empty ($Party)) { 
				$sql .= $and . " ElectionsPosition_Party = :Party";
				$sql_vars["Party"] = $Party;
				$and = " AND ";
			}

			if ( $PositionID > 0) {
				$sql .= $and . "ElectionsPosition_ID = :PosID";
				$sql_vars['PosID'] = $PositionID;	
			} else {
				if ( $StateID == "id") {
					$sql .= $and . "DataState.DataState_ID = :State ";
				}	else {	
					$sql .= $and . "DataState.DataState_Abbrev = :State ";				
				}
				$sql_vars['State'] = $StateAbbrev;	
				$sql .= "ORDER BY ElectionsPosition_Order";
			} 
		}
		
		WriteStderr($sql, "SQL:");	
		WriteStderr($sql_vars, "SQL VAR:");	
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function ListParties($StateID, $OfficialOnly = false, $PartyID = NULL) {
		$sql = "SELECT * FROM DataParty WHERE ";
	
		if ( $PartyID > 0) {
			$sql .= "DataParty_ID = :DataParty";
			$sql_vars = array("DataParty" => $PartyID);
		} else {
			$sql .= "DataState_ID = :StateID";
			$sql_vars = array("StateID" => $StateID);
		
			if ( $OfficialOnly == true) {
				$sql .= " AND DataParty_Recognized = :Recog";
				$sql_vars["Recog"] = "yes";
			}
		}
			
		return $this->_return_multiple($sql, $sql_vars);
	}

	function DisplayElectionPositions($ID) {
		$sql = "SELECT * FROM ElectionsPosition " . 
						"WHERE ElectionsPosition_ID = :ID ";
		$sql_vars = array('ID' => $ID);
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function ListCandidatePetitions($CandidateID = NULL) {
		$sql = "SELECT * FROM CandidateProfile " . 
						"LEFT JOIN Candidate ON " . 
						"(Candidate.Candidate_ID = CandidateProfile.Candidate_ID) ";
		
		if (! empty ($CandidateID)) {
			$sql .= "WHERE CandidateProfile.Candidate_ID = :CandidateID";
			$sql_vars = array("CandidateID" => $CandidateID);
			return $this->_return_simple($sql, $sql_vars);
		}
		
		return $this->_return_multiple($sql);
	}
	
	function ListCandidateProfile($CandidateID = NULL) {
		$sql = "SELECT * FROM CandidateProfile ";
		
		if (! empty ($CandidateID)) {
			$sql .= "WHERE Candidate_ID = :CandidateID";
			$sql_vars = array("CandidateID" => $CandidateID);
			return $this->_return_simple($sql, $sql_vars);
		}
		
		return $this->_return_multiple($sql);
	}
	
	function updatecandidateprofile($Candidate_ID, $CandidateProfile) {
	
		if ($Candidate_ID > 0) {
			
			$MatchTableName = array(
				"PicFile" => "CandidateProfile_PicFileName", 
				"PDFFile" => "CandidateProfile_PDFFileName", 
				"Fist"	 =>  "CandidateProfile_FirstName", 
				"Last"	 => "CandidateProfile_LastName", 
				"Full"	 =>  "CandidateProfile_Alias", 
				"URL"	 =>  "CandidateProfile_Website", 
				"Email"	 => "CandidateProfile_Email", 
				"Twitter"	 => "CandidateProfile_Twitter", 
				"Facebook"	 => "CandidateProfile_Facebook", 
				"Instagram"	 => "CandidateProfile_Instagram", 
				"TikTok"	 => "CandidateProfile_TikTok", 
				"YouTube"	 => "CandidateProfile_YouTube", 
				"Ballotpedia"	 => "CandidateProfile_BallotPedia", 
				"Phone"	 => "CandidateProfile_PhoneNumber", 
				"Fax"	 => "CandidateProfile_FaxNumber", 
				"Platform"	 => "CandidateProfile_Statement"			
			);
			
			
			$return = $this->ListCandidateProfile($Candidate_ID);	
			# This is to set the collums that changed.
			foreach ($CandidateProfile as $index => $var) {			
				if ( $var == $return[$MatchTableName[$index]]) {
					unset ($CandidateProfile[$index]);
				}
			}
									
			if ( empty ($return)) {	$sql = "INSERT INTO"; } 
			else { $sql = "UPDATE"; }
			$sql .= " CandidateProfile SET ";
			$sql_vars = array("Candidate_ID" => $Candidate_ID);
			$FirstTime = 0;
			
			
			$firsttime = 0;
			foreach ( $CandidateProfile as $index => $var) {
				if ( ! empty ($var)) {
					if ( $firsttime ) { $sql .= ", "; }				
					$sql .= $MatchTableName[$index] . " = :" . $index; 
					$sql_vars[$index] =	$CandidateProfile[$index]; 
					$firsttime = 1;
				}
			}
			
			## Add the null tables at the end;
			foreach ( $CandidateProfile as $index => $var) {
				if ( empty ($CandidateProfile[$index])) {
					if ( $firsttime ) { $sql .= ", "; }	
					$sql .= $MatchTableName[$index] . " = NULL";
					$firsttime = 1;
				}
			}
			
			if ( empty ($return)) {	$sql .= " ,Candidate_ID = :Candidate_ID"; }
			else { $sql .= " WHERE Candidate_ID = :Candidate_ID"; }
			
			if (! $firsttime) return;
			$this->_return_nothing($sql, $sql_vars);
			
			$sql = "SELECT LAST_INSERT_ID() as CandidateProfile_ID";
			return $this->_return_simple($sql); 
		}
		
	}	
	
	function CheckCandidateGroups ($CandidatesIDs) {
  	$sql = "SELECT * FROM CandidateGroup WHERE "; 
  	
   	if ( ! empty ($CandidatesIDs)) {
	  	foreach ($CandidatesIDs as $index => $var) {
  			$sql .= $and ."Candidate_ID = '" . intval($var) . "'";
  			$and = " OR ";
  		}
  	}
  	
  	return $this->_return_multiple($sql);
  }
  
	
	function updatecandidatesetorder($CandidateGroupID, $Order) {
		if ( $CandidateGroupID > 0 && $Order > 0) {
			$sql = "UPDATE CandidateGroup SET CandidateGroup_Order = :Order WHERE CandidateGroup_ID = :GroupID";
			return $this->_return_nothing($sql, array("Order" => $Order, "GroupID" => $CandidateGroupID));
		}
	}
	
	function addcandidateprofileid($CandidateID, $CandidateProfileID) {
		if ( $CandidateID > 0) {
			$sql = "UPDATE Candidate SET CandidateProfile_ID = :ProfID WHERE Candidate_ID = :CandID";
			$sql_vars = array("ProfID" => $CandidateProfileID, "CandID" => $CandidateID);	
			return $this->_return_nothing($sql, $sql_vars);
		}
	}
	
	function ListPetitionCandidateSet($PetitionSetID) {
		$sql = "SELECT * FROM CandidateSet " .
						"LEFT JOIN CandidateGroup ON (CandidateGroup.CandidateSet_ID = CandidateSet.CandidateSet_ID) " .
						"LEFT JOIN Candidate ON (Candidate.Candidate_ID = CandidateGroup.Candidate_ID) " . 
						"LEFT JOIN CandidateElection ON (Candidate.CandidateElection_ID = CandidateElection.CandidateElection_ID) " . 
						"WHERE CandidateSet.CandidateSet_ID = :CandidateSet " . 
						"ORDER BY CandidateGroup_Order";
		return $this->_return_multiple($sql, array('CandidateSet'=> $PetitionSetID));
	}
	
	function ListCandidateInformationByUNIQ($UniqID, $ElectionID) {
		$sql = "SELECT * FROM Candidate " . 
						"LEFT JOIN CandidateGroup ON (Candidate.Candidate_ID = CandidateGroup.Candidate_ID) " . 
						"LEFT JOIN CandidateSet ON (CandidateGroup.CandidateSet_ID = CandidateSet.CandidateSet_ID) " .
						"LEFT JOIN CandidateElection ON (Candidate.CandidateElection_ID = CandidateElection.CandidateElection_ID) " . 
						"LEFT JOIN Team ON (Candidate.Team_ID = Team.Team_ID) " .
						"WHERE Candidate.Candidate_UniqStateVoterID = :UniqID AND Elections_ID = :ElectionID " .		
						"ORDER BY CandidateGroup.CandidateSet_ID, CandidateGroup_Order";
		return $this->_return_multiple($sql, array('UniqID' => $UniqID, 'ElectionID' => $ElectionID));
	}
  
	function ListCandidateInformation($SystemUserID) {
		$sql = "SELECT * FROM Candidate " . 
						"LEFT JOIN CandidateGroup ON (Candidate.Candidate_ID = CandidateGroup.Candidate_ID) " . 
						"LEFT JOIN CandidateSet ON (CandidateGroup.CandidateSet_ID = CandidateSet.CandidateSet_ID) " .
						"WHERE Candidate.SystemUser_ID = :SystemUserID";
		return $this->_return_multiple($sql, array('SystemUserID' => $SystemUserID));
	}
	
	function ListCandidateTeamInformation($TeamID) {
		$sql = "SELECT * FROM Candidate " . 
						"LEFT JOIN CandidateGroup ON (Candidate.Candidate_ID = CandidateGroup.Candidate_ID) " . 
						"LEFT JOIN CandidateSet ON (CandidateSet.CandidateSet_ID = CandidateGroup.CandidateSet_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " .
						"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
						"LEFT JOIN DataDistrictTown ON (Candidate.DataDistrictTown_ID = DataDistrictTown.DataDistrictTown_ID) " . 
						"WHERE Candidate.Team_ID = :Team_ID";
						
		return $this->_return_multiple($sql, array('Team_ID' => $TeamID));
	}
	
	function ListElections($SomeVariable) {
		$sql = "SELECT * FROM CandidateElection " . 
						"LEFT JOIN Candidate ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID)";
		return $this->_return_multiple($sql);
	}
	
	function ListElectionsDates ($limit = 50, $start = 0, $futureonly = false, $StateID = NULL) {
		$sql = "SELECT DISTINCT DataState_Abbrev, Elections_Text, Elections_Date, Elections_Type FROM DataState " . 
						"LEFT JOIN ElectionsPosition ON (ElectionsPosition.DataState_ID = DataState.DataState_ID) " .
						"LEFT JOIN CandidateElection ON (ElectionsPosition.ElectionsPosition_ID = CandidateElection.ElectionsPosition_ID) " . 
						"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) ";
		
		// Not very elegant but I am tired.
		if ( $futureonly == true ) {
			$sql .= "WHERE (Elections_Date >= NOW()) ";
			if ( $StateID > 0) { $sql .= "AND DataState.DataState_ID = :StateID "; }
		} else {
			if ( $StateID > 0 ) { $sql .= "WHERE DataState.DataState_ID = :StateID "; }
		}
		if ( empty ($StateID)) { $sql .= "WHERE Elections_Date is NOT NULL ";	}
		$sql .= "ORDER BY Elections_Date, Elections_Type LIMIT $start, $limit";	

		if ( $StateID > 0) {
			$sql_vars = array("StateID" => $StateID);
			return $this->_return_multiple($sql, $sql_vars);			
		}
		
		return $this->_return_multiple($sql);
	}
	
	function ListStates() {
		$sql = "SELECT * FROM DataState ORDER BY DataState.DataState_Abbrev";
		return $this->_return_multiple($sql);
	}
	
	function CandidateElection($DBTable, $DBTableValue, $FromDate = NULL,  $Party = NULL, $ElectionID = NULL) {
		$sql = 	"SELECT * FROM CandidateElection " .
						"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
						"WHERE CandidateElection_DBTable = :DBTable AND " . 
						"CandidateElection_DBTableValue = :DBValue";
		$sql_vars = array('DBTable' => $DBTable, 'DBValue' => $DBTableValue);						
		
		if ( ! empty ($FromDate)) {
			$sql .= " AND Elections_Date >= :FromDate";
			$sql_vars["FromDate"] = $FromDate;
		}
										
		if ( ! empty ($Party)) {
			$sql .= " AND CandidateElection_Party = :Party";
			$sql_vars["Party"] = $Party;
		}
		
		if ( ! empty ($ElectionID)) {
			$sql .= " AND CandidateElection.Elections_ID = :ElectionID";
			$sql_vars["ElectionID"] = $ElectionID;
		}
		
		return $this->_return_multiple($sql, $sql_vars);
	}

	function ListCandidateNomination($SystemUserID) {
		$sql = "SELECT * FROM CanNomination WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array('SystemUserID' => $SystemUserID);		
	}
	
	function GetRandomCandidateSetID($RandomText) {
		$sql = "SELECT * FROM CandidateSet WHERE CandidateSet_Random = :GroupRandomText";		
		return $this->_return_simple($sql, array("GroupRandomText" => $RandomText));
	}
	
	function NextPetitionSet($SystemUser_ID) {
		if ( $SystemUser_ID > 0) {

			do {
				$RandomString = PrintRandomText(12);
				$ret = $this->GetRandomCandidateSetID($RandomString);
			} while ( ! empty ($ret["CandidateSet_ID"]));
			
			print "RandomString: $RandomString<BR>";

			$sql = "INSERT INTO CandidateSet SET SystemUser_ID = :SystemUserID, CandidateSet_Random = :Random, CandidateSet_TimeStamp = NOW()";
			$sql_vars = array("SystemUserID" => $SystemUser_ID, "Random" => $RandomString);
			$this->_return_nothing($sql, $sql_vars);
		
			$sql = "SELECT LAST_INSERT_ID() as CandidateSet";
			$ret =  $this->_return_simple($sql);
			$ret["Random"] = $RandomString;
			return $ret;
		}		
	}
	
	function InsertCandidateSet($CandidateID, $CandidateSetID, $Party, $CountyID, $Order = "1", $WaterMark = "yes") {
		$sql = "INSERT INTO CandidateGroup SET " .
						"CandidateSet_ID = :CanPetSetID, Candidate_ID = :CandidateID, " .
						"DataCounty_ID = :CountyID, CandidateGroup_Party = :Party, " .
						"CandidateGroup_Watermark = :Water, CandidateGroup_Order = :Order";
						
						
		$sql_vars = array("CanPetSetID" => $CandidateSetID, "CandidateID" => $CandidateID, 
											"CountyID" => $CountyID, "Party" => $Party, "Water" => $WaterMark, "Order" => $Order);			
		$this->_return_nothing($sql, $sql_vars);
		
		$sql = "SELECT LAST_INSERT_ID() as CandidateSet_ID";
		return $this->_return_simple($sql);
	}
	
	

	
	function InsertCandidate($SystemUserID, $UniqNYSVoterID, $RawVoterID, $DataCountyID, $CandidateElectionID, $Party, $DisplayName,
														$Address, $DBTable, $DBValue,	$StatsVoters, $Status, $TeamID = NULL, $NameSet = NULL) {
																														
		$WaterMark = 'no';
																														
		$sql = "INSERT INTO Candidate SET SystemUser_ID = :SystemUserID, Candidate_UniqStateVoterID = :UniqNYSVoterID, " .
						"Voters_ID = :RawVoterID, DataCounty_ID = :DataCountyID," .
						"CandidateElection_ID = :CandidateElectionID, Candidate_Party = :Party, Candidate_DispName = :DisplayName, " .
						"Candidate_DispResidence = :Address, CandidateElection_DBTable = :DBTable, " .
						"CandidateElection_DBTableValue = :DBValue, Candidate_StatsVoters = :StatsVoters, " . 
						"Candidate_Status = :Status, Candidate_Watermark = :WaterMark";
						
		$sql_vars = array("SystemUserID" => $SystemUserID, "UniqNYSVoterID" => $UniqNYSVoterID, 
											"RawVoterID" => $RawVoterID, "DataCountyID" => $DataCountyID, 
											"CandidateElectionID" => $CandidateElectionID, 
											"Party" => $Party, "DisplayName" =>  $DisplayName, 
											"Address" => $Address, "DBTable" => $DBTable, "DBValue" => $DBValue, 
											"StatsVoters" => $StatsVoters, "Status" => $Status, "WaterMark" => $WaterMark);
											
		if ( $NameSet != NULL ) {
			$sql .= ", Candidate_PetitionNameset = :NameSet";
			$sql_vars["NameSet"] = $NameSet;
		}
		
		if ( $TeamID != NULL) {
			$sql .= ", Team_ID = :TeamID";
			$sql_vars["TeamID"] = $TeamID;
		}
		
		$this->_return_nothing($sql, $sql_vars);
		
		$sql = "SELECT LAST_INSERT_ID() as Candidate_ID";
		return $this->_return_simple($sql);
	}

	function SearchPetitionCandidate($SystemUserID, $UniqNYSVoterID, $RawVoterID, $DataCountyID, $CandidateElectionID, 
																		$Party, $DisplayName,	$Address, $DBTable, $DBValue, $Status, $TeamID = NULL) {
																														
		$sql = "SELECT * FROM Candidate WHERE SystemUser_ID = :SystemUserID AND Candidate_UniqStateVoterID = :UniqNYSVoterID AND " .
						"Voters_ID = :RawVoterID AND  DataCounty_ID = :DataCountyID AND " .
						"CandidateElection_ID = :CandidateElectionID AND  Candidate_Party = :Party AND  Candidate_DispName = :DisplayName AND  " .
						"Candidate_DispResidence = :Address AND CandidateElection_DBTable = :DBTable AND  " .
						"CandidateElection_DBTableValue = :DBValue AND  " . 
						"Candidate_Status = :Status";
						
		$sql_vars = array("SystemUserID" => $SystemUserID, "UniqNYSVoterID" => $UniqNYSVoterID, 
											"RawVoterID" => $RawVoterID, "DataCountyID" => $DataCountyID, 
											"CandidateElectionID" => $CandidateElectionID, 
											"Party" => $Party, "DisplayName" =>  $DisplayName, 
											"Address" => $Address, "DBTable" => $DBTable, "DBValue" => $DBValue, 
											"Status" => $Status);

		if ( $TeamID != NULL) {
			$sql .= " AND Team_ID = :TeamID";
			$sql_vars["TeamID"] = $TeamID;
		}
		
		return $this->_return_multiple($sql, $sql_vars);
	}

	function CandidateNomination($SystemUserID, $ElectionID, $CandidateID) {
		$sql = "INSERT INTO CanNomination SET Candidate_ID = :CandidateID, SystemUser_ID = :SystemUserID, CandidateElection_ID = :CandidateElectionID";
		$sql_vars = array('CandidateID' => $CandidateID, 'SystemUserID' => $SystemUserID, 'CandidateElectionID' => $ElectionID);
		return $this->_return_nothing($sql, $sql_vars);
	}


	function ListCandidates() {
		$sql = "SELECT * FROM Candidate " . 
						"LEFT JOIN CandidateElection ON (Candidate.CandidateElection_ID = CandidateElection.CandidateElection_ID) " .
						"LEFT JOIN Elections ON (Elections.Elections_ID = CandidateElection.Elections_ID) " .
						"LEFT JOIN FillingDoc ON (FillingDoc.Candidate_ID = Candidate.Candidate_ID) " . 
						"ORDER BY Elections_Date DESC, CandidateElection.CandidateElection_DBTable, CandidateElection.CandidateElection_DBTableValue";
		return $this->_return_multiple($sql);
	}

	function ListOnlyElections() {
		$sql = "SELECT * FROM CandidateElection";
		return $this->_return_multiple($sql);
	}
	
	function ListNominations($SystemUserID) {
		$sql = "SELECT * FROM CanNomination " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = CanNomination.CandidateElection_ID) " .
						"WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array("SystemUserID" => $SystemUserID);				
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function InsertNewNomination($CandidateElection, $SystemUser, $FirstName, $LastName, $Email, $Phone) {
		$sql = "INSERT INTO CanNomination SET CandidateElection_ID = :CandidateElection_ID, SystemUser_ID = :SystemUserID, " . 
						"CanNomination_FirstName = :FirstName, CanNomination_LastName = :LastName, CanNomination_Email = :Email, "  .
						"CanNomination_Phone = :Phone";
		$sql_vars = array('CandidateElection_ID' => $CandidateElection, 'SystemUserID' => $SystemUser, 'FirstName' =>  $FirstName, 
		 									'LastName'=> $LastName, 'Email'=> $Email, 'Phone'=> $Phone);
		return $this->_return_nothing($sql, $sql_vars);
	}
	
	function ListCandidatePetition($SystemUserID) {
		$sql = "SELECT * FROM CandidatePetitionSet " .
						"LEFT JOIN CandidateGroup ON (CandidateGroup.CandidatePetitionSet_ID = CandidatePetitionSet.CandidatePetitionSet_ID) " .
						"LEFT JOIN Candidate ON (CandidateGroup.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CanWitnessSet ON (CanWitnessSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateWitness ON (CanWitnessSet.CandidateWitness_ID = CandidateWitness.CandidateWitness_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " .
						"WHERE CandidatePetitionSet.SystemUser_ID = :SystemUserID";
		$sql_vars = array("SystemUserID" => $SystemUserID);				
		return $this->_return_multiple($sql, $sql_vars);
	}

	function GetPetitionsSumary($SystemUser_ID) {
		$sql = "SELECT count(*) as CandidateTotal, count(CandidatePetition_SignedDate) as CandidateSigned " .
						"FROM Candidate LEFT JOIN CandidatePetition ON (Candidate.Candidate_ID = CandidatePetition.Candidate_ID) " .
						"WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array("SystemUserID" => $SystemUser_ID);
	 	return $ret = $this->_return_simple($sql, $sql_vars);	 
	}

	function ListCandidateNominatedForPetition($SystemUserID) {
		$sql = "SELECT * FROM CanNomination " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = CanNomination.CandidateElection_ID) " .
						"LEFT JOIN Candidate ON (CanNomination.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CanWitnessSet ON (CanWitnessSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateWitness ON (CanWitnessSet.CandidateWitness_ID = CandidateWitness.CandidateWitness_ID) " .
						"WHERE CanNomination.SystemUser_ID = :SystemUserID";
		$sql_vars = array("SystemUserID" => $SystemUserID);				
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function AddIntoOldEmailTable($NewEmail, $OldEmail, $OldStatus, $SystemUserID) {		
		$sql = "INSERT INTO SystemUserOldEmail SET " .
						"SystemUser_ID = :SystemUserID, SystemUserOldEmail_OldEmail = :OldEmail, " .
						"SystemUserOldEmail_OldStatus = :OldStatus, SystemUserOldEmail_NewEmail = :NewEmail, " .
						"SystemUserOldEmail_Timestamp = NOW()";
		$sql_vars = array("SystemUserID" => $SystemUserID, "OldEmail" => $OldEmail,
											"OldStatus" => $OldStatus, "NewEmail" => $NewEmail);
		
	}
	
	function InsertCandidatePetitionSet($System_ID = NULL) {
		
		$sql = "INSERT INTO CandidatePetitionSet SET CandidatePetitionSet_TimeStamp = NOW()";
		$sql_vars = array('CanSetID' => $CandidatePetitionSet_ID);
		
		if ( ! empty ($System_ID)) {
			$sql .= ", SystemUser_ID = :SystemID";
			$sql_vars["SystemID"] =  $System_ID;
		}
		$this->_return_nothing($sql, $sql_vars);
		
		$sql = "SELECT LAST_INSERT_ID() as CandidatePetitionSet_ID";
		return $this->_return_simple($sql);
	}
	
	function ReturnVoterIndex($SingleIndex) {
				$sql = "SELECT * FROM VotersIndexes " .
						"LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID ) " . 
						"LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID ) " .
						"LEFT JOIN DataMiddleName ON (DataMiddleName.DataMiddleName_ID = VotersIndexes.DataMiddleName_ID ) " .
						"LEFT JOIN Voters ON (Voters.VotersIndexes_ID = VotersIndexes.VotersIndexes_ID) " . 
						"LEFT JOIN DataHouse ON (Voters.DataHouse_ID = DataHouse.DataHouse_ID) " . 
						"LEFT JOIN DataAddress ON (DataHouse.DataAddress_ID = DataAddress.DataAddress_ID) " .
						"LEFT JOIN DataCity ON (DataAddress.DataCity_ID = DataCity.DataCity_ID) " .
						"LEFT JOIN DataStreet ON (DataAddress.DataStreet_ID = DataStreet.DataStreet_ID) " .							
						"LEFT JOIN DataDistrictTemporal on (DataHouse.DataHouse_ID = DataDistrictTemporal.DataHouse_ID) " .
						"LEFT JOIN DataDistrict ON (DataDistrictTemporal.DataDistrict_ID = DataDistrict.DataDistrict_ID) " .		
						"LEFT JOIN DataCounty ON (DataDistrict.DataCounty_ID = DataCounty.DataCounty_ID) " .	
						"LEFT JOIN DataState ON (DataCounty.DataState_ID = DataState.DataState_ID) " .
						"WHERE VotersIndexes.VotersIndexes_ID = :SingleIndex AND Voters_Status = 'Active'";
						
		$sql_vars = array("SingleIndex" => $SingleIndex);		
		return $this->_return_simple($sql, $sql_vars);		
	}
	
	function GetPetitionsForCandidate($CandidateID = 0, $SystemUserID = 0) {

		if ( $CandidateID == 0 && $SystemUserID == 0) return 0;
		
		$sql = "SELECT Candidate.Candidate_ID, Candidate.SystemUser_ID, Candidate.CandidateElection_ID, Candidate.Candidate_Party, " . 
						"Candidate.Candidate_DisplayMap, Candidate.Candidate_DispName, Candidate.Candidate_DispResidence, Candidate.CandidateAptment_ID, " . 
						"Candidate.Candidate_StatementPicFileName, Candidate.Candidate_StatementWebsite, Candidate.Candidate_StatementEmail, " . 
						"Candidate.Candidate_StatementTwitter, Candidate.Candidate_StatementPhoneNumber, Candidate.Candidate_StatementText, " . 
						"Candidate.CandidateElection_DBTable, Candidate.CandidateElection_DBTableValue, Candidate.Candidate_StatsVoters, " . 
						"Candidate.Candidate_Status, Candidate.Candidate_NominatedBy, CandidatePetition.CandidatePetition_ID, CandidatePetition.Candidate_ID, " . 
						"CandidatePetition.FollowUp_ID, CandidatePetition.CandidatePetition_Order, " . 
						"CandidatePetition.VotersIndexes_ID, CandidatePetition.CandidatePetition_VoterFullName, " . 
						"CandidatePetition.CandidatePetition_VoterResidenceLine1, CandidatePetition.CandidatePetition_VoterResidenceLine2, " . 
						"CandidatePetition.CandidatePetition_VoterResidenceLine3, CandidatePetition.CandidatePetition_VoterCounty, CandidatePetition.DataStreet_ID, " . 
						"CandidatePetition.Voters_ResHouseNumber, CandidatePetition.Voters_ResFracAddress, " . 
						"CandidatePetition.Voters_ResPreStreet, CandidatePetition.Voters_ResStreetName, CandidatePetition.Voters_ResPostStDir, " . 
						"CandidatePetition.Voters_ResApartment, CandidatePetition.Voters_Status, CandidatePetition.CandidatePetition_SignedDate " . 
						"FROM Candidate " .
						"LEFT JOIN CandidatePetition ON (CandidatePetition.Candidate_ID = Candidate.Candidate_ID) " .
						"WHERE " ;
						
		if ( $CandidateID > 0 ) {
			$sql .= "Candidate_ID = :CandidateID";
			$sql_vars["CandidateID"] = $CandidateID;
			if ( $SystemUserID > 0 ) { $sql .= " AND "; }
		}
		
		if ( $SystemUserID > 0 ) {
			$sql .= "SystemUser_ID = :SystemUserID";
			$sql_vars["SystemUserID"] = $SystemUserID;
		}
			
		$sql .= "	ORDER BY CandidatePetition_Order";
		
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function GetPetitionSignNames($SystemID, $DateID) {
		$sql = "SELECT * FROM Candidate LEFT JOIN CandidatePetition " .
						"ON (Candidate.Candidate_ID = CandidatePetition.Candidate_ID) " .
						"WHERE SystemUser_ID = :SystemUserID AND " . 
						"CandidatePetition.Raw_Voter_Dates_ID = :DateID";
		$sql_vars = array(":SystemUserID" => $SystemID, ":DateID" => $DateID);
		return $this->_return_multiple($sql, $sql_vars);
	}

	function SearchRawVoterInfo($UniqNYSVoterID) { 
		$sql = "SELECT * FROM Voters " .  
						"LEFT JOIN DataHouse ON (Voters.DataHouse_ID = DataHouse.DataHouse_ID) " . 
						"LEFT JOIN DataAddress ON (DataHouse.DataAddress_ID = DataAddress.DataAddress_ID) " . 
						"LEFT JOIN DataCounty ON (DataCounty.DataCounty_BOEID = DataAddress.DataCounty_ID) " .										
						"WHERE Voters_UniqStateVoterID = :Uniq AND Voters_Status = 'active'";
		$sql_vars = array("Uniq" => $UniqNYSVoterID);		
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function GetAdminStats() {
		$sql = "SELECT * FROM SystemStats";
		return $this->_return_multiple($sql);		
	}

	function UpdateSystemUserWithVoterCard($SystemUser_ID, $RawVoterID, $UniqNYSVoterID, $ADED, $StateAbbrev,  $Party, $VoterCount = 0) {
		$sql = "UPDATE SystemUser SET Voters_UniqStateVoterID = :NYSVoterID, SystemUser_EDAD = :EDAD, SystemUser_Party = :Party, " . 
						"Voters_ID = :Index, SystemUser_StateAbbrev = :Abbrev ";
		$sql_vars = array("NYSVoterID" => $UniqNYSVoterID,"EDAD" => $ADED, "ID" => $SystemUser_ID, "Party" => $Party, 
											"Index" => $RawVoterID, "Abbrev" => $StateAbbrev);

		if ($VoterCount > 0) {
			$sql .= ", SystemUser_NumVoters = :CountVoters ";
			$sql_vars["CountVoters"] = $VoterCount;
		}
		
		$sql .= "WHERE SystemUser_ID = :ID ";
		return $this->_return_nothing($sql, $sql_vars);				
	}

	function OtherCandidateCoupled($Party) {
		$sql = "SELECT * FROM Candidate WHERE CandidateElection_DBTable != :DBTable AND CandidateElection_DBTable != :DBTable2 " . 
						"AND CandidateElection_DBTable IS NOT NULL AND Candidate_Party = :Party";
		$sql_vars = array("DBTable" => "EDAD", "DBTable2" => "BROKEN", "Party" => $Party);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function UpdateCandidateCounterForVoter($Candidate_ID, $Counter) {
		$sql = "UPDATE Candidate SET Candidate_StatsVoters = :Counter WHERE Candidate_ID = :CandidateID";
		$sql_vars = array("Counter" => $Counter, "CandidateID" => $Candidate_ID);
		return $this->_return_nothing($sql, $sql_vars);
	}
	
	function UpdateElectionCounterForVoter($Election_ID, $Counter) {
		$sql = "UPDATE CandidateElection SET CandidateElection_CountVoter = :Counter WHERE CandidateElection_ID = :CandidateElection_ID";
		$sql_vars = array("Counter" => $Counter, "CandidateElection_ID" => $Election_ID);
		return $this->_return_nothing($sql, $sql_vars);
	}		
	
	// This will need to be changed later.
	function GetVotersIndexesIDfromNYSCode($NYSCode) {
		$sql = "SELECT * FROM VotersIndexes WHERE VotersIndexes_UniqNYSVoterID = :NYSCode ORDER BY VotersIndexes_ID LIMIT 1";
		$sql_vars = array("NYSCode" => $NYSCode);
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function GetCountyFromNYSCodes($CountyCode) {
		$sql = "SELECT * FROM DataCounty WHERE DataCounty_ID = :CountyCode";
		return $this->_return_simple($sql, array("CountyCode" => $CountyCode));
	}
	
	function DB_WorkCounty($CountyID) {
		$County = $this->GetCountyFromNYSCodes($CountyID);
		return $County["DataCounty_Name"];	
	}

	/* This is for the search of the $VI in the other file */
	function SearchVotersIndexesDB($ArrIndexes) {

		if ( empty ($ArrIndexes)) return 0;
		$sql_index = "";

		foreach ($ArrIndexes as $var) {
			if ( ! empty ($var)) {
				if ( ! empty ($sql_index)) { $sql_index .= " OR "; }
				$sql_index .= "VotersIndexes.VotersIndexes_ID = '" . $var . "'";
			}
		}
	
		$sql = "SELECT * FROM VotersIndexes " .
						"LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID ) " . 
						"LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID ) " .
						#"LEFT JOIN Raw_Voter ON (Raw_Voter.Raw_Voter_UniqNYSVoterID = VotersIndexes.VotersIndexes_UniqNYSVoterID) " . 
						#"LEFT JOIN " . $TableVoter . " ON (" . ".Raw_Voter_UniqNYSVoterID = VotersIndexes.VotersIndexes_UniqNYSVoterID) " .		
						"WHERE " . $sql_index;
		
		return $this->_return_multiple($sql);		
	}
	
	Function GetWalkSheetInfo ($DataDistrictID) {
		if ( $DataDistrictID > 0 ) {
			$sql = "SELECT * FROM DataDistrict " .
						"LEFT JOIN DataDistrictTemporal ON " . 
						"(DataDistrictTemporal.DataDistrict_ID = DataDistrict.DataDistrict_ID) " .
						"LEFT JOIN DataDistrictCycle ON " .
						"(DataDistrictCycle.DataDistrictCycle_ID = DataDistrictTemporal.DataDistrictCycle_ID) " . 
						"WHERE DataDistrict.DataDistrict_ID = :District";
			$sql_vars = array("District" => $DataDistrictID);
			return $this->_return_multiple($sql, $sql_vars);					
		}		
	}
	
	
	function ListEDByDistricts($DistrictType, $DistrictValue, $DistrictCycle = '2')	{
		$sql = "SELECT DISTINCT DataDistrict_Electoral AS ED, DataDistrict_StateAssembly AS AD ";
	
		switch ($DistrictType) {
			case "AD":
				$sql .= ", DataDistrict_StateAssembly AS District ";
				$sql_vars = array("CycleID" => $DistrictCycle, "AD" => $DistrictValue);
				$sql_query = "AND DataDistrict_StateAssembly = :AD ";
				break;
			
			case "CG":
				$sql .= ", DataDistrict_Congress AS District ";
				$sql_vars = array("CycleID" => $DistrictCycle, "CG" => $DistrictValue);
				$sql_query = "AND DataDistrict_Congress = :CG ";
				break;
				
			case "SN":
				$sql .= ", DataDistrict_SenateSenate AS District ";
				$sql_vars = array("CycleID" => $DistrictCycle, "SN" => $DistrictValue);
				$sql_query = "AND DataDistrict_SenateSenate = :SN ";
				break;
		}
		
		$sql .= "FROM DataDistrict " . 
						"LEFT JOIN DataDistrictTemporal ON " . 
						"(DataDistrictTemporal.DataDistrict_ID = DataDistrict.DataDistrict_ID) " .
						"LEFT JOIN DataDistrictCycle ON " .
						"(DataDistrictCycle.DataDistrictCycle_ID = DataDistrictTemporal.DataDistrictCycle_ID) ";
		
		$sql .= "WHERE DataDistrictCycle.DataDistrictCycle_ID = :CycleID ";
		$sql .= $sql_query;		
		$sql .= "ORDER BY DataDistrict_StateAssembly, DataDistrict_Electoral";
	
		return $this->_return_multiple($sql, $sql_vars);
	}
		
	function SearchUserVoterCard($SystemUserID) {
		$sql = "SELECT * FROM SystemUser " .
						"LEFT JOIN Voters ON (Voters.Voters_ID = SystemUser.Voters_ID) " . 
						"LEFT JOIN VotersIndexes ON (VotersIndexes.VotersIndexes_ID = Voters.VotersIndexes_ID) " .
						"LEFT JOIN DataLastName ON (DataLastName.DataLastName_ID = VotersIndexes.DataLastName_ID) " .  
						"LEFT JOIN DataFirstName ON (DataFirstName.DataFirstName_ID = VotersIndexes.DataFirstName_ID) " .  
						"LEFT JOIN DataMiddleName ON (DataMiddleName.DataMiddleName_ID = VotersIndexes.DataMiddleName_ID) " .
						"LEFT JOIN DataHouse ON (Voters.DataHouse_ID = DataHouse.DataHouse_ID) " .
						"LEFT JOIN DataAddress ON (DataAddress.DataAddress_ID = DataHouse.DataAddress_ID) " .
						"LEFT JOIN DataStreet ON (DataAddress.DataStreet_ID = DataStreet.DataStreet_ID) " .
						"LEFT JOIN DataCity ON (DataCity.DataCity_ID = DataAddress.DataCity_ID) " .
						"LEFT JOIN DataDistrictTemporal on (DataHouse.DataHouse_ID = DataDistrictTemporal.DataHouse_ID) " .
						"LEFT JOIN DataDistrictCycle on (DataDistrictTemporal.DataDistrictCycle_ID = DataDistrictCycle.DataDistrictCycle_ID) " .
						"LEFT JOIN DataDistrict ON (DataDistrictTemporal.DataDistrict_ID = DataDistrict.DataDistrict_ID) " .		
						"LEFT JOIN DataCounty ON (DataDistrict.DataCounty_ID = DataCounty.DataCounty_ID) " .
						"LEFT JOIN DataState ON (DataState.DataState_ID = DataCounty.DataState_ID) " .
						"LEFT JOIN DataDistrictTown ON (DataDistrictTown.DataDistrictTown_ID = DataHouse.DataDistrictTown_ID) " . 
						"LEFT JOIN SystemUserSelfDistrict ON (SystemUser.SystemUser_ID = SystemUserSelfDistrict.SystemUser_ID) " . 
						"WHERE SystemUser.SystemUser_ID = :SystemID AND " .
						"(CURDATE() >= DataDistrictCycle_CycleStartDate AND CURDATE() <= DataDistrictCycle_CycleEndDate) IS NULL";
		$sql_vars = array("SystemID" => $SystemUserID);		
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function UpdateSystemSetPriv($SystemUserID, $PrivModification) {
		if ( $SystemUserID > 0 ) {
			$sql = "UPDATE SystemUser SET SystemUser_Priv = :AddPriv WHERE SystemUser_ID = :SystemID";
			$sql_vars = array("SystemID" => $SystemUserID, "AddPriv" => $PrivModification);
			return $this->_return_nothing($sql, $sql_vars);
		}
	}
	
	function UpdateSystemPriv($SystemUserID, $PrivModification) {
		if ( $SystemUserID > 0 ) {
			$sql = "UPDATE SystemUser SET SystemUser_Priv = SystemUser_Priv";
			
			if ($PrivModification >= 0) {
				$sql .= " | ";
			} else {
				$sql .= " & ~";
			}
						 
			$sql .= ":AddPriv WHERE SystemUser_ID = :SystemID";
			$sql_vars = array("SystemID" => $SystemUserID, "AddPriv" => $PrivModification);
			return $this->_return_nothing($sql, $sql_vars);
		}
	}
	
	function CreateSystemUserAndUpdateProfile($TempEmail, $ProfileArray = "", $Person = "") {
		
		$sql = "INSERT INTO SystemUser (SystemUser_email, SystemUser_emailverified, SystemUser_username, SystemUser_password, " . 
																		"SystemUser_emaillinkid, SystemUser_createtime, SystemUser_lastlogintime, SystemUser_Priv"; 
		$sql_vars = array("TempEmail" => $TempEmail);
																		
		if ( ! empty ($ProfileArray["Change"]["SystemUser_FirstName"])) { $sql .= ", SystemUser_FirstName"; $sql_vars["FirstName"] = $ProfileArray["Change"]["SystemUser_FirstName"]; }
		if ( ! empty ($ProfileArray["Change"]["SystemUser_LastName"])) { $sql .= ", SystemUser_LastName"; $sql_vars["LastName"] = $ProfileArray["Change"]["SystemUser_LastName"]; }
																		
		$sql .= ") " .
					 "SELECT SystemUserTemporary_email, SystemUserTemporary_emailverified, SystemUserTemporary_username, " . 
									"SystemUserTemporary_password, SystemUserTemporary_emaillinkid, NOW(), NOW(), " . (PERM_MENU_PROFILE + PERM_MENU_SUMMARY /*+ PERM_MENU_DOCU */);
									
		if ( ! empty ($ProfileArray["Change"]["SystemUser_FirstName"])) { $sql .= ", :FirstName"; }
		if ( ! empty ($ProfileArray["Change"]["SystemUser_LastName"])) { $sql .= ", :LastName"; }
									
		$sql .= " FROM SystemUserTemporary WHERE SystemUserTemporary_email = :TempEmail"; 
		$this->_return_nothing($sql, $sql_vars);		
	
		$sql = "SELECT LAST_INSERT_ID() as SystemUser_ID";
		$ret = $this->_return_simple($sql);

		$sql = "UPDATE SystemUserTemporary SET SystemUser_ID = :SystemUserID,  SystemUserTemporary_password = null, SystemUserTemporary_emaillinkid = null WHERE SystemUserTemporary_email = :TempEmail"; 
		$sql_vars = array("TempEmail" => $TempEmail, "SystemUserID" => $ret["SystemUser_ID"]);
		$this->_return_nothing($sql, $sql_vars);	
		
		$this->SaveInscriptionRecord ($TempEmail, $Username, "convert", $ret["SystemUser_ID"]);	
		return $this->FindPersonUserProfile($ret["SystemUser_ID"]);
		
	}
	
	function SaveInscriptionRecord ($Email, $Username, $Type = "Other", $SystemUserID = NULL) {
		$sql = "INSERT INTO SystemUserVoter SET SystemUserVoter_Username = :Username, " .
						"SystemUserVoter_Email = :Email, SystemUserVoter_action = :Type, " . 
						"SystemUserVoter_Date = NOW(), SystemUserVoter_IP = :IP, SystemUser_ID = :SystemUserID";
		$sql_vars = array('Email' => $Email, 'Username' => $Username, 'Type' => $Type, 'IP' => $_SERVER['REMOTE_ADDR'], 'SystemUserID' => $SystemUserID);
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	
	function SearchUsers($UserID = NULL) {	
		$sql = "SELECT * FROM SystemUser";
		
		if ( ! empty ($UserID)) {
			$sql .= " WHERE SystemUser_ID = :UserID";
			$sql_vars = array ("UserID" => $UserID);
			return $this->_return_simple($sql, $sql_vars);
		}
		
		return $this->_return_multiple($sql);
	}	
	
	function SearchTempUsers($UserID = NULL) {	
		$sql = "SELECT * FROM SystemUserTemporary";
		
		if ( ! empty ($UserID)) {
			$sql .= " WHERE SystemUserTemporary_ID = :UserID";
			$sql_vars = array ("UserID" => $UserID);
			return $this->_return_simple($sql, $sql_vars);
		}
		
		return $this->_return_multiple($sql);
	}	
	
	function UpdateTempDistrict($Type, $SystemUser_ID, $AD, $ED, $CG, $SN, $SystemID = NULL) {
		
		switch($Type) {
			case "insert":
				$sql = "INSERT INTO SystemUserSelfDistrict SET ";
				break;
				
			case "update":
				$sql = "UPDATE SystemUserSelfDistrict SET ";
				$sql_end = " WHERE SystemUserSelfDistrict_ID = :SysDisID";
				$sql_vars = array("SysDisID" => $SystemID);
				break;
		}
	
		// There will be a bug to fix which is how to delete an entry. - Need to think about it.
		if (empty ($sql)) return $this->FindTemporaryDistrict($SystemUserID);			
		if (! empty ($AD)) { $sql .= "SystemUserSelfDistrict_AD = :AD"; $sql_vars["AD"] = intval($AD); $comma = 1;}
		if ($comma == 1) { $sql .= ", "; $comma = 0; }
		if (! empty ($ED)) { $sql .= "SystemUserSelfDistrict_ED = :ED"; $sql_vars["ED"] = intval($ED); $comma = 1;}
		if ($comma == 1) { $sql .= ", "; $comma = 0; }
		if (! empty ($CG)) { $sql .= "SystemUserSelfDistrict_CG = :CG"; $sql_vars["CG"] = intval($CG); $comma = 1;}
		if ($comma == 1) { $sql .= ", "; $comma = 0; }
		if (! empty ($SN)) { $sql .= "SystemUserSelfDistrict_SN = :SN"; $sql_vars["SN"] = intval($SN); $comma = 1;}
		if ($comma == 1) { $sql .= ", "; $comma = 0; }		
		if (! empty ($SystemUser_ID)) { $sql .= "SystemUser_ID = :SystemUser_ID"; $sql_vars["SystemUser_ID"] = $SystemUser_ID;}

		$sql .= $sql_end;
		return $this->_return_nothing($sql, $sql_vars);
	}
	
	function FindTemporaryDistrict($SystemUserID) {
		$sql = "SELECT * FROM SystemUserSelfDistrict WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array("SystemUserID" => $SystemUserID);
		return $this->_return_simple($sql, $sql_vars);
	}
	
	
	function ReturnPrivCodes () {
		$sql = "SELECT * FROM AdminCode";
		return $this->_return_multiple($sql);
	}	
	
	
	/* Custom SQL Statement to minimize the number of question based on logic. */
		
	// The input is an array with array of stuff that changed + Person is the stuff coming
	// from FindPersonUserProfile. If populate I won't have to call it again. 
	// If there is a field called Change, then we change those field in SystemUser
	
	function UpdatePersonUserProfile($SystemUserID, $ProfArray = "", $Person = "") {
		
		// This is for the normal information.
		if ( ! empty ($ProfArray["Change"])) {
			$add_coma = 0;
			$sql_vars = array("SystemUser" => $SystemUserID);

			$sql = "UPDATE SystemUser SET ";
			if ( ! empty ($ProfArray["Change"]["SystemUser_FirstName"] )) {
				$sql .= "SystemUser_FirstName = :FirstName";
				$sql_vars["FirstName"] = $ProfArray["Change"]["SystemUser_FirstName"];
				$add_coma = 1;
				$Person["SystemUser_FirstName"] = $ProfArray["Change"]["SystemUser_FirstName"];
			}

			if ( ! empty ($ProfArray["Change"]["SystemUser_LastName"] )) {
				if ( $add_coma == 1 ) { $sql .= ", "; }
				$sql .= "SystemUser_LastName = :LastName";
				$sql_vars["LastName"] = $ProfArray["Change"]["SystemUser_LastName"];
				$add_coma = 1;
				$Person["SystemUser_LastName"] = $ProfArray["Change"]["SystemUser_LastName"];
			}
			
			$sql .= " WHERE SystemUser_ID = :SystemUser";
			
			$this->_return_nothing($sql, $sql_vars);
		}
		
		// This is the rest of the BIO, we'll need to create a for loop.
		// This also make the assumption that 
		
		if ( empty ($Person["SystemUserProfile_ID"])) {
			$sql = "INSERT INTO SystemUserProfile SET ";
		} else {
			$sql = "UPDATE SystemUserProfile SET ";
		}
		
		$add_coma = 0;
		$sql_vars = array();
		if ( ! empty ($ProfArray["bio"])) {
			$sql .= "SystemUserProfile_bio = :bio ";
			$sql_vars["bio"] = $ProfArray["bio"];
			$add_coma = 1;
			$Person["SystemUserProfile_bio"] = $ProfArray["bio"];
		}
		
		if ( ! empty ($ProfArray["URL"])) {
			if ( $add_coma == 1 ) { $sql .= ", "; }
			$sql .= "SystemUserProfile_URL = :URL ";
			$sql_vars["URL"] = $ProfArray["URL"];
			$add_coma = 1;
			$Person["SystemUserProfile_URL"] = $ProfArray["URL"];
		}
		
		if ( ! empty ($ProfArray["Location"])) {
			if ( $add_coma == 1 ) { $sql .= ", "; }
			$sql .= "SystemUserProfile_Location = :Location ";
			$sql_vars["Location"] = $ProfArray["Location"];
			$add_coma = 1;
			$Person["SystemUserProfile_Location"] = $ProfArray["Location"];
		}
	
		if ( $add_coma == 1) {
	
			if ( ! empty ($Person["SystemUserProfile_ID"])) {	
				$sql .= "WHERE SystemUserProfile_ID = :SystemProfileID";
				
				$sql_vars["SystemProfileID"] = $Person["SystemUserProfile_ID"];
				$this->_return_nothing($sql, $sql_vars);
				
			} else {
				
				$this->_return_nothing($sql, $sql_vars);
				$sql = "SELECT LAST_INSERT_ID() as SystemUserProfile_ID";
				$ret = $this->_return_simple($sql);
			}
		}	

		// Check that email is not double.
		if ( ! empty ($ProfArray["Special"]["SystemUser_email"])) {
			$ret_email = $this->CheckRegisterEmail ($ProfArray["Special"]["SystemUser_email"]);
			if ( empty ($ret_email)) {
				$Person["ChangeEmail"] = 1;
				$ChangeEmailOK = 1;
			} else {
				$Person["ChangeEmail"] = -1;
				$Person["EmailToChangeTo"] = $ProfArray["Special"]["SystemUser_email"];
				$ChangeEmailOK = 0;
			}
		}			

		if ( $ChangeEmailOK == 1 || empty ($Person["SystemUserProfile_ID"])) {						
			$add_coma = 0;		
			// This is to deal with the complicate stuff.
			$sql = "UPDATE SystemUser SET ";
			$sql_vars = array("SystemID" => $SystemUserID);
		
			if ( empty ($Person["SystemUserProfile_ID"])) {
				// Update the profile
				$sql .= "SystemUserProfile_ID = :SystemUserProfileID ";
				$sql_vars["SystemUserProfileID"] = $ret["SystemUserProfile_ID"];	
				$add_coma = 1;
			}
			
			if ( $ChangeEmailOK == 1 ) {
				if ( $add_coma == 1 ) { $sql .= ", "; }
				$sql .= "SystemUser_email = :SystemEmail, SystemUser_emailverified = 'no', " .
								"SystemUser_emaillinkid = :EmailLinkID ";
				
				$sql_vars["EmailLinkID"] = $ProfArray["Special"]["SystemUser_emaillinkid"];
				$sql_vars["SystemEmail"] = $ProfArray["Special"]["SystemUser_email"];	
				$add_coma = 1;
			}			

			$sql .= "WHERE SystemUser_ID = :SystemID";	
			$this->_return_nothing($sql, $sql_vars);
					
			if ($ChangeEmailOK == 1) {
				$this->AddIntoOldEmailTable($ProfArray["Special"]["SystemUser_email"], $Person["SystemUser_email"], 
																		$Person["SystemUser_emailverified"], $SystemUserID);				
				$Person["SystemUser_email"] = $ProfArray["Special"]["SystemUser_email"];
				$Person["SystemUser_emailverified"] = 'no';
				$Person["SystemUser_emaillinkid"] = $ProfArray["Special"]["SystemUser_emaillinkid"];
			}
		}
		
		if ( empty ($Person["SystemUserProfile_ID"])) {
			$Person["SystemUserProfile_ID"] = $ret["SystemUserProfile_ID"];
		}
		 
		return $Person;
	}
}

?>

